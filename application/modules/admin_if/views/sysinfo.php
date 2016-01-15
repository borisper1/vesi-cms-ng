<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-info-circle"></i> Informazioni sul sistema</h1></div>
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Informazioni
                su</a></li>
        <li role="presentation"><a href="#php" aria-controls="php" role="tab" data-toggle="tab">Interprete PHP</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <h3>Vesi CMS 1.2.0-beta1
                <small>(vesi-cms-ng) <span class="label label-warning">BETA VERSION, NOT FOR RELEASE</span> <span
                        class="label label-info">patch level: 43dc23f</span></small>
            </h3>
            <p>Sviluppato da Boris Pertot - Copyright <span class='fa fa-copyright'></span> 2016 Boris Pertot</p>
            <p class="text-muted">This program is free software; you can redistribute it and/or modify
                it under the terms of the GNU General Public License as published by
                the Free Software Foundation; either version 2 of the License, or
                (at your option) any later version.<br>

                This program is distributed in the hope that it will be useful,
                but WITHOUT ANY WARRANTY; without even the implied warranty of
                MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
                GNU General Public License for more details.</p>

            <h4>Informazioni sul server</h4>
            <?php $php_version_class = version_compare(phpversion(), '5.6.0', '<') ? 'text-danger' : (version_compare(phpversion(), '7.0.0', '>=') ? 'text-success' : 'text-warning') ?>
            <p><b><?= $_SERVER["SERVER_NAME"] ?></b> <span class="label label-info"><?= base_url() ?></span> in
                esecuzione su <code><?= $_SERVER["SERVER_SOFTWARE"] ?></code> con PHP <span
                    class="<?= $php_version_class ?>"><?= phpversion() ?></span></p>
            <p>Vesi CMS 1.2 richiede PHP 5.5.0 o successivo. La versione 5.5 è sconsigliata (<a
                    href="https://secure.php.net/supported-versions.php" target="_blank">a causa della fine del
                    supporto</a>), per ottenere migliori prestazioni si consiglia di usare l'ultima versione di PHP (PHP
                7 o successivo)</p>

            <h4>Software di terze parti utilizzato:</h4>
            <table class="table table-striped">
                <thead><tr>
                    <th>Componente</th>
                    <th>Versione</th>
                </tr></thead>
                <tr>
                    <td><a href="https://codeigniter.com/" target="_blank">CodeIgniter</a></td>
                    <td>3.0.3</td>
                </tr>
                <tr>
                    <td><a href="https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc" target="_blank">Modular
                            Extensions - HMVC</a></td>
                    <td>5.5</td>
                </tr>
                <tr>
                    <td><a href="https://jquery.com/" target="_blank">jQuery</a></td>
                    <td>1.11.3 (modalità di compatibilità) e 2.1.4</td>
                </tr>
                <tr>
                    <td><a href="https://jqueryui.com/" target="_blank">jQuery UI</a></td>
                    <td>1.11.4</td>
                </tr>
                <tr>
                    <td><a href="http://getbootstrap.com/" target="_blank">Bootstrap</a></td>
                    <td>3.3.5</td>
                </tr>
                <tr>
                    <td><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a></td>
                    <td>4.4.0</td>
                </tr>
                <tr>
                    <td><a href="https://github.com/CWSpear/bootstrap-hover-dropdown/" target="_blank">Bootstrap Hover Dropdown Plugin</a></td>
                    <td>2.1.3</td>
                </tr>
                <tr>
                    <td><a href="https://silviomoreto.github.io/bootstrap-select/" target="_blank">bootstrap-select</a>
                    </td>
                    <td>1.7.3</td>
                </tr>
                <tr>
                    <td><a href="http://www.bootstrap-switch.org" target="_blank">bootstrap-switch</a></td>
                    <td>3.3.2</td>
                </tr>
                <tr>
                    <td><a href="http://ckeditor.com/" target="_blank">CK Editor</a></td>
                    <td>4.5.3</td>
                </tr>
                <tr>
                    <td><a href="http://ace.c9.io/" target="_blank">Ace Editor</a></td>
                    <td>? UNKNOWN VERSION ?</td>
                </tr>
                <tr>
                    <td><a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmLawed</a></td>
                    <td>1.2.beta.9</td>
                </tr>
                <tr>
                    <td><a href="http://blueimp.github.io/jQuery-File-Upload/" target="_blank">jQuery File Upload</a></td>
                    <td>9.11.2</td>
                </tr>
                <tr>
                    <td><a href="https://github.com/afarkas/html5shiv" target="_blank">html5shiv</a></td>
                    <td>3.7.3</td>
                </tr>
                <tr>
                    <td><a href="https://github.com/scottjehl/Respond" target="_blank">Respond.js</a></td>
                    <td>1.4.2</td>
                </tr>
                <tr>
                    <td><a href="http://semantic-ui.com/" target="_blank">Semantic UI</a></td>
                    <td>2.0.8</td>
                </tr>

            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="php">
            <br>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item"
                        src="<?= base_url('assets/administration/phpinfo.php?key=3133F459B4F31EAC959BD488A64A5') ?>"></iframe>
            </div>
        </div>
    </div>
</div>