<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><table class="table table-hover file-manager-list">
    <thead>
        <tr><th>Nome</th> <th>Dimensione</th><th>Ultima modifica</th></tr>
    </thead>
    <tbody>
        <?php foreach($files as $file): ?>
            <tr class="file-manager-<?=$file['type'] ?> file-manager-element" data-path="<?=$file['path'] ?>" <?=$file['type']==='file-previewable' ? 'data-previewmode="'.$file['preview_mode'].'"' : '' ?>>
                <td>
                    <input type="checkbox" class="file-manager-select-element" value="<?=$file['name'] ?>"> <i class="fa fa-lg fa-fw <?=$file['icon'] ?>"></i> <a href="#" class="file-manager-element-link"><?=$file['name'] ?></a>
                    <div class="dropdown pull-right">
                        <a class="dropdown-toggle lmbnc pull-right tooltipped" type="button" data-toggle="dropdown" title="Più opzioni">
                            <i class="fa fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="file-manager-rename-element"><i class="fa fa-pencil fa-fw"></i> Rinomina</a></li>
                            <li><a href="#" class="file-manager-delete-element"><i class="fa fa-trash fa-fw"></i> Elimina</a></li>
                            <li><a href="#" class="file-manager-move-element"><i class="fa fa-caret-square-o-right fa-fw"></i> Sposta</a></li>
                            <li><a href="#" class="file-manager-copy-element"><i class="fa fa-copy fa-fw"></i> Copia</a></li>
                        </ul>
                    </div>
                    <?php if($file['type']!=='file'): ?>
                        <a class="file-manager-download-element lmbnc pull-right tooltipped" title="Scarica"><i class="fa fa-download"></i></a>
                    <?php endif; ?>
                </td>
                <td><?=$file['size']?></td>
                <td><?=$file['edit_date']?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>