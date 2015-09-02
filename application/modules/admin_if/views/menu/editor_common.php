<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><ul class="sortable sortable-main" id="events-cage">
    <?php foreach($menu_structure as $menu): ?>
        <li>
            <?php if($menu['type']==='dropdown'): ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title parent-voices" data-type="dropdown">
                            <span class="f-title"><?=$menu['title'] ?></span>
                            <span class="label label-default f-container"><?=$menu['container'] ?></span>
                            <a class='new-child lmb pull-right tooltipped' data-toggle='tooltip' title='Aggiungi sottovoce'><i class='fa fa-plus'></i></a>
                            <a class='remove-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                            <a class='edit-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <ul class="sortable sortable-subv">
                            <?php foreach($menu['items'] as $item): ?>
                                <li>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title child-voices">
                                                <i class="fa fa-sort"></i> <span class="f-title"><?=$item['title'] ?></span> <span class="label label-default f-page"><?=$item['page'] ?></span>
                                                <?php if($item['status']): ?>
                                                    <?php if($item['status']['redirect']): ?>
                                                        <i class="fa fa-exchange tooltipped" data-toggle="tooltip" title="Reindirizzamento del contenitore: <i><?=$item['status']['redirect'] ?></i>"></i>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip" title="Pagina inesistente"></i>
                                                <?php endif; ?>
                                                <a class='remove-child lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                                                <a class='edit-child lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
                                            </h3>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title parent-voices" data-type="link">
                            <span class="f-title"><?=$menu['title'] ?></span> <span class="label label-default"><span class="f-container"><?=$menu['container']?></span> <i class="fa fa-ellipsis-v"></i> <span class="f-page"><?=$menu['page'] ?></span></span>
                            <?php if($menu['status']): ?>
                                <?php if($menu['status']['redirect']): ?>
                                    <i class="fa fa-exchange tooltipped" data-toggle="tooltip" title="Reindirizzamento del contenitore: <i><?=$menu['status']['redirect'] ?></i>"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip" title="Pagina inesistente"></i>
                            <?php endif; ?>
                            <a class='remove-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                            <a class='edit-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
                        </h3>
                    </div>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<div id="child-template" class="hidden">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title child-voices">
                <i class="fa fa-sort"></i> <span class="f-title"></span> <span class="label label-default f-page"></span>
                <a class='remove-child lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                <a class='edit-child lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
            </h3>
        </div>
    </div>
</div>

<div id="parent-dropdown-template" class="hidden">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title parent-voices" data-type="dropdown">
                <span class="f-title"></span>
                <span class="label label-default f-container"></span>
                <a class='new-child lmb pull-right tooltipped' data-toggle='tooltip' title='Aggiungi sottovoce'><i class='fa fa-plus'></i></a>
                <a class='remove-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                <a class='edit-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="sortable sortable-subv"></ul>
        </div>
    </div>
</div>

<div id="parent-link-template" class="hidden">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title parent-voices" data-type="link">
                <span class="f-title"></span> <span class="label label-default"><span class="f-container"></span> <i class="fa fa-ellipsis-v"></i> <span class="f-page"></span></span>
                <a class='remove-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-remove'></i></a>
                <a class='edit-parent lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
            </h3>
        </div>
    </div>
</div>

<datalist id="containers-list">
    <?php foreach($containers as $container): ?>
    <option value="<?=$container ?>">
        <?php endforeach; ?>
</datalist>

<datalist id="cscope-pages"></datalist>

<div class="modal fade" id="parent-delete-modal" tabindex="-1" role="dialog" aria-labelledby="pardel-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="pardel-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione voce principale</h4>
            </div>
            <div class="modal-body">
                Eliminando una voce prinicpale verranno eliminate anche tutte le voci secondarie. Eliminare questa voce?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="pardel-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina voce prinicipale</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="child-modal" tabindex="-1" role="dialog" aria-labelledby="child-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="child-modal-label"></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-child-name">Inserire il nome per la voce di menu</label>
                    <input type="text" class="form-control" id="i-child-name" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label for="i-child-page">Inserire il nome della pagina da collegare alla voce</label>
                    <input type="text" class="form-control" id="i-child-page" placeholder="Pagina" list="cscope-pages">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="child-modal-confirm" data-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dropdown-modal" tabindex="-1" role="dialog" aria-labelledby="dropdown-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="dropdown-modal-label"></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-parent-dropdown-name">Inserire il nome per il menu a tendina</label>
                    <input type="text" class="form-control" id="i-parent-dropdown-name" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label for="i-parent-dropdown-container">Inserire il nome del contenitore da associare al menu</label>
                    <input type="text" class="form-control" id="i-parent-dropdown-container" placeholder="Contenitore" list="containers-list">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="dropdown-modal-confirm" data-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="link-modal" tabindex="-1" role="dialog" aria-labelledby="link-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="link-modal-label"></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="i-parent-link-name">Inserire il nome per il link</label>
                    <input type="text" class="form-control" id="i-parent-link-name" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label for="i-parent-link-container">Inserire il contenitore di destinazione</label>
                    <input type="text" class="form-control" id="i-parent-link-container" placeholder="Contenitore" list="containers-list">
                </div>
                <div class="form-group">
                    <label for="i-parent-link-page">Inserire il nome della pagina di destinazione</label>
                    <input type="text" class="form-control" id="i-parent-link-page" placeholder="Pagina" list="cscope-pages">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="link-modal-confirm" data-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>
