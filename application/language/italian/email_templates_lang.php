<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_templates_password_reset'] = "
    <html>
    <head>
        <meta charset=\"utf-8\">
    </head>
        <body>
            <h3>Richiesta modifica password per [[website]]</h3>
            <p>E' stata richiesta la modifica della password sul sito [[website]]. Per resettare la password premere
            sul link seguente. La richiesta scadrà tra 24 ore</p>
            <p><b>Se non si ha richiesto il reset della password informare immediatamente l'amministratore del sistema</b></p>
            <p><a href=\"[[url]]\" target=\"_blank\">[[url]]</a></p>
        </body>
    </html>";
$lang['email_templates_new_user_set_password'] = "
    <html>
    <head>
        <meta charset=\"utf-8\">
    </head>
        <body>
            <h3>Registrazione al sito [[website]]</h3>
            <p>Per completare la registrazione dell'account [[user]] è necessario scegliere una password prem,endo sul link seguente. 
            Questa richiesta scadrà tra 24 ore</p>
            <p><b>Se non si ha richiesto la registrazione al sito informare immediatamente l'amministratore del sistema</b></p>
            <p><a href=\"[[url]]\" target=\"_blank\">[[url]]</a></p>
        </body>
    </html>";
