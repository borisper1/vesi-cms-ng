<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><span id="position-hidden" class="hidden"><?=$placement ?></span>
<div class='row'>
    <div class='col-md-9'>
        <label for="input-title">Etichetta del pulsante popover:</label>
        <input type="text" class="form-control" id="input-name" placeholder="Inserisci etichetta" value="<?=$name?>">
        <br>
        <label for="input-title">Titolo del popover:</label>
        <input type="text" class="form-control" id="input-title" placeholder="Inserisci titolo" value="<?=$title?>">
        <br>
        <textarea class='textarea-small' id='gui_editor'><?=$content?></textarea>
    </div>
    <div class='col-md-3'>
        <label for="input-class">Classi da applicare al popover:</label>
        <input type="text" class="form-control" id="input-class" placeholder="Inserisci classi" value="<?=$class?>">
        <br>
        <label for="input-position">Scegliere la posizione del popover:</label>
        <select class="form-control" id="input-position">
            <option value='left'>A sinistra</option>
            <option value='right'>A destra</option>
            <option value='top'>In alto</option>
            <option value='bottom'>In basso</option>
        </select>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="input-linebreak" <?=$linebreak ? 'checked' : ''?>>
                Aggiungi riga sotto (manda a capo dopo il pulsante)
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="input-dismissable" <?=$dismissable ? 'checked' : ''?>>
                Chiudi automaticamente quando si clicca fuori (trigger="focus")
            </label>
        </div>
    </div>
</div>