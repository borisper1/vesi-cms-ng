<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Accedi al sito</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-danger hidden" role="alert" id="system-login-alert">Impossibile eseguire l'accesso</div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lg fa-fw fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Nome utente" id="i-system-login-username">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lg fa-fw fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" id="i-system-login-password">
                </div>
            </div>

            <button type="button" class="btn btn-primary" id="system-execute-login">Accedi</button>
        </div>
    </div>
</div>
