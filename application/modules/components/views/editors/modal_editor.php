<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class='row'>
    <div class='col-md-9'>
        <label for="input-title">Titolo della finestra di dialogo:</label>
        <input type="text" class="form-control" id="input-title" placeholder="Inserisci titolo" value="<?=$title?>">
        <br>
        <textarea class='textarea-small' id='gui_editor'><?=$content?></textarea>
        <br>
    </div>
    <div class='col-md-3'>
        <label for="input-class">Classi da applicare al pulsante:</label>
        <input type="text" class="form-control" id="input-class" placeholder="Inserisci classi" value="<?=$trigger_class?>">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="input-close" <?=$close ? 'checked' : '' ?>>
                Mostra pulsante di chiusura
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="input-large" <?=$large ? 'checked' : '' ?>>
                Usa finestra di dialogo grande (modal-large)
            </label>
        </div>
    </div>
</div>