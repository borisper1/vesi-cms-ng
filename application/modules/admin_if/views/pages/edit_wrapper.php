<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><link rel="stylesheet" href="<?=base_url('assets/third_party/semantic-ui/components/header.min.css') ?>">
<link rel="stylesheet" href="<?=base_url('assets/third_party/semantic-ui/components/divider.min.css') ?>">
<div class="page-header"><h1><i class="fa fa-file"></i> Pagine</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-title"><?=$title ?></span>
    <small><span class="label label-info"><span id="f-container"><?=$container ?></span> <i class="fa fa-ellipsis-v"></i> <span id="f-page-name"><?=$page_name ?></span></span> <span class="label label-default" id="f-id"><?=$id ?></span></small>
</h3>
<div class="btn-group pull-right" id="page-actions">
    <button type="button" class="btn btn-default" id="save-page"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="edit-attributes"><i class="fa fa-wrench"></i> Modifica attributi</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>
<span id="f-page-layout" class="hidden"><?=$layout ?></span>
<br>

<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare la pagina:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible  hidden" id="success-alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Pagina salvata con successo, <b>Premere su <i>Aggiorna</i></b> per ricaricare le informazioni sullo stato contenuti
</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio della pagina...</div>

<div class="alert alert-danger alert-dismissible hidden content-alert" id="content-deletion-error">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare i contenuti:</b><br> I contenuti sono stati dissociati, ma non è stato possible eliminare alcuni contenuti. Questi contenuti sono adesso orfani.
</div>
<div class="alert alert-success alert-dismissible hidden content-alert" id="content-deletion-success">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Contenuti eliminati con successo
</div>
<div class="alert alert-info hidden content-alert" id="content-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione dei contenuti selezionati...</div>
<div class="alert alert-info hidden content-alert" id="content-linking-spinner"><i class="fa fa-refresh fa-spin"></i> Aggiunta del contenuto/menu/plug-in in corso...</div>
<div class="alert alert-danger alert-dismissible hidden content-alert" id="content-linking-error">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile aggiungere il contenuto/menu/plug-in:</b><br> Il server non risponde alla richiesta.
</div>

<datalist id="containers-list">
    <?php foreach($containers as $container): ?>
        <option value="<?=$container ?>"></option>
    <?php endforeach; ?>
</datalist>

<datalist id="contents-list">
    <?php foreach($contents_list as $content_element): ?>
        <option value="<?=$content_element['id'] ?>"><?=$content_element['preview'] ?> [<?=$content_element['type'] ?>] [<?=$content_element['id'] ?>]</option>
    <?php endforeach; ?>
</datalist>

<datalist id="menus-list">
    <?php foreach($menus_list as $menu_element): ?>
        <option value="<?=$menu_element['id'] ?>"><?=$menu_element['title'] ?> [<?=$menu_element['id'] ?>]</option>
    <?php endforeach; ?>
</datalist>

