<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><h4><i class="fa fa-folder"></i> Percorso della cartella da visualizzare</h4>
<div class="well">
    <div class="form-group">
        <label for="folder-path">Inserire il percorso della cartella che contiene i file da visualizzare</label>
        <input type="text" class="form-control" id="folder-path" placeholder="Indirizzo della cartella da collegare" value="<?=$path?>">
    </div>
    <p> Le sottocartelle non sono visualizzate. I files sono solitamente archiviati in <code>files/</code>. Il percorso va specificato relativamente alla cartella base del cms (<code>files/x</code>)</p>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">File nella cartella selezionata <a class="update-preview lmb pull-right tooltipped" data-toggle="tooltip" title="Aggiorna"><i class="text-primary fa fa-refresh"></i></a></h3>
    </div>
    <div class="panel-body">
        <?php if($path_exists): ?>
            <?php $this->load->view('file_lister',array('files' => $files)) ?>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-circle"></i> <strong>Errore!</strong> Il percorso specificato non esiste. Verificare il percorso e assicurarsi che i permessi siano corretti.
            </div>
        <?php endif; ?>
    </div>
</div>