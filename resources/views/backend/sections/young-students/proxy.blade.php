<div class="modal fade" tabindex="-1" aria-hidden="true" id="proxyModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apoderado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" name="proxy_id" id="proxy_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proxy_full_name">Nombre completo</label>
                                <input type="text" name="proxy_full_name" id="proxy_full_name" class="form-control" placeholder="Ingrese nombre completo">
                                <span class="ajax-error" id="error_full_name" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proxy_rut">RUT</label>
                                <input type="text" name="proxy_rut" id="proxy_rut" class="form-control" placeholder="Ingrese RUT">
                                <span class="ajax-error" id="error_rut" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proxy_email">Email</label>
                                <input type="email" name="proxy_email" id="proxy_email" class="form-control" placeholder="Ingrese email">
                                <span class="ajax-error" id="error_email" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proxy_relationship">Parentesco</label>
                                <input type="text" name="proxy_relationship" id="proxy_relationship" class="form-control" placeholder="Ingrese parentesco">
                                <span class="ajax-error" id="error_relationship" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proxy_phone">Fono</label>
                                <input type="text" name="proxy_phone" id="proxy_phone" class="form-control" placeholder="Ingrese fono">
                                <span class="ajax-error" id="error_phone" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proxy_commune_id">Ciudad</label>
                                <select name="proxy_commune_id" id="proxy_commune_id" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($communes as $commune)
                                        <option value="{{ $commune->id }}">
                                            {{ $commune->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ajax-error" id="error_commune_id" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proxy_address">Direccion</label>
                                <input type="text" name="proxy_address" id="proxy_address" class="form-control" placeholder="Ingrese direccion">
                                <span class="ajax-error" id="error_address" style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; display: none;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="buttonUpdateProxy">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
