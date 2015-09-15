<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-file"></i> Pagine</h1></div>
<div class="btn-group">
    <button type="button" class="btn btn-success" id="new-page"><span class="fa fa-plus"></span> Nuova pagina</button>
    <button type="button" class="btn btn-default" id="new-redirect"><span class="fa fa-exchange"></span> Nuovo reindirizzamento</button>
</div>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default" id="show-all"><i class="fa fa-eye"></i> Mostra tutto</button>
    <button type="button" class="btn btn-default" id="hide-all"><i class="fa fa-eye-slash"></i> Nascondi tutto</button>
</div>
<div class="clearfix"></div>
<br><br>
<div id="ajax-cage">
    <?=$rendered_elements ?>
</div>