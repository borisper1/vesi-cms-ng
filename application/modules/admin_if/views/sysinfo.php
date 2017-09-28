<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-info-circle"></i> Informazioni sul sistema</h1></div>
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Informazioni
                su</a></li>
        <li role="presentation"><a href="#php" aria-controls="php" role="tab" data-toggle="tab">Interprete PHP</a></li>
        <li role="presentation"><a href="#setup" aria-controls="php" role="tab" data-toggle="tab">Dettagli
                installazione</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <h3>Vesi CMS 1.2.0-devS
                <small>(<a href="https://github.com/borisper1/vesi-cms-ng" target="_blank">vesi-cms-ng</a>) <span
							class="label label-danger">DEVELOPMENT VERSION &dash; NOT FOR RELEASE</span></small>
            </h3>
            <p>Sviluppato da Boris Pertot - Copyright <span class='fa fa-copyright'></span> 2016-2017 Boris Pertot</p>
			<p class="text-muted">Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:</p>
				<ol class="text-muted">
				<li>Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.</li>
				<li>Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.</li>
				<li>Neither the name of Vesi CMS nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.</li>
			</ol>
			<p class="text-muted">THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED
			WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
			PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY
			DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
			PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
			OWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
			NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
			POSSIBILITY OF SUCH DAMAGE.</p>

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
                    <td>3.1.6</td>
                </tr>
                <tr>
                    <td><a href="https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc" target="_blank">Modular
                            Extensions - HMVC</a></td>
                    <td>5.5+vcms12u1</td>
                </tr>
                <tr>
                    <td><a href="https://jquery.com/" target="_blank">jQuery</a></td>
                    <td>1.12.0 (modalità di compatibilità) e 2.2.0</td>
                </tr>
                <tr>
                    <td><a href="https://jqueryui.com/" target="_blank">jQuery UI</a></td>
                    <td>1.11.4</td>
                </tr>
                <tr>
                    <td><a href="http://getbootstrap.com/" target="_blank">Bootstrap</a></td>
                    <td>3.3.6</td>
                </tr>
                <tr>
                    <td><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a></td>
                    <td>4.5.0</td>
                </tr>
                <tr>
                    <td><a href="https://silviomoreto.github.io/bootstrap-select/" target="_blank">bootstrap-select</a>
                    </td>
                    <td>1.9.4</td>
                </tr>
                <tr>
                    <td><a href="http://www.bootstrap-switch.org" target="_blank">bootstrap-switch</a></td>
                    <td>3.3.2</td>
                </tr>
                <tr>
                    <td><a href="http://ckeditor.com/" target="_blank">CK Editor</a></td>
                    <td>4.7.2</td>
                </tr>
                <tr>
                    <td><a href="http://ace.c9.io/" target="_blank">Ace Editor</a></td>
                    <td>17.01.16</td>
                </tr>
                <tr>
                    <td><a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmLawed</a></td>
                    <td>1.2.4</td>
                </tr>
                <tr>
                    <td><a href="http://blueimp.github.io/jQuery-File-Upload/" target="_blank">jQuery File Upload</a></td>
                    <td>9.19.1</td>
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
                    <td>2.1.8</td>
                </tr>
                <tr>
                    <td><a href="https://tcpdf.org/" target="_blank">TCPDF</a> <span class="label label-default">LGPLv3</span></td>
                    <td>6.2.8</td>
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
        <div role="tabpanel" class="tab-pane" id="setup">
            <br>
            <p>Questa scheda permette di visualizzare i componenti e i servizi installati. Non sono incluse le
                interfaccie di amministrazione.</p>
            <h4><i class="fa fa-cubes"></i> Componenti installati</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Tipo dati</th>
                    <th>Origine</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($components as $component): ?>
                    <tr>
                        <td><i class="fa fa-cube"></i> <?= $component['name'] ?></td>
                        <td><?= $component['description'] ?></td>
                        <td><code><?= $component['save_type'] ?></code></td>
                        <td><?= $component['builtin'] ? '<i class="fa fa-cubes"></i> Integrato' : '<i class="fa fa-plug"></i> Componente aggiuntivo' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <h4><i class="fa fa-gears"></i> Servizi installati</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Origine</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><i class="fa <?= $service['icon'] ?>"></i> <?= $service['name'] ?></td>
                        <td><?= $service['label'] ?></td>
                        <td><?= $service['builtin'] ? '<i class="fa fa-cubes"></i> Integrato' : '<i class="fa fa-plug"></i> Componente aggiuntivo' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <h4><i class="fa fa-wrench"></i> Interfacce di configurazione installate</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Origine</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($config_interfaces as $config_interface): ?>
                    <tr>
                        <td><i class="fa <?= $config_interface['icon'] ?>"></i> <?= $config_interface['name'] ?></td>
                        <td><?= $config_interface['label'] ?></td>
                        <td><?= $config_interface['builtin'] ? '<i class="fa fa-cubes"></i> Integrato' : '<i class="fa fa-plug"></i> Componente aggiuntivo' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>