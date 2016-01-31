<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Impossibile visualizzare il contenuto <code><?= $id ?></code></h3>
    </div>
    <div class="panel-body">
        <p>Il contenuto <code><?= $id ?></code> richiede il componente <code><?= $component ?></code> per la
            visualizzazione. Installare questo componente. Se il componente fa parte dei componenti di sistema
            sarà necessario riparare l'installazione di Vesi-CMS</p>
    </div>
</div>