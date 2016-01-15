<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><table class="table table-hover file-picker-list">
    <?php foreach($files as $file): ?>
        <tr class="file-picker-<?=$file['type'] ?> file-picker-element" data-path="<?=$file['path'] ?>">
            <td><i class="fa fa-lg fa-fw <?=$file['icon'] ?>"></i> <a href="#" class="file-manager-picker-link"><?=$file['name'] ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>