<div class="modal fade" id="edit-attributes-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-wrench"></i> Modifica attributi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-page-title">Inserire il titolo della pagina</label>
                    <input type="text" class="form-control" id="i-page-title" placeholder="Titolo">
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-page-container">Scegliere il contenitore della pagina</label>
                    <input type="text" class="form-control" id="i-page-container" placeholder="Contenitore" list="containers-list">
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-page-name">Inserire il nome di sistema della pagina</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="i-page-name" placeholder="Nome">
                        <span class="input-group-btn">
                            <button class="btn btn-default tooltipped" type="button" title='Genera automaticamente' id="generate-page-name"><i class="fa fa-asterisk"></i></button>
                        </span>
                    </div>
                    <p class="text-danger min-space-top no-margin hidden" id="name-change-warning"><i class="fa fa-exclamation-triangle"></i> Attenzione: modificando il nome di pagina si rompono tutti i collegamenti ad essa (incluse le voci di menu)</p>
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-page-layout">Scegliere il layout della pagina</label>
                    <select class="selectpicker form-control" id="i-page-layout">
                        <option value="standard">Standard (senza barra laterale)</option>
                        <option value="sidebar-left">Barra laterale a sinistra</option>
                        <option value="sidebar-right">Barra laterale a destra</option>
                    </select>
                    <p class="text-info min-space-top no-margin hidden" id="layout-change-warning"><i class="fa fa-info-circle"></i> NB: tutte le modifiche apportate verranno salvate (non sarà più possibile ripristinare una versione precedente)</p>
                    <p class="text-danger min-space-top no-margin hidden" id="sidebar-deletion-warning"><i class="fa fa-exclamation-triangle"></i> Attenzione: tutti i contenuti della barra laterale verrano dissociati e la struttura verrà eliminata</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="edit-attributes-confirm"><i class="fa fa-bolt"></i> Modifica attributi</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="view-modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-view-title">Inserire il titolo della scheda/pannello</label>
                    <input type="text" class="form-control" id="i-view-title" placeholder="Titolo">
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-view-id">Inserire l'id della scheda/pannello</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="i-view-id" placeholder="Id">
                        <span class="input-group-btn">
                            <button class="btn btn-default tooltipped" type="button" title='Genera automaticamente' id="generate-view-id"><i class="fa fa-asterisk"></i></button>
                        </span>
                    </div>
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div id="view-modal-class-selector-ui" class="hidden form-group">
                    <label class="control-label" for="i-sview-class">Scegliere la classe da applicare al modulo</label>
                    <select class="selectpicker form-control" id="i-sview-class">
                        <option value="panel-primary">[panel-primary] Elemento in primo piano (colore primario)</option>
                        <option value="panel-default">[panel-default] Elemento in secondo piano</option>
                        <option value="panel-info">[panel-info] Stile informazione (azzurro)</option>
                        <option value="panel-success">[panel-success] Stile successo (verde)</option>
                        <option value="panel-warning">[panel-warning] Stile avviso (arancio)</option>
                        <option value="panel-danger">[panel-danger] Stile pericolo (rosso)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="view-modal-confirm"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="unlink-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="view-modal-title"><i class="fa fa-unlink"></i> Dissocia elemento</h4>
            </div>
            <div class="modal-body">
                <div id="unlink-modal-wait">
                    <p>Caricamento informazioni albero contenuti. Attendere...</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="unlink-modal-show" class="hidden">
                    <p>Dissociando questo contenuto esso rimarrà orfano (non è associato a nessun'altra pagina).</p>
                    <p>Selezionare la casella di controllo qui sotto per eliminare definitivamente questo contenuto</p>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="unlink-modal-delete-select"> Elimina definitivamente questo contenuto
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer hidden" id="unlink-modal-toolbar">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="unlink-modal-confirm" data-dismiss="modal"><i class="fa fa-unlink"></i> Dissocia contenuto</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="structure-deletion-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="view-modal-title"><i class="fa fa-trash"></i> Elimina elemento struttura</h4>
            </div>
            <div class="modal-body">
                <div id="structure-deletion-modal-wait">
                    <p>Caricamento informazioni albero contenuti/strutture. Attendere...</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="structure-deletion-modal-show" class="hidden">
                    <p>Questo elemento struttura verrà eliminato definitivamente, inoltre tutti i contenuti della struttura verranno dissociati
                    <br>Eliminare questa struttura?</p>
                </div>
                <div id="structure-deletion-modal-orphans" class="hidden">
                    <p>Eliminando questa struttura i seguenti contenuti rimarranno orfani (non sono associati a nessun'altra pagina). Selezionare i contenuti da eliminare definitivamente.</p>
                    <table class="table">
                        <thead><tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Contenuto</th>
                        </tr></thead>
                        <tbody id="structure-deletion-modal-orphan-content"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer hidden" id="structure-deletion-modal-toolbar">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="structure-deletion-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina struttura</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="link-content-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="view-modal-title"><i class="fa fa-link"></i> Associa contenuto esistente</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-link-content-id">Inserire l'id del contenuto da associare</label>
                    <input type="text" class="form-control" id="i-link-content-id" placeholder="Id" list="contents-list">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="link-content-modal-confirm" data-dismiss="modal"><i class="fa fa-link"></i> Associa contenuto</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="link-menu-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-link"></i> Associa menu secondario</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-link-menu-id">Inserire l'id del menu secondario associare</label>
                    <input type="text" class="form-control" id="i-link-menu-id" placeholder="Id" list="menus-list">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="link-menu-modal-confirm" data-dismiss="modal"><i class="fa fa-link"></i> Associa menu</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="link-plugin-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="link-plugin-modal-title"><i class="fa fa-link"></i> Associa componente aggiuntivo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control selectpicker" id="i-link-plugin-name">
                        <?php foreach($plugins as $plugin): ?>
                            <option data-content="<span class='label label-info'><?=$plugin->name ?></span> <?=$plugin->title ?>"><?=$plugin->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="link-plugin-modal-confirm" data-dismiss="modal"><i class="fa fa-link"></i> Associa componente aggiuntivo</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-content-modal" tabindex="-1" role="dialog" aria-labelledby="new-content-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-content-modal-label"><i class="fa fa-lg fa-plus"></i> Associa nuovo contenuto</h4>
            </div>
            <div class="modal-body">
                <div id="new-content-modal-selector">
                    <div class="form-group">
                        <label class="control-label" for="i-page-layout"> Scegliere il tipo di contenuto da creare</label>
                        <select class="selectpicker form-control" id="i-content-type">
                            <?php foreach($components_list as $component): ?>
                                <option data-content="<span class='label label-default'><?=$component['name'] ?></span>  <?=$component['description'] ?>"><?=$component['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-info min-space-top no-margin" id="layout-change-warning"><i class="fa fa-info-circle"></i> NB: tutte le modifiche apportate verranno salvate (non sarà più possibile ripristinare una versione precedente). L'editor contenuti verrà aperto</p>
                    </div>
                    <div id="new-content-modal-wait">
                        <p>Aggiunta del contenuto alla pagina. Attendere...</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="new-content-modal-create-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-content-modal-confirm"><i class="fa fa-bolt"></i> Crea contenuto</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-content-modal" tabindex="-1" role="dialog" aria-labelledby="edit-content-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="edit-content-modal-label"><i class="fa fa-lg fa-edit"></i> Modifica contenuto</h4>
            </div>
            <div class="modal-body">
                <p>Salvataggio delle modifiche apportate. Attendere...</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="events-cage">
    <div class="col-lg-<?=$has_sidebar ? '6' : '12' ?> editor-parent-element">
        <h3 class="ui horizontal divider header">
            Contenuto principale
        </h3>
        <div class="btn-group" role="group">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-link"></i> Associa <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="link-standard-content"><i class="fa fa-fw fa-link"></i> Contenuto esistente</a></li>
                    <li><a href="#" class="new-standard-content"><i class="fa fa-fw fa-plus"></i> Nuovo contenuto</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" class="link-plugin"><i class="fa fa-fw fa-plug"></i> Componente aggiuntivo</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="new-tabs-block"><i class="fa fa-fw fa-clone"></i> Vista a schede multiple</a></li>
                    <li><a href="#" class="new-collapse-block"><i class="fa fa-fw fa-bars"></i> Vista a pannelli multipli</a></li>
                    <li><a href="#" class="new-generic-box"><i class="fa fa-fw fa-square-o"></i> Pannello singolo</a></li>
                </ul>
            </div>
        </div>
        <br><br>
        <ul class="sortable" id="sortable-main-content">
            <?=$main_content ?>
        </ul>
    </div>

    <?php if($has_sidebar): ?>
        <div class="col-lg-6 editor-parent-element">
            <h3 class="ui horizontal divider header">
                Barra laterale (<span id="sidebar-side"><?=$sidebar_text ?></span>)
            </h3>
            <div class="btn-group">
                <div class="btn-group">
                    <button id="new-dropdown" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-link"></i> Associa <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="link-standard-content"><i class="fa fa-fw fa-link"></i> Contenuto esistente</a></li>
                        <li><a href="#" class="new-standard-content"><i class="fa fa-fw fa-plus"></i> Nuovo contenuto</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" class="link-sec-menu"><i class="fa fa-fw fa-list"></i> Menu secondario</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="new-tabs-block"><i class="fa fa-fw fa-clone"></i> Vista a schede multiple</a></li>
                        <li><a href="#" class="new-collapse-block"><i class="fa fa-fw fa-bars"></i> Vista a pannelli multipli</a></li>
                        <li><a href="#" class="new-generic-box"><i class="fa fa-fw fa-square-o"></i> Pannello singolo</a></li>
                    </ul>
                </div>
            </div>
            <br><br>
            <ul class="sortable" id="sortable-sidebar">
                <?=$sidebar_content ?>
            </ul>
        </div>
    <?php endif; ?>
</div>