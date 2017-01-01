<?php defined('BASEPATH') OR exit('No direct script access allowed');
$form="<div class='alert alert-danger hidden' role='alert' id='authenticator-alert'>Impossibile eseguire l'accesso</div>
<div class='form-group'>
            <div class='input-group'>
                <span class='input-group-addon'><span class='fa fa-user'></span></span>
                <input type='text' class='form-control' placeholder='Nome utente' id='i-authenticator-username'>
            </div>
         </div>
         <div class='form-group'>
             <div class='input-group'>
                <span class='input-group-addon'><span class='fa fa-lock'></span></span>
                <input type='password' class='form-control' placeholder='Password' id='i-authenticator-password'>
             </div>
             <a href='" . base_url("system/pwd_forgot") . "'>Password dimenticata?</a>
         </div>
         <button class='btn btn-default' id='authenticator-login'>Accedi</button>";
?><ul class="nav navbar-nav navbar-right" id="authenticator-container">
    <?php if($frontend_logged_in): ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-user"></i><?=$user_initials ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-header"><?=$user_fullname ?></li>
                <li><a href="<?=base_url('system/profile') ?>"><i class="fa fa-fw fa-wrench"></i> Modifica utente</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#" id="authenticator-logout"><i class="fa fa-fw fa-sign-out"></i> Esci</a></li>
            </ul>
        </li>
        <form action="<?=base_url('system/logout') ?>" id="authenticator-logout-form" method="POST">
            <input type="hidden" name="redirect_to" value="<?=current_url() ?>">
        </form>
        <span class="hidden" id="authenticator-status">logged-in</span>
    <?php else: ?>
        <li><a tabindex="0" class="popover-trigger" role="button" data-placement="bottom" data-toggle="popover" data-html="true" data-content="<?=$form ?>" id="authenticator-login-button"><i class="fa fa-user fa-lg"></i> Accedi</a></li>
        <span class="hidden" id="authenticator-status">no-session</span>
    <?php endif; ?>
</ul>