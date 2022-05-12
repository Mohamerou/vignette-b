<?php

namespace App\Services;

use Google_Client;
use GuzzleHttp\Client;
use Google_Service_Sheets;
use Google\Service\Sheets\AppendValuesResponse;
use Google\Service\Sheets\BatchGetValuesResponse;
use Google\Service\Sheets\BatchUpdateSpreadsheetResponse;
use Google\Service\Sheets\BatchUpdateValuesResponse;
use Google\Service\Sheets\Resource\Spreadsheets;
use Google\Service\Sheets\Resource\SpreadsheetsValues;
use Google\Service\Sheets\Sheet;
use Google\Service\Sheets\Spreadsheet;
use Google\Service\Sheets\UpdateValuesResponse;
use Google\Service\Sheets\ValueRange;




class SheetService
{
    private $spreadSheetId;
    private $client;
    private $googleSheetService;

    public function __construct()
    {

        // parent::__construct($client);
        // $this->rootUrl          = $rootUrl ?: 'https://sheets.googleapis.com/';
        // $this->servicePath      = '';
        // $this->batchPath        = 'batch';
        // $this->version          = 'v4';
        // $this->serviceName      = 'sheets';

        $this->spreadSheetId    = config('googleSheet.google_sheet_id');
        // dd($this->spreadSheetId);
        $this->client           = new Google_client();
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->setScopes("https://www.googleapis.com/auth/spreadsheets");

        $this->googleSheetService = new Google_Service_Sheets($this->client);
    }
    

    public function readGoogleSheet()
    {
        $dimesions  = $this->getDimensions($this->spreadSheetId);
        $range      = 'chassie-test!A1';

        $data       = $this->googleSheetService
                            ->spreadsheets_values
                            ->batchGet($this->spreadSheetId, ['ranges' => $range]);
        return $data;
    }    

    public function saveDataToSheet(array $data)
    {
        $dimesions  = $this->getDimensions($this->spreadSheetId);
        
        $body       = new ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range  = "chassie-test!A1";

        return $this->googleSheetService
                    ->spreadsheets_values
                    ->update($this->spreadSheetId, $range, $body, $params);
    }


    private function getDimensions($spreadSheetId)
    {
        $rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => 'chassie-test!A:A','majorDimension'=>'COLUMNS']
        );

        //if data is present at nth row, it will return array till nth row
        //if all column values are empty, it returns null
        $rowMeta = $rowDimensions->getValueRanges()[0]->values;
        if (! $rowMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        $colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
            $spreadSheetId,
            ['ranges' => 'chassie-test!1:1','majorDimension'=>'ROWS']
        );
        
        //if data is present at nth col, it will return array till nth col
        //if all column values are empty, it returns null
        $colMeta = $colDimensions->getValueRanges()[0]->values;
        if (! $colMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        return [
            'error' => false,
            'rowCount' => count($rowMeta[0]),
            'colCount' => $this->colLengthToColumnAddress(count($colMeta[0]))
        ];
    }


    public  function colLengthToColumnAddress($number)
    {
        if ($number <= 0) return null;

        $temp; $letter = '';
        while ($number > 0) {
            $temp = ($number - 1) % 26;
            $letter = chr($temp + 65) . $letter;
            $number = ($number - $temp - 1) / 26;
        }
        return $letter;
    }


}
