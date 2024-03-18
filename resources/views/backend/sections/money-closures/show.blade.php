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
                        <ul class="list-group">
                            <li class="list-group-item active" id="detail_date"></li>
                            <li class="list-group-item active" id="detail_stadium"></li>
                            <li class="list-group-item active" id="detail_user"></li>
                        </ul>

                        <table class="table table-bordered mt-3">
                            <thead>
                            <tr>
                                <th>Total Efectivo Recaudado</th>
                                <th>Total Efectivo Real</th>
                                <th class="w-25">Cuadrado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="table_cash"></tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Total Transferencias Recaudado</th>
                                <th>Total Transferencias Real</th>
                                <th class="w-25">Cuadrado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="table_transfer"></tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Total Debito Recaudado</th>
                                <th>Total Debito Real</th>
                                <th class="w-25">Cuadrado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="table_debt"></tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Total Credito Recaudado</th>
                                <th>Total Credito Real</th>
                                <th class="w-25">Cuadrado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="table_credit"></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
