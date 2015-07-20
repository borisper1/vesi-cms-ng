<?php
defined("BASEPATH") OR exit("No direct script access allowed");
?><table class="table table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Dimensione</th>
            <th>Ultima modifica</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($files as $file): ?>
        <tr>
            <td><i class="fa fa-lg <?=$file->icon ?>"></i> <a href="<?=$file->url ?>" target='_blank'><?=$file->name ?></a></td>
            <td><span class='text-muted'><?=$file->size ?></span></td>
            <td><span class='text-muted'><?=$file->date ?></span></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>