<?php
defined("BASEPATH") OR exit("No direct script access allowed");
?><div id="<?=$id?>" class="carousel slide component_carousel" data-ride="carousel">

    <ol class="carousel-indicators">
        <?php $active = true; $i=0; ?>
        <?php foreach($files as $file): ?>
            <li data-target="#<?=$id?>" data-slide-to="<?=$i?>"<?= $active ? "class=\"active\"" : ""?>></li>
            <?php $active = false; $i+=1; ?>
        <?php endforeach ?>
    </ol>

    <div class="carousel-inner" role="listbox">
        <?php $active = true;?>
        <?php foreach($files as $file): ?>
            <div class="item <?= $active ? "active" : ""?>">
                <img src="<?=$file ?>" alt="Unable to load carousel images">
            </div>
            <?php $active = false;?>
        <?php endforeach ?>
    </div>

    <a class="left carousel-control" href="#<?=$id?>" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Precedente</span>
    </a>
    <a class="right carousel-control" href="#<?=$id?>" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Successivo</span>
    </a>
</div>
<br>