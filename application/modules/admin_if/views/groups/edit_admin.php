<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-lock"></i> Gruppi e permessi</h1></div>
<span id="page-mode" class="hidden">edit_admin</span>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica gruppo: <span id="group-name"><?=$group_name ?></span> <small><i><span id="group-description"><?=$description ?></span></i></small></h3>
<div class="btn-group pull-right spaced" id="group-actions">
    <button type="button" class="btn btn-default" id="save-edit"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile modificare il gruppo:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Gruppo modificato con successo
</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Modifica del gruppo...</div>

<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>

<?php if ($ldap_enabled): ?>
    <?php if ($ldap_failed): ?>
        <div class="alert alert-danger" id="ldap-connect-failed-all">
            <i class="fa fa-exclamation-circle"></i> <b>Non è stato possibile connettersi a LDAP.</b><br>
            Controllare la configurazione dell'autenticazione LDAP. Il server LDAP potrebbe essere non disponibile
            oppure non si dispone delle autorizzazioni necessarie per accedere alla directory.<br>
            Non è possibile asociare gruppi LDAP.<br>
            <a href="<?= base_url('admin/groups/edit_admin/' . $group_name) ?>" class="alert-link">Ricaricare</a> la
            pagina per riprovare
        </div>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Gruppi LDAP associati</h3>
        </div>
        <div class="panel-body">
            <p><b>Scegliere i gruppi LDAP a cui associare questo gruppo:</b></p>
            <div id="ldapgrp-editor-gui" class="container-fluid">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-default" id="ldapgrp-gui-add"><i class="fa fa-plus-square"></i>
                        Aggiungi elemento
                    </button>
                </div>
                <div class="well" id="gui-ldap-editor-area">
                    <?php foreach ($ldap_linked_groups as $group): ?>
                        <span class="label label-default ldap-group-element">
                        <span class="ldap-element"><?= $group ?></span>
                        <a class="delete-ldap-element lmb tooltipped"
                           data-toggle="tooltip" title="Elimina"><i class="fa fa-remove"></i></a>
                    </span>&nbsp;
                    <?php endforeach; ?>
                </div>
                <div class="hidden" id="ldap-group-template">
                    <span class="label label-default ldap-group-element">
                        <span class="ldap-element"></span>
                        <a class="delete-ldap-element lmb tooltipped"
                           data-toggle="tooltip" title="Elimina"><i class="fa fa-remove"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Permessi delle interfacce amministrative</h3>
    </div>
    <div class="panel-body">
        <p>Selezionare le interfacce amministrative a cui questo gruppo di utenti potrà accedere (alcune interfacce sono riservate al gruppo <span class="label label-danger">super-users</span>).</p>
        <span class="hidden" id="onload_allowed_permissions"><?= $allowed_interfaces_csv ?></span>
        <?php foreach($permission_groups as $permission_group): ?>
            <h3><i class="fa <?=$permission_group['icon'] ?>"></i> <?=$permission_group['label'] ?></h3>
            <p><?=$permission_group['description'] ?></p>
            <?php foreach($permission_group['items'] as $item): ?>
                <?php if($item['name']!=='special::separator'): ?>
                    <div class="permission-block">
                        <?php if($item['only_su']===false): ?>
                            <i class="fa <?=$item['icon'] ?> fa-lg fa-fw"></i> <input type="checkbox" class="select-permission-item" value="<?=$item['name'] ?>"> <b><?=$item['label'] ?></b> <span class="label label-default"><?=$item['name'] ?></span> <?=$item['description'] ?>
                        <?php else: ?>
                            <i class="fa <?=$item['icon'] ?> fa-lg fa-fw"></i> <input type="checkbox" class="select-permission-item" value="<?=$item['name'] ?>" disabled> <span class="text-danger"><b><?=$item['label'] ?></b></span> <span class="label label-default"><?=$item['name'] ?></span> <span class="text-danger"><?=$item['description'] ?></span> <span class="label label-danger">riservato ai super-users</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Permessi dei contenuti</h3>
    </div>
    <div class="panel-body">
        <p class="text-warning"><i class="fa fa-warning"></i> Attenzione: i permessi relativi ai contenuti possono rallentare notevolmente l'accesso al sistema da parte degli utenti a cui si applica la restrizione.</p>
        <label><input type="checkbox" id="enable-content-filter" <?= $use_content_filter ? 'checked' : '' ?>> <b>Attiva
                filtro basato sui contenuti</b></label>
        <span id="onload_cfilter_status" class="hidden"><?=$use_content_filter ? 'true' : 'false' ?></span>
        <span id="onload_cfilter_mode" class="hidden"><?=$content_filter_mode ?></span>
        <p><b>Scegliere il modo di operazione del filtro:</b></p>
        <div class="cfilter-radio radio">
            <label>
                <input type="radio" name="cfilter-mode" id="filter-whitelist" value="whitelist">
                <b>Whitelist</b>: consente la visualizzazione, modifica e l"eliminazione dei contenitori e delle pagine elencate sotto.
            </label>
        </div>
        <div class="cfilter-radio radio">
            <label>
                <input type="radio" name="cfilter-mode" id="filter-blacklist" value="blacklist">
                <b>Blacklist</b>: blocca la visualizzazione, modifica e l"eliminazione dei contenitori e delle pagine elencate sotto.
            </label>
        </div>
        <p><b>Scegliere i contenitori e le pagine:</b></p>
        <div class="btn-group spaced" data-toggle="buttons">
            <label class="btn btn-default active">
                <input type="radio" name="cfilter-editor-mode" id="cfilter-edit-gui" checked> <i class="fa fa-list-alt"></i> Editor grafico
            </label>
            <label class="btn btn-default">
                <input type="radio" name="cfilter-editor-mode" id="cfilter-edit-code"> <i class="fa fa-code"></i> Modifica codice
            </label>
        </div>
        <div id="cfilter-editor-gui" class="container-fluid">
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-default" id="cfilter-gui-add-container"> <i class="fa fa-plus-square"></i> Aggiungi contenitore</button>
                <button type="button" class="btn btn-default" id="cfilter-gui-add-page"> <i class="fa fa-plus-square-o"></i> Aggiungi pagina</button>
            </div>
            <div class="well" id="gui-editor-area">

            </div>
            <div class="hidden" id="container-filter-template">
                <span class="label label-success filter-element filter-container">
                    <span class="container-name"></span>
                    <a href="#gui-editor-area" class="delete-filter-element lmb tooltipped" data-toggle="tooltip" title="Elimina"><i class="fa fa-remove"></i></a>
                </span>
            </div>
            <div class="hidden" id="page-filter-template">
                <span class="label label-info filter-element filter-page">
                    <span class="page-container"></span> <i class="fa fa-ellipsis-v"></i> <span class="page-name"></span>
                    <a href="#gui-editor-area" class="delete-filter-element lmb tooltipped" data-toggle="tooltip" title="Elimina"><i class="fa fa-remove"></i></a>
                </span>
            </div>
        </div>
        <div id="cfilter-editor-code" class="container-fluid hidden">
            <p><b>Inserire l'espressione del filtro:</b></p>
            <textarea class="form-control" rows="4" placeholder="Espressione CSV del filtro" id="cfilter-code-expression"><?=$content_filter_directives ?></textarea>
            <p>Inserire nomi di contenitori o coppie <code>contenitore::pagina</code> separando i valori con una <kbd>,</kbd>. L'input non verrà controllato, un errore potrebbe causare il blocco dell'accesso da parte degli utenti a cui si applicano queste restrizioni.</p>
        </div>
    </div>
