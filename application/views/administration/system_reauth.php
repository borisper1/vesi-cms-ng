<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="modal fade" id="system_reauth_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-lock"></i> Autenticazione richiesta</h4>
            </div>

            <div class="modal-body">
                <p>E' necessario autenticarsi per eseguire questa operazione.</p>
                <div class="input-group" id="system_reauth_pinputg">
                    <span class="input-group-addon"><i class="fa fa-lg fa-fw fa-lock"></i></span>
                    <input type="password" id="system_reauth_password" class="form-control" placeholder="Password">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-ban"></i> Annulla</button>
                <button type="button" class="btn btn-primary" id="system_reauth_ok"><i class="fa fa-check"></i> OK</button>
            </div>
        </div>

    </div>
</div>