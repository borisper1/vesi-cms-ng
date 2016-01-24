<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-plug"></i> Componenti aggiuntivi</h1></div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-success" id="new-content"><i class="fa fa-plus"></i> Installa</button>
</div>
<table class="table table-hover">
    <thead><tr>
        <th>Nome</th>
        <th>Descrizione</th>
        <th>Autore</th>
        <th>Versione</th>
    </tr></thead>
    <tbody>
        <tr>
            <td>
                Gestione circolari <span class="label label-info f-name">circolari_engine</span>
                <div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-default view-plugin-components"><i class="fa fa-eye">
                            Visualizza componenti</i></button>
                    <button type="button" class="btn btn-default"><i class="fa fa-wrench"></i> Ripara</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-trash"></i> Disinstalla</button>
                </div>
            </td>
            <td>Plugin per la gestione e la visualizzazione (anche in  frontend) delle circolari</td>
            <td>Boris Pertot</td>
            <td>1.0.0-alpha</td>
        </tr>
    </tbody>
</table>

<div class="modal fade" id="view-components-modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-eye"></i> Visualizza componenti componente aggiuntivo</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Chiudi
                </button>
            </div>
        </div>
    </div>
</div>