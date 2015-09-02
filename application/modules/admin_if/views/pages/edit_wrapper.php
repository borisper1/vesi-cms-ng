<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><link rel="stylesheet" href="<?=base_url('assets/third_party/semantic-ui/components/header.min.css') ?>">
<link rel="stylesheet" href="<?=base_url('assets/third_party/semantic-ui/components/divider.min.css') ?>">
<div class="page-header"><h1><i class="fa fa-file"></i> Pagine</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-title"><?=$title ?></span>
    <small><span class="label label-info"><span id="f-container"><?=$container ?></span> <i class="fa fa-ellipsis-v"></i> <span id="f-page-name"><?=$page_name ?></span></span> <span class="label label-default" id="f-id"><?=$id ?></span></small>
</h3>
<div class="btn-group pull-right" id="page-actions">
    <button type="button" class="btn btn-default" id="save-page"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code" disabled><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="edit-attributes"><i class="fa fa-wrench"></i> Modifica attributi</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>
<span id="f-page-layout" class="hidden"><?=$layout ?></span>
<br>

<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare la pagina:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Pagina salvata con successo, <b>Premere su <i>Aggiorna</i></b> per ricaricare le informazioni sullo stato contenuti</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio della pagina...</div>

<datalist id="containers-list">
    <?php foreach($containers as $container): ?>
    <option value="<?=$container ?>">
        <?php endforeach; ?>
</datalist>

<div class="modal fade" id="edit-attributes-modal">
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

<div class="modal fade" id="view-modal">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="view-modal-confirm"></button>
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
                    <li><a href="#" class="link-sec-plugin"><i class="fa fa-fw fa-plug"></i> Plugin</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="new-tabs-block"><i class="fa fa-fw fa-clone"></i> Vista a schede multiple</a></li>
                    <li><a href="#" class="new-collapse-block"><i class="fa fa-fw fa-bars"></i> Vista a pannelli multipl</a></li>
                </ul>
            </div>
        </div>
        <br><br>
        <ul class="sortable sortable-main">
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
                        <li><a href="#" class"new-standard-content"><i class="fa fa-fw fa-plus"></i> Nuovo contenuto</a></li>
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
                        <li><a href="#" class="new-collapse-block"><i class="fa fa-fw fa-bars"></i> Vista a pannelli multipl</a></li>
                    </ul>
                </div>
            </div>
            <br><br>
            <ul class="sortable sortable-main">
                <?=$sidebar_content ?>
            </ul>
        </div>
    <?php endif; ?>
</div>