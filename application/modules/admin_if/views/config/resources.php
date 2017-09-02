<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Risorse esterne (Content Delivery Networks)</h3>
    </div>
    <div class="panel-body">
        <p>Le Content Delivery Networks permettono di rendere il caricamento delle pagine più veloce per gli utenti del sito caricando alcune risorse da siti di terze parti.
            Nel caso il CDN indicato non sia raggiungibile a causa di problemi momentanei il sito ricorrerà automaticamente a copie locali (tranne per Font Awesome).</p>
        <p>Si consiglia di attivare il supporto al CDN e di indicare un CDN affidabile e popolare come ad esempio i <a href="https://developers.google.com/speed/libraries/" target="_blank">CDN di Google</a> e <a href="https://www.bootstrapcdn.com/" target="_blank">BootstrapCDN</a></p>
        <h4>jQuery</h4>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-jquery1-usecdn" <?= $jquery1_usecdn ? 'checked' : '' ?>> &nbsp;Usa un CDN per jQuery
                    1.x (utilizzato solo se la modalità di compatibilità è attiva)
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-jquery1-cdnurl">URL per jQuery 1.x:</label>
            <input type="text" class="form-control cdn-reqssl-url" id="i-jquery1-cdnurl" placeholder="Inserire l'URL per jQuery 1.x" value="<?=$jquery1_cdnurl ?>">
                    <span class="form-control-feedback tooltipped" data-toggle="tooltip" title="">
                        <i class="fa fa-lg"></i>
                    </span>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-jquery2-usecdn" <?= $jquery2_usecdn ? 'checked' : '' ?>> &nbsp;Usa un CDN per jQuery
                    2.x
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-jquery2-cdnurl">URL per jQuery 2.x:</label>
            <input type="text" class="form-control cdn-reqssl-url" id="i-jquery2-cdnurl" placeholder="Inserire l'URL per jQuery 2.x" value="<?=$jquery2_cdnurl ?>">
                    <span class="form-control-feedback tooltipped" data-toggle="tooltip" title="">
                        <i class="fa fa-lg"></i>
                    </span>
        </div>
        <h4>Bootstrap (JavaScript)</h4>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-bootstrap-usecdn" <?= $bootstrap_js_usecdn ? 'checked' : '' ?>> &nbsp;Usa un CDN per il
                    codice JavaScript di Bootstrap
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-bootstrap-cdnurl">URL per Bootstrap (JavaScript):</label>
            <input type="text" class="form-control cdn-reqssl-url" id="i-bootstrap-cdnurl" placeholder="Inserire l'URL per Bootstrap (JavaScript)" value="<?=$bootstrap_js_cdnurl ?>">
			<span class="form-control-feedback tooltipped" data-toggle="tooltip" title="">
				<i class="fa fa-lg"></i>
			</span>
        </div>
        <h4>Font Awesome</h4>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-fontawesome-usecdn" <?= $fontawesome_usecdn ? 'checked' : '' ?>> &nbsp;Usa un CDN per
                    Font Awesome
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-fontawesome-cdnurl">URL per Font Awesome:</label>
            <input type="text" class="form-control cdn-reqssl-url" id="i-fontawesome-cdnurl" placeholder="Inserire l'URL per Font Awesome" value="<?=$fontawesome_cdnurl ?>">
			<span class="form-control-feedback tooltipped" data-toggle="tooltip" title="">
				<i class="fa fa-lg"></i>
			</span>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Modalità di compatibilità</h3>
    </div>
    <div class="panel-body">
        <p>La modalità di compatibilità permette di visualizzare il sito utilizzando browser obsoleti (Internet Explorer 8 e Firefox 3.6). Questa modalità deve essere attivata solo
            quando si ha la necessità esplicita di supportare browser obsoleti in quanto rallenta il caricamento delle
            pagine per tutti gli utenti. In caso si prova ad accedere al sito
            con un browser non supportato verrà visualizzato un invito ad aggiornare il browser.
            <br>La modalità di compatibilità si basa su <code>Respond.js</code> e <code>html5shiv</code>.
        </p>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-enable-legacy-support" <?= $enable_legacy_support ? 'checked' : '' ?>> &nbsp;Abilita la
                    modalità di compatibilità (renderà il sito più lento per tutti gli utenti)
                </label>
            </div>
        </div>
    </div>
</div>