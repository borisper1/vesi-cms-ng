<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-magic"></i> Risoluzione dei problemi</h1></div>
<p>Questa pagina include vari strumenti che permettono di diagnosticare e risolvere molti dei problemi comuni in cui si può incorrere durante l'uso del sito</p>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-filter"></i> Filtra tutto l'HTML</h3>
    </div>
    <div class="panel-body">
        <p>
            Questo strumento permette di risolvere problemi di formattazione nelle pagine rimovendo elementi non consentiti anche se questi sono stati introdotti manualmente.
            Verrà rieffettuato il filtraggio del codice per tutti i contenuti in HTML (non verrano filtrati i contenuti dei componenti aggiuntivi).
            Questa procedura permette anche di trasformare i <i>link relativi</i> (non supportati) in <i>link assoluti</i> appropriati.
        </p>
        <p>L'esecuzione di questa procedura potrebbe richiedere molto tempo a seconda del numero di contenuti del sito</p>
    </div>
    <div class="panel-footer">
        <button type="button" class="btn btn-default" id="execute-filter-html"><i class="fa fa-bolt"></i> Esegui</button>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-exchange"></i> Sposta base sito</h3>
    </div>
    <div class="panel-body">
        <p>
            Questo strumento permette di aggiornare i link assoluti subito prima o in seguito a uno spostamento della base del sito (modifica del nome di dominio o del percorso per la cartella radice del sito),
            deve essere eseguito in caso di spostamento oltre all'aggornamento della variabile <code>base_url</code> in <code>config.php</code>.
        </p>
        <h5><b>Scegliere come effettuare la migrazione</b></h5>
        <div class="radio">
            <label>
                <input type="radio" name="rebase-mode" id="rebase-before" value="before" checked>
                Il sito è ancora sul dominio vecchio &mdash; prepara per lo spostamento
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="rebase-mode" id="rebase-after" value="after">
                Il sito è già stato spostato &mdash; completa lo spostamento (sconsigliato, potrebbe generare errori)
            </label>
        </div>
        <div class="form-group">
            <label for="rebase-url" id="rebase-url-label">Inserire il nuovo URL del sito (l'URL effettivo dopo lo spostamento)</label>
            <input type="email" class="form-control" id="rebase-url" placeholder="Inserire l'URL">
        </div>
        <p>L'esecuzione di questa procedura potrebbe richiedere molto tempo a seconda del numero di contenuti del sito</p>
    </div>
    <div class="panel-footer">
        <button type="button" class="btn btn-default" id="execute-rebase"><i class="fa fa-bolt"></i> Esegui</button>
    </div>
</div>

<div class="modal fade" id="diag-run-modal" tabindex="-1" role="dialog" aria-labelledby="diag-run-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="diag-run-modal-label"><i class="fa fa-lg fa-gears"></i> Esecuzione strumento di risoluzione problemi</h4>
            </div>
            <div class="modal-body">
                <p>Esecuzione del strumento di risoluzione problemi. Attendere. Questa operazione può richiedere molto tempo, non aggiornare o chiudere questa pagina...</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="diag-results-modal" tabindex="-1" role="dialog" aria-labelledby="diag-results-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="diag-results-modal-label"><i class="fa fa-lg fa-file-text"></i> Risultati della risoluzione problemi</h4>
            </div>
            <div class="modal-body">
                <p>Strumento di risoluzione dei problemi eseguito correttamente.</p>
                <div id="diag-results-box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="diag-error-modal" tabindex="-1" role="dialog" aria-labelledby="diag-error-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="diag-error-modal-label"><i class="fa fa-lg fa-exclamation-circle"></i> Errore durante la risoluzione problemi</h4>
            </div>
            <div class="modal-body">
                <p>Lo strumento di risoluzione dei problemi ha riscontrato un errore e non è stato eseguito</p>
                <a role="button" data-toggle="collapse" href="#diag-error-box" aria-expanded="false" aria-controls="collapseExample">Mostra dettagli</a>
                <div class="collapse" id="diag-error-box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>