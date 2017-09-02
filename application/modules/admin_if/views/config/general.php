<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="form-group">
    <label for="i-website-name">Titolo del sito:</label>
    <input type="text" class="form-control" id="i-website-name" placeholder="Inserire il titolo del sito" value="<?=$website_name ?>">
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Aspetto e comportamento</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <span class="hidden" id="c-menu-class"><?=$menu_class ?></span>
            <label for="i-menu-class">Stile del menu principale:</label>
            <select class="form-control selectpicker" id="i-menu-class">
                <option value="default">Stile bootstrap standard (bianco)</option>
                <option value="inverse">Stile bootstrap invertito (nero)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="i-logo-image-path">Immagine logo del sito:</label>
            <input type="text" class="form-control" id="i-logo-image-path" placeholder="Inserire il percorso"
                   value="<?= $logo_image_path ?>">
            <span class="help-block">Inserire il percorso (relativo alla base del sito) dell'immagine da utilizzare come logo del sito (generalmente situata in <code>img/...</code>)</span>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-use-fluid-containers" <?= $use_fluid_containers ? 'checked' : '' ?>> &nbsp;Abilita
                    layout fluido (il contenuto riempie lo schermo senza margini, sconsigliato)
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-display-home-page-title" <?= $display_home_page_title ? 'checked' : '' ?>> &nbsp;Mostra
                    il titolo per la pagina iniziale (sconsigliato)
                </label>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Supporto scrittura equazioni</h3>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<div class="checkbox toggle">
				<label>
					<input type="checkbox" class="checkbox-sw"
						   id="i-enable-math-support" <?= $enable_math_support ? 'checked' : '' ?>> &nbsp;Abilita
					il supporto per la visualizzazione di equazioni matematiche
				</label>
			</div>
			<span class="help-block">Questo servizio è necessario per visualizzare equazioni nelle pagine tramite MathJax. Se si disabilita il servizio e sono presenti equazioni su sito queste non saranno visualizzate correttamente</span>
		</div>
		<p>La visualizzazione di equazioni avviene tramite <a href="https://www.mathjax.org/" target="_blank">MathJax</a>.
			Si consiglia di utilizzare il CDN di MathJax per ottenere migliori prestazioni. In alternativa è possibile installare una copia locale</p>
		<div class="radio">
			<label>
				<input type="radio" name="mathjax-source-radio" id="mathjax-source-cdn" value="mathjax-source-cdn" <?=$mathjax_usecdn ? 'checked' : '' ?>>
				Utilizza un CDN per MathJax
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="mathjax-source-radio" id="mathjax-source-local" value="mathjax-source-local" <?=$mathjax_usecdn ? '' : 'checked' ?>>
				Utilizza una copia locale per MathJax (dovrà essere installata manualmente)
			</label>
		</div>
		<div class="form-group">
			<label for="i-mathjax-cdnurl">URL del CDN di MathJax:</label>
			<input type="text" class="form-control cdn-reqssl-url" id="i-mathjax-cdnurl" placeholder="Inserire l'URL per Font Awesome" value="<?=$mathjax_cdnurl ?>">
			<span class="form-control-feedback tooltipped" data-toggle="tooltip" title="">
				<i class="fa fa-lg"></i>
			</span>
		</div>
	</div>
</div>