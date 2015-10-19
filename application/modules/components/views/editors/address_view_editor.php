<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><span id="position-hidden" class="hidden"><?=$placement ?></span>
<div class='row'>
    <div class="col-md-9" id="events-cage">
        <textarea class='textarea-small' id='gui_editor'><?=$road_address?></textarea>
        <br>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Indirizzi E-Mail:
                    <a class="lmb pull-right tooltipped" id="new-email" title="Aggiungi indirizzo e-mail"><i class="fa fa-plus"></i></a>                </h3>
            </div>
            <div class="panel-body">
                <ul class="sortable" id="email-container">
                    <?php foreach($emails as $email): ?>
                        <li>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title email-voices" data-type="link">
                                        <i class="fa fa-envelope"></i> <span class="label label-info f-type"><?=$email->type ?></span> <span class="f-address"><?=$email->address ?></span> <span class="f-label label label-default"><?=$email->label ?></span>
                                        <a class="remove-item lmb pull-right tooltipped" data-toggle="tooltip" title="Rimuovi indirizzo e-mail"><i class="fa fa-remove"></i></a>
                                    </h3>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Numeri di telefono/fax:
                    <a class="lmb pull-right tooltipped" id="new-phone" title="Aggiungi numero telefono/fax"><i class="fa fa-plus"></i></a>
                </h3>
            </div>
            <div class="panel-body">
                <ul class="sortable" id="phone-container">
                    <?php foreach($phones as $phone): ?>
                        <li>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title phone-voices" data-type="link">
                                        <i class="fa <?=$phone->type==='standard' ? 'fa-phone' : 'fa-fax' ?> f-icon"></i> <span class="label label-info f-type"><?=$phone->type ?></span> <span class="f-number"><?=$phone->phone ?></span> <span class="f-label label label-default"><?=$phone->label ?></span>
                                        <a class="remove-item lmb pull-right tooltipped" data-toggle="tooltip" title="Rimuovi numero telefono/fax"><i class="fa fa-remove"></i></a>
                                    </h3>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class='col-md-3'>
        
    </div>
</div>

<div id="email-template" class="hidden">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title email-voices" data-type="link">
                <i class="fa fa-envelope"></i> <span class="label label-info f-type"></span> <span class="f-address"></span> <span class="f-label label label-default"></span>
                <a class="remove-item lmb pull-right tooltipped" data-toggle="tooltip" title="Rimuovi indirizzo email"><i class="fa fa-remove"></i></a>
            </h3>
        </div>
    </div>
</div>

<div id="phone-template" class="hidden">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title phone-voices" data-type="link">
                <i class="fa f-icon"></i> <span class="label label-info f-type"></span> <span class="f-number"></span> <span class="f-label label label-default"></span>
                <a class="remove-item lmb pull-right tooltipped" data-toggle="tooltip" title="Rimuovi numero telefono/fax"><i class="fa fa-remove"></i></a>
            </h3>
        </div>
    </div>
</div>


<div class="modal fade" id="email-new-modal" tabindex="-1" role="dialog" aria-labelledby="newemail-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="newemail-modal-label">Aggiungi indirizzo email</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="email-type">Scegliere un tipo di indirizzo da aggiungere</label>
                    <select class="form-control" id="email-type">
                        <option value="standard">Indirizzo mail standard</option>
                        <option value="pec">Indirizzo PEC (Posta Elettronica Certificata)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="email-address">Inserire l"indirizzo mail da aggiungere</label>
                    <input type="email" class="form-control" id="email-address" placeholder="Indirizzo email">
                </div>
                <div class="form-group">
                    <label class="control-label" for="email-label">Aggiungere una etichetta descrittiva (opzionale, non usare per indirizzo principale)</label>
                    <input type="text" class="form-control" id="email-label" placeholder="Etichetta">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-success" id="email-new-modal-confirm" data-dismiss="modal">Aggiungi indirizzo</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="phone-new-modal" tabindex="-1" role="dialog" aria-labelledby="newphone-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="newphone-modal-label">Aggiungi numero telefono/fax</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="phone-type">Scegliere un tipo di indirizzo da aggiungere</label>
                    <select class="form-control" id="phone-type">
                        <option value="standard">Numero di telefono standard</option>
                        <option value="fax">Numero FAX</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="phone-number">Inserire il numero di telefono/fax da aggiungere</label>
                    <input type="tel" class="form-control" id="phone-number" placeholder="Numero telefono/fax">
                </div>
                <div class="form-group">
                    <label class="control-label" for="phone-label">Aggiungere una etichetta descrittiva (opzionale, non usare per numero principale)</label>
                    <input type="text" class="form-control" id="phone-label" placeholder="Etichetta">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-success" id="phone-new-modal-confirm" data-dismiss="modal">Aggiungi numero</button>
            </div>
        </div>
    </div>
</div>