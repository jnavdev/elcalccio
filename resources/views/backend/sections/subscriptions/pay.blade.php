<div class="modal fade" tabindex="-1" aria-hidden="true" id="payModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pagar suscripcion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" name="subscription_id" id="subscription_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Generar siguiente suscripcion?</strong>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="next_subscription" id="next_subscription_yes" value="1" checked>
                                <label class="form-check-label" for="next_subscription_yes">
                                    Si
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="next_subscription" id="next_subscription_no" value="0">
                                <label class="form-check-label" for="next_subscription_no">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="buttonPay">Pagar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
