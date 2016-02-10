<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class='row'>
    <div class='col-md-9'>
        <div class="form-group">
            <label for="input-title">Titolo del riquadro notizie:</label>
            <input type="text" class="form-control" id="input-title" placeholder="Inserisci titolo"
                   value="<?= $title ?>">
        </div>
        <p><b>Scegliere le categorie da visualizzare:</b></p>
        <div id="category-editor-gui">
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-default" id="add-category"><i class="fa fa-plus-square"></i>
                    Aggiungi categoria
                </button>
            </div>
            <div class="well" id="gui-editor-area">
                <?php foreach (array_keys($content) as $category): ?>
                    <span class="label label-default category-element">
                    <span class="category"><?= $category ?></span>  [<i><span
                                class="remapping-url"><?= $content[$category] ?></span></i>]
                    <a href="#gui-editor-area" class="delete-element lmb tooltipped" data-toggle="tooltip"
                       title="Elimina"><i class="fa fa-remove"></i></a>
                </span>&nbsp;
                <?php endforeach; ?>
            </div>
            <div class="hidden" id="category-template">
                <span class="label label-default category-element">
                    <span class="category"></span>  [<i><span class="remapping-url"></span></i>]
                    <a href="#gui-editor-area" class="delete-element lmb tooltipped" data-toggle="tooltip"
                       title="Elimina"><i class="fa fa-remove"></i></a>
                </span>&nbsp;
            </div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class="form-group">
            <label for="input-class">Classi da applicare al popover:</label>
            <input type="text" class="form-control" id="input-class" placeholder="Inserisci classi"
                   value="<?= $class ?>">
        </div>
        <div class="form-group">
            <label for="input-limit">Numero di notizie da visualizzare:</label>
            <input type="number" class="form-control" id="input-limit" placeholder="Inserisci limite"
                   value="<?= $limit ?>">
        </div>
    </div>
</div>

<div class="modal fade" id="link-category-modal" tabindex="-1" role="dialog" aria-labelledby="link-catgeory-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="link-category-modal-label"><i class="fa fa-plus"></i> Aggiungi categoria</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="i-category">Inserire il nome della categoria da collegare</label>
                    <input type="text" class="form-control" id="i-category" placeholder="Catgeoria" list="category-list">
                </div>
                <div class="form-group">
                    <label for="i-remapping">Inserire l'URL relativo alla base del sito a cui rimandare i link</label>
                    <input type="text" class="form-control" id="i-remapping" placeholder="Rimanda a">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="link-category-modal-confirm" data-dismiss="modal"><i
                        class="fa fa-plus"></i> Aggiungi categoria
                </button>
            </div>
        </div>
    </div>
</div>

<datalist id="category-list">
    <?php foreach ($all_cats as $cat): ?>
        <option><?= $cat ?></option>
    <?php endforeach; ?>
</datalist>