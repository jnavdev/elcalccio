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
                    <div class="col-md-6">
                        <h5><span class="badge badge-primary">Cliente</span></h5>

                        <ul class="list-group">
                            <li class="list-group-item" id="detail_user_name"></li>
                            <li class="list-group-item" id="detail_user_rut"></li>
                            <li class="list-group-item" id="detail_user_phone"></li>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h5><span class="badge badge-primary">Información</span></h5>

                        <ul class="list-group">
                            <li class="list-group-item" id="detail_stadium_name"></li>
                            <li class="list-group-item" id="detail_reservation_payment_media"></li>
                            <li class="list-group-item" id="detail_reservation_state"></li>
                        </ul>
                    </div>
                </div>

                <h5 class="mt-4"><span class="badge badge-primary">Horas</span></h5>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                    </tr>
                    </thead>

                    <tbody id="detail_tbody_hours"></tbody>
                </table>

                <h5 class="mt-2"><span class="badge badge-primary">Pago</span></h5>

                <ul class="list-group">
                    <li class="list-group-item" id="detail_discount"></li>
                    <li class="list-group-item" id="detail_advancement"></li>
                    <li class="list-group-item" id="detail_total"></li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
