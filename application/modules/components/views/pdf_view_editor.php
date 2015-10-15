<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><h4><i class='fa fa-file-pdf-o fa-lg'></i> Percorso file PDF da integrare</h4>
<div class='well'>
    <div class='form-group'>
        <label for='pdf-path'>Inserire il percorso o l'URL del file da includere</label>
        <input type='text' class='form-control' id='pdf-path' placeholder='Indirizzo del PDF da collegare' value='<?=$path?>'>
    </div>
    <p> I files sono solitamente archiviati in <code>files/</code>. Il percorso va specificato relativamente alla cartella base del cms (<code>files/x.pdf</code>)</p>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Anteprima del pdf selezionato <a class='update-preview lmb pull-right tooltipped' data-toggle='tooltip' title='Aggiorna'><i class='text-primary fa fa-refresh'></i></a></h3>
    </div>
    <div class="panel-body">
        <?php if($is_external_server): ?>
            <div class="alert alert-warning" role="alert"><i class="fa fa-warning"></i> <strong>Attenzione!</strong> Il file è archiviato su un altro server. Verrà comunque tentata la visualizzazione dell"anteprima.</div>
        <?php endif; ?>
        <?php if($file_exists): ?>
            <object data="<?=$true_path ?>" type="application/pdf" width="100%" height="500px">
                <div class="alert alert-warning" role="alert">
                    <i class="fa fa-warning"></i> <strong>Attenzione!</strong> Sembra che il tuo browser non supporti l"integrazione PDF (puoi comunque scaricare il file <a class="alert-link" href="<?=$true_path ?>" target="_blank">qui</a>)
                </div>
            </object>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-circle"></i> <strong>Errore!</strong> Il file specificato non esiste. Verificare il percorso o l'URL e verificare che i permessi siano corretti.
            </div>
        <?php endif; ?>
    </div>
</div>