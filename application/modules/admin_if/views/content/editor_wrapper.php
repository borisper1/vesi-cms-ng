<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header">
    <h1><i class="fa fa-cubes"></i> Gestione contenuti
        <button type="button" class="btn btn-default pull-right launch-contextual-help tooltipped" title="Aiuto"
                data-help_path="contents::editors::<?= $type ?>"><i class="fa fa-question-circle"></i></button>
    </h1>
</div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-preview"><?=$preview ?></span>
	<i class="fa fa-lock tooltipped <?= $restricted_access ? '' : 'hidden' ?>" id="restricted-access-icon" title="Accesso ristretto"></i>
    <small><span class="label label-info"><span id="f-type"><?=$type ?></span> <i class="fa fa-ellipsis-v"></i> <span id="f-id"><?=$id ?></span></span></small>
</h3>
<div class="btn-group pull-right" id="content-actions">
    <button type="button" class="btn btn-default" id="save-content"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica codice</button>
	<?php if($enable_permission_control): ?>
	<button type="button" class="btn btn-default" id="edit-permissions"><i class="fa fa-lock"></i> Restringi accesso</button>
	<?php endif; ?>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>
<br>

<div class="alert alert-danger hidden alert-save" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile
        salvare il contenuto:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden alert-save" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Contenuto salvato con successo.
</div>
<div class="alert alert-info hidden alert-save" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio del
    contenuto...
</div>

<div class="modal fade" id="edit-permissions-modal" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-lock"></i> Restringi accesso</h4>
			</div>
			<div class="modal-body">
				<div class="btn-group spaced" data-toggle="buttons">
					<label class="btn btn-default <?= $restricted_access ? '' : 'active' ?>">
						<input type="radio" name="permissions-limiting-mode"
							   id="permissions-no-restrict" <?= $restricted_access ? '' : 'checked' ?>> <i
								class="fa fa-unlock"></i> Non restringere questo contenuto
					</label>
					<label class="btn btn-default <?= $restricted_access ? 'active' : '' ?>">
						<input type="radio" name="permissions-limiting-mode"
							   id="permissions-restrict" <?= $restricted_access ? 'checked' : '' ?>> <i
								class="fa fa-lock"></i> Restringi contenuto
					</label>
				</div>
				<div class="form-group">
					<label class="control-label" for="i-allowed-groups">Scegliere i gruppi a cui restringere l'accesso al contenuto</label>
					<select class="selectpicker form-control" id="i-allowed-groups"
							multiple <?= $restricted_access ? '' : 'disabled' ?>>
						<?php foreach($frontend_groups as $group): ?>
							<option value="<?= $group['name'] ?>" <?= in_array($group['name'], $allowed_groups) ? 'selected' : '' ?>>
								<?= $group['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<span class="help-block">Scegliere come verranno applicate le restrizioni:</span>
					<div class="radio">
						<label>
							<input type="radio" name="permessions-warning-mode" id="permissions-standardwarn"  <?= $restriction_mode === 'standard' ? 'checked' : '' ?> <?= $restricted_access ? '' : 'disabled' ?>>
							Mostra un avviso se non si dispone i privilegi per visualizzare il contenuto
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="permessions-warning-mode" id="permissions-nowarn" <?= $restriction_mode === 'silent' ? 'checked' : '' ?> <?= $restricted_access ? '' : 'disabled' ?>>
							Non mostrare avvisi (il contenuto viene semplicemente ignorato durante il caricamento della pagina)
						</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> OK
				</button>
			</div>
		</div>
	</div>
</div>
