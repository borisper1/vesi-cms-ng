<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="<?=base_url('assets/administration/img/settings-icon.png') ?>" />
        <p id="profile-name" class="profile-name-card">Accedi all'area amministrativa</p>

        <form class="form-signin <?=$form_class ?>" action="<?=base_url('admin/login') ?>" method="post">
            <span class="reauth-email"><a href="<?=base_url() ?>">Torna al sito</a></span>
            <?php if($error_message!==''):?>
                <div class="alert alert-danger" role="alert"><?=$error_message ?></div>
            <?php endif; ?>

            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-fw fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Nome utente" required autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-fw fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Accedi</button>
        </form><!-- /form -->
    </div><!-- /card-container -->
</div><!-- /container -->

<footer class="footer">
    <div class="container">
        <p><i class="fa fa-cubes"></i> Vesi-CMS 1.2 (ng), Copyright © 2016 Boris Pertot</p>
    </div>
</footer>






