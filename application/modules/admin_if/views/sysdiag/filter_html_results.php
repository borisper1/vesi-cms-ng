<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><p>Sono stati modificati <?=count($contents) ?> contenuti.</p>
<a role="button" data-toggle="collapse" href="#detailed-results" aria-expanded="false" aria-controls="collapseExample">Mostra dettagli</a>
<div class="collapse" id="detailed-results">
    <p>I seguenti contenuti sono stati modificati. Viene visualizzato l'hash MD5 del contenuto modificato e quello del contenuto precedente
    <table class="table">
        <thead>
        <tr><th>Id</th><th>Tipo</th><th>MD5 contenuto precedente</th><th>MD5 contenuto modificato</th></tr>
        </thead>
        <tbody>
        <?php foreach($contents as $content): ?>
            <tr><td><?=$content['id'] ?></td><td><?=$content['type'] ?></td><td><?=$content['old_digest'] ?></td><td><?=$content['digest'] ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</div>