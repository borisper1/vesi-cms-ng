<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    ?><div class="component_address-view">
        <div class="row">
            <div class="col-md-4">
                <address>
                    <?=$road_address ?>
                </address>
            </div>
            <div class="col-md-4">
                <?php foreach($emails as $email): ?>
                    <p><span class="fa fa-envelope"></span> <b><?=($email->type==="standard" ? "E-Mail" : "<abbr title='Posta Elettronica Certificata' class='initialism'>PEC</abbr>").($email->label!="" ? " (".$email->label.")" : "")?></b>: <a href="mailto:<?=$email->address?>" target="_top"><?=$email->address?></a></p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <?php foreach($phones as $phone): ?>
                    <?php if($phone->type==="standard"): ?>
                        <p><span class="fa fa-phone"></span> <b>Tel.<?=$phone->label!="" ? " (".$phone->label.")" : ""?></b>: <?=$phone->phone?></p>
                    <?php else: ?>
                        <p><span class="fa fa-fax"></span> <b>Fax<?=$phone->label!="" ? " (".$phone->label.")" : ""?></b>: <?=$phone->phone?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>