</div>

<datalist id="containers-list">
    <?php foreach($containers as $container): ?>
    <option value="<?=$container ?>">
        <?php endforeach; ?>
</datalist>

<datalist id="cscope-pages"></datalist>

<div class="modal fade" id="new-page-filter-modal" tabindex="-1" role="dialog" aria-labelledby="new-page-filter-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-page-filter-modal-label"><i class="fa fa-plus"></i> Aggiungi pagina singola al filtro</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-page-filter-container">Inserire il contenitore della pagina da includere nel filtro</label>
                    <input type="text" class="form-control" id="i-page-filter-container" placeholder="Contenitore" list="containers-list">
                </div>
                <div class="form-group">
                    <label for="i-page-filter-page">Inserire il nome della pagina da includere nel filtro</label>
                    <input type="text" class="form-control" id="i-page-filter-page" placeholder="Pagina" list="cscope-pages">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-page-filter-modal-confirm" data-dismiss="modal"><i class="fa fa-plus"></i> Aggiungi pagina</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-content-filter-modal" tabindex="-1" role="dialog" aria-labelledby="new-content-filter-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-content-filter-modal-label"><i class="fa fa-plus"></i> Aggiungi contenitore al filtro</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-container-filter-container">Inserire il contenitore da includere nel filtro</label>
                    <input type="text" class="form-control" id="i-container-filter-container" placeholder="Contenitore" list="containers-list">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-container-filter-modal-confirm" data-dismiss="modal"><i class="fa fa-plus"></i> Aggiungi contenitore</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-ldap-group-modal" tabindex="-1" role="dialog"
     aria-labelledby="new-ldap-group-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-ldap-group-modal-label"><i class="fa fa-plus"></i> Associa gruppo LDAP
                </h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-ldap-group">Scegli il gruppo LDAP da associare (DN completo)</label>
                    <select class="form-control selectpicker" id="i-ldap-group">
                        <?php foreach ($ldap_groups as $group_i): ?>
                            <option
                                data-content="<?= $group_i['cn'] ?> <span class='label label-default'><?= $group_i['dn'] ?></span> "><?= $group_i['dn'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label><input type="checkbox" id="hide-builtin-ldap-groups"> Nascondi gruppi predefiniti di Active
                    Directory <code>CN=Builtin</code></label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-success" id="new-ldap-group-modal-confirm" data-dismiss="modal"><i
                        class="fa fa-plus"></i> Associa gruppo LDAP
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-group-modal" tabindex="-1" role="dialog" aria-labelledby="new-group-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-group-label"><i class="fa fa-plus"></i> Creazione nuovo gruppo</h4>
            </div>

            <div class="modal-body">
                <p class="text-warning"><i class="fa fa-warning"></i> Attenzione: queste proprietà identificano il gruppo e non sarà possibile modificarle in seguito</p>
                <div class="form-group">
                    <label for="i-group-name">Inserire il nome del gruppo</label>
                    <input type="text" class="form-control" id="i-group-name" placeholder="Nome gruppo">
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div class="form-group">
                    <label for="i-parent-link-page">Inserire la descrizione del gruppo</label>
                    <input type="text" class="form-control" id="i-group-description" placeholder="Descrizione">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-group-modal-confirm"><i class="fa fa-plus"></i> Crea gruppo</button>
            </div>
        </div>
    </div>
</div>

