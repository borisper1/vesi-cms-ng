<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_templates_password_reset'] = "
    <html>
        <body>
            <h3>Richiesta reset password [[website]]</h3>
            <p>E' stato richiesto il reset della password sul sito [[website]]. Per resettare la password premere
            sul link seguente</p>
            <p><b>Se non si ha richiesto il reset della password informare immediatamente l'amministratore del sistema</b></p>
            <p><a href=\"[[url]]\" target=\"_blank\">[[url]]</a></p>
        </body>
    </html>";
