<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-plug"></i> Componenti aggiuntivi</h1></div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-success" id="show-install-plugin"><i class="fa fa-plus"></i> Installa</button>
</div>
<table class="table table-hover">
    <thead><tr>
        <th>Nome</th>
        <th>Stato</th>
        <th>Descrizione</th>
        <th>Autore</th>
        <th>Versione</th>
    </tr></thead>
    <tbody>
    <?php foreach ($plugins as $plugin): ?>
        <tr>
            <td>
                <?= $plugin['title'] ?> <span class="label label-info f-name"><?= $plugin['name'] ?></span>
                <div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-default view-plugin-components"><i class="fa fa-eye">
                            Visualizza componenti</i></button>
                    <button type="button" class="btn btn-default repair-plugin"><i class="fa fa-wrench"></i> Ripara
                    </button>
                    <button type="button" class="btn btn-default remove-plugin"><i class="fa fa-trash"></i> Disinstalla
                    </button>
                </div>
            </td>
            <td>
                <?php if ($plugin['enabled']): ?>
                    <i class="fa fa-check"></i> Abilitato
                    <button type="button" class="btn btn-default btn-xs disable-plugin"><i class="fa fa-ban"></i>
                        Disablilita
                    </button>
                <?php else: ?>
                    <i class="fa fa-ban"></i> Disabilitato
                    <button type="button" class="btn btn-default btn-xs enable-plugin"><i class="fa fa-check"></i>
                        Abilita
                    </button>
                <?php endif; ?>
            </td>
            <td><?= $plugin['description'] ?></td>
            <td><?= $plugin['author'] ?></td>
            <td><?= $plugin['version'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="view-components-modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-eye"></i> Visualizza componenti componente aggiuntivo</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Chiudi
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="install-plugin-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-download"></i> Installa componente aggiuntivo</h4>
            </div>
            <div class="modal-body">
                <div id="install-plugin-welcome" class="install-plugin-screens">
                    <p>Questa procedura permette di installare un componente aggiuntivo dal file <code>zip</code> di installazione, oppure di aggiornare un componente aggiuntivo installato.</p>
                    <div class="alert alert-warning" role="alert"><i class="fa fa-shield"></i> <b>Installare solo componenti aggiuntivi da autori fidati</b>. I componenti aggiuntivi installati
                    saranno eseguiti con lo stesso livello di autenticazione del codice principale (avranno accesso a tutto il sistema). Pertanto componenti aggiuntivi malevoli possono causare
                    danni ingenti al sistema, inclusa la perdita o il furto di dati.</div>
                    <p>Si consiglia di verificare l'hash <code>MD5</code> o <code>SHA1</code> o la firma <code>PGP/OpenPGP</code> (se fornita) fornita dall'autore prima di installare un componente aggiuntivo</p>
                </div>
                <div id="install-plugin-choosefile" class="install-plugin-screens">
                    <form id="install-plugin-upload-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="plugin-file-input">Scegliere il file da installare</label>
                            <input type="file" id="plugin-file-input" name="zip_install">
                            <p class="help-block">Dimensione massima: <?=ini_get("upload_max_filesize");?>B</p>
                        </div>
                        <button type="submit" class="btn btn-default"><i class="fa fa-upload"></i> Carica file</button>
                    </form>
                </div>
                <div id="install-plugin-uploading" class="install-plugin-screens">
                    <p>Caricamento del file. Attendere.</p>
                    <div class="progress">
                        <div id="install-plugin-upload-bar" class="progress-bar" style="width: 0%; min-width: 2em;">0%</div>
                    </div>
                </div>
                <div id="install-plugin-preparing" class="install-plugin-screens">
                    <p>Preparazione all'installazione in corso... Attendere.</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="install-plugin-rtinstall" class="install-plugin-screens">
                    <p>Il plugin <code class="rtinstall-name"></code> è pronto per l'installazione</p>
                    <table class="table">
                        <tr><th>Nome</th><td><span id="rtinstall-title"></span> <span class="rtinstall-name label label-info"></span></td></tr>
                        <tr>
                            <th>Versione</th>
                            <td class="rtinstall-version"></td>
                        </tr>
                        <tr><th>Autore</th><td id="rtinstall-author"></td></tr>
                        <tr><th>Descrizione</th><td id="rtinstall-description"></td></tr>
                        <tr><th>Checksum MD5</th><td><code id="rtinstall-md5"></code></td></tr>
                        <tr><th>Hash SHA1</th><td><code id="rtinstall-sha1"></code></td></tr>
                    </table>
                    <div class="alert alert-info" id="rtinstall-update" role="alert"><i class="fa fa-info-circle"></i>
                        <b>Questo componente aggiuntivo è già installato</b>. Se si continua il componente
                        aggiuntivo verrà aggiornato dalla versione <code id="rtinstall-oldversion"></code> alla versione
                        <code class="rtinstall-version"></code>. Verificare che il passaggio automatico tra queste
                        versioni
                        sia supportato (per più informazioni consultare la documentazione del componente aggiuntivo).
                    </div>
                    <div class="alert alert-warning" role="alert"><i class="fa fa-shield"></i> <b>Installare solo componenti aggiuntivi da autori fidati</b>. I componenti aggiuntivi installati
                        saranno eseguiti con lo stesso livello di autenticazione del codice principale (avranno accesso a tutto il sistema). Pertanto componenti aggiuntivi malevoli possono causare
                        danni ingenti al sistema, inclusa la perdita o il furto di dati.</div>
                    <p>Per installare il plugin premere su <i class="fa fa-chevron-right"></i> <i>Avanti</i>. Se non ci si fida dell'autore del plugin premere su <i class="fa fa-remove"></i> <i>Anullla</i>.</p>
                </div>
                <div id="install-plugin-installing" class="install-plugin-screens">
                    <p>Installazione del componente aggiuntivo... Attendere.</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="install-plugin-success" class="install-plugin-screens">
                    <h4 class="text-success"><i class="fa fa fa-exclamation-circle"></i> Componente aggiuntivo
                        installato correttamente</h4>
                    <p>Il componente aggiuntivo è pronto per essere usato. Se si usa un motore di database diverso da
                        MySQL verificare che l'installazione delle strutture dati sia stata eseguita correttamente.</p>
                </div>
                <div id="install-plugin-syserror" class="install-plugin-screens">
                    <h4 class="text-danger"><i class="fa fa fa-exclamation-circle"></i> Si è verificato un errore</h4>
                    <p>Non è stato possibile installare il componente aggiuntivo.</p>
                    <a role="button" data-toggle="collapse" href="#install-error-box" aria-expanded="false" aria-controls="collapseExample">Mostra dettagli</a>
                    <div class="collapse" id="install-error-box"></div>
                </div>
            </div>
            <div class="modal-footer" id="plugin-install-modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="install-plugin-modal-cancel"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-default" id="install-plugin-modal-next"><i class="fa fa-chevron-right"></i> Avanti</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="repair-plugin-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-wrench"></i> Ripara componente aggiuntivo</h4>
            </div>
            <div class="modal-body">
                <div id="repair-plugin-welcome" class="repair-plugin-screens">
                    <p>Questa procedura permette di riparare un componente aggiuntivo installato nel caso esso non
                        funzioni più correttamente. I file del plugin verranno reinstallati, i suoi componenti
                        verrano registrati e il database verrà aggiornato </p>
                    <p>Se questa procedura non risolve il problema reinstallare il componente aggiuntivo dal file <code>zip</code>
                        originale.</p>
                    <p>Verrà reinstallato il componente aggiuntivo <code id="repair-name"></code>. Per riparare il
                        plugin premere su <i class="fa fa-chevron-right"></i> <i>Avanti</i>.</p>
                </div>
                <div id="repair-plugin-executing" class="repair-plugin-screens">
                    <p>Reinstallazione del componente aggiuntivo... Attendere.</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="repair-plugin-success" class="repair-plugin-screens">
                    <h4 class="text-success"><i class="fa fa fa-exclamation-circle"></i> Componente aggiuntivo
                        riparato correttamente</h4>
                    <p>Il componente aggiuntivo è pronto per essere usato. Se si usa un motore di database diverso da
                        MySQL verificare che l'installazione delle strutture dati sia stata eseguita correttamente.</p>
                    <p>Se questa procedura non ha risolto il problema reinstallare il componente aggiuntivo dal file
                        <code>zip</code> originale.</p>
                </div>
                <div id="repair-plugin-syserror" class="repair-plugin-screens">
                    <h4 class="text-danger"><i class="fa fa fa-exclamation-circle"></i> Si è verificato un errore</h4>
                    <p>Non è stato possibile riparare il componente aggiuntivo.</p>
                    <a role="button" data-toggle="collapse" href="#repair-error-box" aria-expanded="false"
                       aria-controls="collapseExample">Mostra dettagli</a>
                    <div class="collapse" id="repair-error-box"></div>
                </div>
            </div>
            <div class="modal-footer" id="repair-plugin-modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Chiudi
                </button>
                <button type="button" class="btn btn-default" id="repair-plugin-modal-next"><i
                        class="fa fa-chevron-right"></i> Avanti
                </button>
            </div>
        </div>
    </div>
</div>