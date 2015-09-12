<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><li>
    <div class="panel panel-info editor-parent-element structure-view">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="f-view-title"><?=$title ?></span>
                <span class="label label-default f-view-id"><?=$id ?></span>
                <div class="dropdown pull-right">
                    <a class='lmb tooltipped' data-toggle='dropdown' title='Associa'><i class='fa fa-link'></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="link-standard-content"><i class="fa fa-fw fa-link"></i> Contenuto esistente</a></li>
                        <li><a href="#" class="new-standard-content"><i class="fa fa-fw fa-plus"></i> Nuovo contenuto</a></li>
                    </ul>
                </div>
                <div class="dropdown pull-right">
                    <a class='lmb tooltipped' data-toggle='dropdown' title='Nuovo'><i class='fa fa-plus'></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="new-tabs-block"><i class="fa fa-fw fa-clone"></i> Vista a schede multiple</a></li>
                        <li><a href="#" class="new-collapse-block"><i class="fa fa-fw fa-bars"></i> Vista a pannelli multipli</a></li>
                        <li><a href="#" class="new-generic-box"><i class="fa fa-fw fa-square-o"></i> Pannello singolo</a></li>
                    </ul>
                </div>
                <a class='remove-view lmb pull-right tooltipped' title='Elimina'><i class='fa fa-remove'></i></a>
                <a class='edit-view lmb pull-right tooltipped' title='Modifica'><i class='fa fa-edit'></i></a>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="sortable sortable-items">
                <?=$items_rendered ?>
            </ul>
        </div>
    </div>
</li>