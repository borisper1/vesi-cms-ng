<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><span id="target-hidden" class="hidden"><?=$target ?></span>
<div class="row">
    <div class="col-md-9">
        <label for="input-title">Titolo del link:</label>
        <input type="text" class="form-control" id="input-title" placeholder="Inserisci titolo" value="<?=$title ?>">
        <br>
        <div class="well">
            <div class="form-group">
                <label for="link-path"><i class="fa fa-link"></i> Inserire il percorso o l"URL del link</label>
                <input type="text" class="form-control" id="link-path" placeholder="Indirizzo del link" value="<?=$url?>">
            </div>
            <p>Il link non può essere relativo alla base del sito, deve essere un link assoluto. Protocolli supportati: <code>http://</code>, <code>https://</code> o <code>ftp://</code>.
            <br>Solo i link validi saranno accettati.</p>
        </div>
    </div>
    <div class="col-md-3">
        <label for="input-class">Classi da applicare al link:</label>
        <input type="text" class="form-control" id="input-class" placeholder="Inserisci classi" value="<?=$class ?>">
        <br>
        <label for="input-target">Scegliere la destinazione del link:</label>
        <select class="form-control" id="input-target">
            <option value="">Normale</option>
            <option value="_blank">Nuova finestra</option>
        </select>
    </div>
</div>
