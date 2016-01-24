<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><h4>Componenti registrati</h4>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Tipo</th>
            <th>Nome</th>
            <th>Descrizione</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($registered_components as $component): ?>
            <tr>
                <td>
                    <?php if ($component['type'] === 'admin_interface'): ?>
                        <i class="fa fa-list-alt"></i> Interfaccia amministrativa
                    <?php elseif ($component['type'] === 'config_interface'): ?>
                        <i class="fa fa-wrench"></i> Interfaccia di configurazione
                    <?php elseif ($component['type'] === 'service'): ?>
                        <i class="fa fa-gears"></i> Servizio
                    <?php elseif ($component['type'] === 'component'): ?>
                        <i class="fa fa-cube"></i> Componente (per contenuto)
                    <?php endif; ?>
                </td>
                <td><i class="fa fa-fw <?= $component['icon'] ?>"></i> <?= $component['title'] ?> <span
                        class="label label-info"><?= $component['name'] ?></span></td>
                <td><?= $component['description'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<h4>Files del componente aggiuntivo</h4>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Percorso</th>
            <th>Installato</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file): ?>
            <tr>
                <td><code><?= $file['path'] ?></code></td>
                <td>
                    <?php if ($file['installed']): ?>
                        <span class="text-success"><i class="fa fa-check"></i> File installato</span>
                    <?php else: ?>
                        <span class="text-danger"><i
                                class="fa fa-exclamation-circle"></i> Impossibile trovare il file</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
