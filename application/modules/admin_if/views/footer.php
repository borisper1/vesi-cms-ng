<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header">
    <h1><i class="fa fa-edit"></i> Modifica piè di pagina
        <button type="button" class="btn btn-default pull-right launch-contextual-help tooltipped" title="Aiuto"
                data-help_path="footer"><i class="fa fa-question-circle"></i></button>
    </h1>
</div>
<div class="btn-group" id="footer-actions">
    <button type="button" class="btn btn-default" id="save-footer"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
</div>
<br>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare il pié di pagina:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Pié di pagina salvato con successo
</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio del pié di pagina...</div>
<div class="checkbox toggle">
    <label>
        <input type="checkbox" id="i-activate" <?=$use_footer ? 'checked' : '' ?>> &nbsp;Mostra il pié di pagina
    </label>
</div>
<h4><i class="fa fa-code"></i> Modifica il codice HTML del piè di pagina</i></h4>
<style type='text/css' media='screen'>#code_editor {height:500px;}</style>
<pre id="code_editor"><?=$code ?></pre>