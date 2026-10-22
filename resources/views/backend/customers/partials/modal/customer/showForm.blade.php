<form action="{{ route('backend.reports.pdf_export_customers')}}" method="GET" data-ajax enctype="multipart/form-data">

    <div class="container pl-0 pr-0">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCustomerExportModal">PDF Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container pl-0 pr-0">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="subject" class="active">Titel</label>
                            <input id="title" type="text" value="" class="form-control" required name="title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="subject" class="active">Autor</label>
                            <input id="author" type="text" class="form-control" name="author">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="subject" class="active">Dateiname</label>
                            <input id="filename" type="text" class="form-control" name="filename">
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Abbrechen</button>
                <button id="download" type="submit" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>

</form>
<script>
    $(document).ready(function(){


        $('#download').click(function(e){

            $('<input>', {
                type: 'hidden',
                id: 'author',
                name: 'author',
                value: $('#author').val(),
            }).appendTo('#filter_customSearch');

            $('<input>', {
                type: 'hidden',
                id: 'filename',
                name: 'filename',
                value: $('#filename').val(),
            }).appendTo('#filter_customSearch');


            $('<input>', {
                type: 'hidden',
                id: 'title',
                name: 'title',
                value: $('#title').val(),
            }).appendTo('#filter_customSearch');


            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('backend/reports/reports/customerExportPDF') }}",
                method: 'GET',

                data: $('#filter').serializeArray(),
                xhrFields: {
                    responseType: 'blob'
                },

                success: function(data){
                    var blob = new Blob([data]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = $('#filename').val() ? $('#filename').val()+'.pdf' : 'Institut_Export' + ".pdf";
                    link.click();
                    $("#showCustomerExportModal").modal('hide');
                }});
        });
    });
</script>