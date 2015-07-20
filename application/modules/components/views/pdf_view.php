<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><object data="<?=$url?>" type="application/pdf" width="100%" height="500px">
    <div class="alert alert-warning" role="alert">
        <i class="fa fa-warning"></i> <strong>Attenzione:</strong> Sembra che il tuo browser non supporti l'integrazione PDF (puoi comunque scaricare il file <a class="alert-link" href="$path" target="_blank">qui</a>)
    </div>
</object>