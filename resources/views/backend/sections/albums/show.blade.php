<div class="modal fade" tabindex="-1" aria-hidden="true" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5><span class="badge badge-primary">Album</span></h5>

                        <ul class="list-group">
                            <li class="list-group-item" id="detail_title"></li>
                            <li class="list-group-item" id="detail_description"></li>
                            <li class="list-group-item" id="detail_date"></li>
                        </ul>

                        <h5 class="mt-3"><span class="badge badge-primary">Fotos</span></h5>

                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="detail_photos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
