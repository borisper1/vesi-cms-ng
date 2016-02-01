<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url('assets/third_party/semantic-ui/components/header.min.css') ?>">
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <div class="list-group-item active"><h4 class="list-group-item-heading">Accesso rapido</h4></div>
            <a href="<?= base_url('admin/pages') ?>" class="list-group-item"><i class="fa fa-file"></i> Pagine</a>
            <a href="<?= base_url('admin/circolari_engine') ?>" class="list-group-item"><i class="fa fa-copy"></i>
                Circolari</a>
            <a href="<?= base_url('admin/files') ?>" class="list-group-item"><i class="fa fa-upload"></i> File e
                immagini</a>
            <a href="<?= base_url('admin/sysevents') ?>" class="list-group-item"><i class="fa fa-bell"></i> Avvisi di sistema
                <span class="badge"><?=$unread_errors==0 ? '' : $unread_errors ?></span></a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="alert alert-warning" role="alert"><i class="fa fa-warning"></i> <b>Attenzione</b>: questa è una
            versione di pre rilascio di <code>vesi-cms-ng</code>,
            pertanto alcune funzionalità potrebbero non essere implementate, potrebbero esserci bug evidenti che possono
            anche causare perdita di dati. <br>
            Per un elenco dei problemi conosciuti e per segnalare eventuali bug riscontati vistare <a class="alert-link"
                                                                                                      href="https://github.com/borisper1/vesi-cms-ng/issues"
                                                                                                      target="_blank">GitHub</a>
        </div>
        <div class="row">
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-server"></i>
                    <div class="content">
                        ---
                        <div class="sub header">Richieste/giorno</div>
                    </div>
                </h2>
            </div>
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-eye"></i>
                    <div class="content">
                        ---
                        <div class="sub header">Visitatori/giorno</div>
                    </div>
                </h2>
            </div>
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-file"></i>
                    <div class="content">
                        <?= $pages ?>
                        <div class="sub header">Pagine</div>
                    </div>
                </h2>
            </div>
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-cubes"></i>
                    <div class="content">
                        <?= $contents ?>
                        <div class="sub header">Contenuti</div>
                    </div>
                </h2>
            </div>
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-bell"></i>
                    <div class="content">
                        <?= $unread_errors ?>
                        <div class="sub header">Avvisi non letti</div>
                    </div>
                </h2>
            </div>
            <div class="col-sm-2 text-center">
                <h2 class="ui icon header">
                    <i class="fa fa-question"></i>
                    <div class="content">
                        ---
                        <div class="sub header">---</div>
                    </div>
                </h2>
            </div>
        </div>
    </div>
</div>


