<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu_collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url('admin')?>">Vesi-CMS 1.2</a>
        </div>


        <div class="collapse navbar-collapse" id="main_menu_collapse">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Sistema <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('admin/config')?>"><i class="fa fa-fw fa-gear"></i> Impostazioni</a></li>
                        <li><a href="<?=base_url('admin/security')?>"><i class="fa fa-fw fa-shield"></i> Sicurezza</a></li>
                        <li><a href="<?=base_url('admin/sysdiag')?>"><i class="fa fa-fw fa-magic"></i> Risoluzione dei problemi</a></li>
                        <li><a href="<?=base_url('admin/plugins')?>"><i class="fa fa-fw fa-plug"></i> Componenti aggiuntivi</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin/users')?>"><i class="fa fa-fw fa-users"></i> Account utente</a></li>
                        <li><a href="<?=base_url('admin/groups')?>"><i class="fa fa-fw fa-lock"></i> Gruppi e permessi</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin/sysalerts')?>"><i class="fa fa-fw fa-bell"></i> Avvisi</a></li>
                        <li><a href="<?=base_url('admin/sysinfo')?>"><i class="fa fa-fw fa-info-circle"></i> Informazioni sul sistema</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-sitemap"></i> Struttura <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('admin/main_menu')?>"><i class="fa fa-fw fa-th-list"></i> Menu principale</a></li>
                        <li><a href="<?=base_url('admin/sec_menu/')?>"><i class="fa fa-fw fa-list"></i> Menu secondari</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin//footer')?>"><i class="fa fa-fw fa-file"></i> Piè di pagina</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil"></i> Contenuti <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('admin/pages')?>"><i class="fa fa-fw fa-file"></i> Pagine</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin/contents')?>"><i class="fa fa-fw fa-cubes"></i> Gestione contenuti</a></li>
                        <li><a href="<?=base_url('admin/alerts')?>"><i class="fa fa-fw fa-bullhorn"></i> Avvisi</a></li>
                        <li><a href="<?=base_url('admin/files')?>"><i class="fa fa-fw fa-upload"></i> File e immagini</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-user"></i><?=$user_fname ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('admin/users/user_messages')?>"><i class="fa fa-fw fa-envelope"></i> Messaggi</a></li>
                        <li><a href="<?=base_url('admin/users/user_settings')?>"><i class="fa fa-fw fa-gear"></i> Impostazioni</a></li>
                        <li><a href="#" class="vcms-elevator" data-href="users/user_profile"><i class="fa fa-fw fa-wrench"></i> Modifica utente</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin/logout') ?>" ><i class="fa fa-fw fa-sign-out"></i> Esci</a></li>
                    </ul>
                </li>

            </ul>
        </div>

    </div>
</nav>