<script>
    $(document).ready(function(){
        $("#myModal").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            $.get( "/entSales/checkout/modal/" + id, function( data ) {
                $(".modal-body").html(data.html);
            });

        });
    });
</script>


your view
<table class="table no-margin text-center">
    <thead>
    <tr>
        <th>Society ID</th>
        <th>Society Name</th>
        <th>Address</th>
        <th>Secretary Name</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($societydetails as $sd)
    <tr>
        <td>{{ $sd->societyid }}</td>
        <td>{{ $sd->societyname }}</td>
        <td>{{ $sd->address }}</td>
        <td>{{ $sd->secretaryname }}</td>
        <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target-id="1" data-target="#myModal">View All Details</button></td>
    </tr>
    @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>

            <div class="modal-body">

            </div>


        </div>
    </div>
</div>