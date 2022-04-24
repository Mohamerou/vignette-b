<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}
/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}
/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}
/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}
/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}
/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}
/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}
/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}
/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}
/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}
/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}
/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */
/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}
    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
      .primary{
  background: #ffc0d0;
}
.bg_white{
  background: #ffffff;
}
.bg_light{
  background: #fafafa;
}
.bg_black{
  background: #000000;
}
.bg_dark{
  background: rgba(0,0,0,.8);
}
.email-section{
  padding:2.5em;
}
/*BUTTON*/
.btn{
  padding: 5px 20px;
  display: inline-block;
}
.btn.btn-primary{
  border-radius: 5px;
  background: #ffc0d0;
  color: #ffffff;
}
.btn.btn-white{
  border-radius: 5px;
  background: #ffffff;
  color: #000000;
}
.btn.btn-white-outline{
  border-radius: 5px;
  background: transparent;
  border: 1px solid #fff;
  color: #fff;
}
.btn.btn-black{
  border-radius: 0px;
  background: #000;
  color: #fff;
}
.btn.btn-black-outline{
  border-radius: 0px;
  background: transparent;
  border: 2px solid #000;
  color: #000;
  font-weight: 700;
}
h1,h2,h3,h4,h5,h6,p,li{
  font-family: 'Playfair Display', sans-serif;
  color: #000000;
  margin-top: 0;
  font-weight: 400;
}
body{
  font-family: 'Lato', sans-serif;
  font-weight: 400;
  font-size: 15px;
  line-height: 1.8;
  color: rgba(0,0,0,.5);
}
a{
  color: #fcc0d0 !important;
}
table{
}
/*LOGO*/
.logo h1{
  margin: 0;
}
.logo h1 a{
  color: #000000;
  font-size: 30px;
  font-weight: 700;
  /*text-transform: uppercase;*/
  font-family: 'Playfair Display', sans-serif;
  font-style: italic;
}
.navigation{
  padding: 0;
  padding: 1em 0;
  /*background: rgba(0,0,0,1);*/
  border-top: 1px solid rgba(0,0,0,.05);
  border-bottom: 1px solid rgba(0,0,0,.05);
  margin-bottom: 0;
}
.navigation li{
  list-style: none;
  display: inline-block;;
  margin-left: 5px;
  margin-right: 5px;
  font-size: 13px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 2px;
}
.navigation li a{
  color: rgba(0,0,0,1);
}
/*HERO*/
.hero{
  position: relative;
  z-index: 0;
}
.hero .overlay{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  content: '';
  width: 100%;
  background: #000000;
  z-index: -1;
  opacity: .2;
}
.hero .text{
  color: rgba(255,255,255,.9);
  max-width: 50%;
  margin: 0 auto 0;
}
.hero .text h2{
  color: #fff;
  font-size: 30px;
  margin-bottom: 0;
  font-weight: 300;
  line-height: 1.4;
}
.hero .text h2 span{
  font-weight: 600;
  color: #ffc0d0;
}
/*INTRO*/
.intro{
  position: relative;
  z-index: 0;
}
.intro .text{
  color: rgba(0,0,0,.3);
}
.intro .text h2{
  color: #000;
  font-size: 34px;
  margin-bottom: 0;
  font-weight: 300;
}
.intro .text h2 span{
  font-weight: 600;
  color: #ffc0d0;
}
/*PRODUCT*/
.text-product{
}
.text-product .price{
  font-size: 20px;
  color: #fff;
  display: inline-block;;
  margin-bottom: 1em;
  border: 2px solid #fff;
  padding: 0 10px;
}
.text-product h2{
  font-family: 'Lato', sans-serif;
}
/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
  color: #000000;
  font-size: 28px;
  margin-top: 0;
  line-height: 1.4;
  font-weight: 400;
}
.heading-section .subheading{
  margin-bottom: 20px !important;
  display: inline-block;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(0,0,0,.4);
  position: relative;
}
.heading-section .subheading::after{
  position: absolute;
  left: 0;
  right: 0;
  bottom: -10px;
  content: '';
  width: 100%;
  height: 2px;
  background: #ffc0d0;
  margin: 0 auto;
}
.heading-section-white{
  color: rgba(255,255,255,.8);
}
.heading-section-white h2{
  font-family: 
  line-height: 1;
  padding-bottom: 0;
}
.heading-section-white h2{
  color: #ffffff;
}
.heading-section-white .subheading{
  margin-bottom: 0;
  display: inline-block;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(255,255,255,.4);
}
ul.social{
  padding: 0;
}
ul.social li{
  display: inline-block;
  margin-right: 10px;
}
/*FOOTER*/
.footer{
  border-top: 1px solid rgba(0,0,0,.05);
  color: rgba(0,0,0,.5);
}
.footer .heading{
  color: #000;
  font-size: 20px;
}
.footer ul{
  margin: 0;
  padding: 0;
}
.footer ul li{
  list-style: none;
  margin-bottom: 10px;
}
.footer ul li a{
  color: rgba(0,0,0,1);
}
@media screen and (max-width: 500px) {
}
li {
  list-style: '*_ ' !important;
}
    </style>


</head>

<body>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
      <!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
          <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td class="logo" style="text-align: center;">
                  <h1><a href="/"><img width="auto"; height="100px;" src="{{ asset('images/logo.png') }}"></a></h1>
                </td>
              </tr>
            </table>
          </td>
        </tr><!-- end tr -->
        <tr>
        <tr>
          <td valign="middle" class="intro bg_white" style="padding: 2em 0 4em 0;">
            <table>
              <tr>
                <td>
                  <div class="text" style="padding: 0 2.5em; text-align: left;">
                    <h4>Bienvenue, {{ $compte_data["fullname"] }}!</h4>
                    <p style="margin-top: 2em;">
  Les informations liees a votre compte.<br>
  INFOS COMPTE:
  <ul>
    <li>Email : {{ $compte_data['email']}}</li>
    <li>Mot de passe : {{ $compte_data['password']}}</li>
  </ul> 
</p>

<!-- <p class="h6">
  Pour acceder a votre compte, veuillez cliquer sur le lien   <i class="fa fa-arrow-right ms-3"></i>, <a style="color: #f11 !important;
" href="http://127.0.0.1:8000/adminsh">Page de connexion</a>
</p> -->

<p class="h6">Bien cordialement,</p>


      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
        <tr>
          <td class="bg_light" style="text-align: center;">
            {{-- <p>Ne plus recevoir d'email?<a href="#" style="color: rgba(0,0,0,.3) !important;"> Desouscrire ici</a></p> --}}
          </td>
        </tr>
      </table>

    </div>
  </center>
</body>
</html>