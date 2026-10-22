<form action="{{ route('backend.reports.imports.balance_customer')}}" method="POST" data-ajax enctype="multipart/form-data">

    <div class="container pl-0 pr-0">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCustomerExportModal">Import - Bilanzsumme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container pl-0 pr-0">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="file" class="form-label">Excel Datei</label>
                            <input class="form-control" type="file" id="file" name="file">
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