<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><span id="editor-name" class="hidden">html-field</span>
<style type='text/css' media='screen'>#code_editor {height:500px;}</style>

<pre id="code_editor"><?=$content ?></pre>

<div class="alert alert-info" role="alert">
    <p><i class="fa fa-shield fa-lg"></i> Il codice HTML inserito viene filtrato per prevenire probelmi di sicurezza (XSS). Elementi non consentiti
        <code>&lt;applet&gt;</code>, <code>&lt;embed&gt;</code>, <code>&lt;object&gt;</code>, <code>&lt;audio&gt;</code>, <code>&lt;video&gt;</code>, <code>&lt;canvas&gt;</code> e <code>&lt;script&gt;</code>,
        per inserire JavaScrpt utilizzare i controlli sotto; attributi non consentiti: <code>on*</code> e alcune direttive in <code>style</code></p>
</div>
<h4>Opzioni JavaScript</h4>
<div class='checkbox'>
    <label>
        <input type='checkbox' id='jsenable' <?=$js_enabled ? 'checked' : '' ?>>
        Abilita il supporto a JavaScript personalizzato per questa pagina
    </label>
</div>
<div id="auxiliary-js-field" class="well <?=$js_enabled ? '' : 'hidden' ?>">
    <div class="form-group">
        <label for="addjs">Inserire i file JS da aggiungere alla pagina separandoli con una <kbd>,</kbd></label>
        <input type="text" class="form-control" id="addjs" placeholder="File JavaScript" value="<?=$js_string ?>">
    </div>
    <p> I file devono essere situati in <code>assets/</code>. Indicarne il percorso relativo alla cartella assets (es. <code>folder/file.js</code>)</p>
</div> 