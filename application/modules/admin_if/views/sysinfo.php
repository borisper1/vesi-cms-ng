<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-info-circle"></i> Informazioni sul sistema</h1></div>
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Generale</a></li>
        <li role="presentation"><a href="#php" aria-controls="php" role="tab" data-toggle="tab">Interprete PHP</a></li>
        <li role="presentation"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">Informazioni su</a></li>
    </ul>


    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <br>
            <table class="table table-striped">
                <thead><tr>
                    <th>Impostazione</th>
                    <th>Valore</th>
                </tr></thead>
                <tr>
                    <th>Server:</th>
                    <td><?=$_SERVER["SERVER_NAME"]?></td>
                </tr>
                <tr>
                    <th>Server web:</th>
                    <td><?=$_SERVER["SERVER_SOFTWARE"]?></td>
                </tr>
                <tr>
                    <th>User agent:</th>
                    <td><?=$_SERVER["HTTP_USER_AGENT"]?></td>
                </tr>
                <tr>
                    <th>PHP version:</th>
                    <td><?=phpversion()?></td>
                </tr>
                <tr>
                    <th>Vesi-CMS version:</th>
                    <td>1.2.0-dev (NOT FOR RELEASE)</td>
                </tr>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="php">
            <br>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="<?=base_url('assets/administration/phpinfo.php?key=3133F459B4F31EAC959BD488A64A5') ?>"></iframe>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="about">
            <h3>Vesi CMS 1.2 <small>(vesi-cms-ng)</small></h3>
            <p>Sviluppato da Boris Pertot - Copyright <span class='fa fa-copyright'></span> 2016 Boris Pertot</p>
            <p class="text-muted">This program is free software; you can redistribute it and/or modify
                it under the terms of the GNU General Public License as published by
                the Free Software Foundation; either version 2 of the License, or
                (at your option) any later version.<br>

                This program is distributed in the hope that it will be useful,
                but WITHOUT ANY WARRANTY; without even the implied warranty of
                MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
                GNU General Public License for more details.</p>
            <p>Questo programma usa:</p>
            <table class="table table-striped">
                <thead><tr>
                    <th>Programma</th>
                    <th>Sviluppatore</th>
                    <th>Uso</th>
                </tr></thead>
                <tr>
                    <td><a href="http://php.net" target="_blank">PHP</a></td>
                    <td><a href="http://php.net/credits.php" target="_blank">PHP Group</a></td>
                    <td></td>
                </tr>
                <tr>
                    <td><a href="http://jquery.com/" target="_blank">jQuery, jQuery Ui</a></td>
                    <td><a href="https://jquery.org/team/" target="_blank">jQuery Foundation</a></td>
                    <td></td>
                </tr>
                <tr>
                    <td><a href="http://getbootstrap.com/" target="_blank">Bootstrap</a></td>
                    <td><a href="https://github.com/orgs/twbs/people" target="_blank">@mdo, @fat, Bootstrap team</a></td>
                    <td>Framework interfaccia utente</td>
                </tr>
                <tr>
                    <td><a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a></td>
                    <td><a href="https://twitter.com/davegandy" target="_blank">Dave Gandy</a></td>
                    <td>Icone interfaccia utente</td>
                </tr>
                <tr>
                    <td><a href="https://github.com/CWSpear/bootstrap-hover-dropdown/" target="_blank">Bootstrap Hover Dropdown Plugin</a></td>
                    <td><a href="https://twitter.com/CWSpear" target="_blank">Cameron W Spear</a></td>
                    <td>Bootstrap dropdown su hover</td>
                </tr>

                <tr>
                    <td><a href="https://code.google.com/p/html5shiv/" target="_blank">html5shiv</a></td>
                    <td>@jon_neal, afarkas</td>
                    <td>Compatibilità con IE8</td>
                </tr>
                <tr>
                    <td><a href="https://github.com/scottjehl/Respond" target="_blank">Respond.js</a></td>
                    <td><a href="http://scottjehl.com/" target="_blank">Scott Jehl</a></td>
                    <td>Compatibilità con IE8</td>
                </tr>
                <tr>
                    <td><a href="http://ace.c9.io/" target="_blank">Ace</a></td>
                    <td><a href="https://github.com/ajaxorg/ace" target="_blank">Ajax.org / Mozilla</a></td>
                    <td>Web-based code editor</td>
                </tr>
                <tr>
                    <td><a href="http://ckeditor.com/" target="_blank">CK Editor</a></td>
                    <td><a href="http://ckeditor.com/" target="_blank">Frederico Knabben</a></td>
                    <td>HTML WYSIWYG Editor</td>
                </tr>
                <tr>
                    <td><a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/" target="_blank">htmLawed</a></td>
                    <td><a href="http://www.bioinformatics.org/phplabware/internal_utilities/index.php" target="_blank">PHP Labware</a></td>
                    <td>HTML input filter, XSS filter</td>
                </tr>
                <tr>
                    <td><a href="http://blueimp.github.io/jQuery-File-Upload/" target="_blank">jQuery File Upload</a></td>
                    <td><a href="https://blueimp.net/" target="_blank">Sebastian Tschan</a></td>
                    <td>Plugin per l'upload di file con AJAX</td>
                </tr>
                <tr>
                    <td><a href="http://anthonyterrien.com/knob/" target="_blank">jQuery Knob</a></td>
                    <td><a href="https://github.com/aterrien/jQuery-Knob" target="_blank">Anthony Terrien</a></td>
                    <td>Interfaccia widget knob per jQuery Ui</td>
                </tr>
                <tr>
                    <td><a href="http://anthonyterrien.com/knob/" target="_blank">bootstrap-select</a></td>
                    <td><a href="https://github.com/silviomoreto" target="_blank">Silvio Moreto</a>,
                        <a href="https://github.com/anacarolinats" target="_blank">Ana Carolina</a>,
                        <a href="https://github.com/caseyjhol" target="_blank">caseyjhol</a>,
                        <a href="https://github.com/mattbryson" target="_blank">Matt Bryson</a>, and
                        <a href="https://github.com/t0xicCode" target="_blank">t0xicCode</a>.</td>
                    <td>Interfaccia <code>select</code> per Bootstrap</td>
                </tr>
                <tr>
                    <td><a href="http://anthonyterrien.com/knob/" target="_blank">Bootstrap Switch</a></td>
                    <td><a href="https://github.com/nostalgiaz" target="_blank">Mattia Larentis</a> e <a href="https://github.com/lostcrew" target="_blank">Emanuele Marchi</a></td>
                    <td>Interfaccia checkbox con toggle switch per Bootstrap</td>
                </tr>
            </table>
        </div>
    </div>
</div>