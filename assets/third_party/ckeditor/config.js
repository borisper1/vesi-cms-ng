/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		{ name: 'about' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{name: 'colors'}
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Anchor';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre;address';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced;';

	config.entities = false; //disabled all entities to prevent ' form being converted to HTML entities, UTF8 support.
	config.entities_latin = false; //required if entities enabled to pass internal HTML validation
	config.justifyClasses = [ 'text-left', 'text-center', 'text-right', 'text-justify' ];
	//config.allowedContent = true; //Disables all content filtering, not recommended only emergency fix
	config.extraPlugins = 'fontawesome,confighelper';
	config.extraAllowedContent = 'span(fa,fa-*)';
	//config.disallowedContent = 'img{width,height};';

    config.removeDialogFields='table:info:txtBorder;table:info:txtCellSpace;table:info:txtCellPad;table:info:txtHeight;table:info:txtCaption;table:info:txtSummary;table:advanced:advLangDir;table:info:cmbAlign;'+
        'tableProperties:info:txtBorder;tableProperties:info:txtCellSpace;tableProperties:info:txtCellPad;tableProperties:info:txtHeight;tableProperties:info:txtCaption;tableProperties:info:txtSummary;tableProperties:advanced:advLangDir;tableProperties:info:cmbAlign;'+
        'image:info:txtBorder;image:info:txtHSpace;image:info:txtVSpace;image:info:cmbAlign;'+
        'cellProperties:info:bgColor;cellProperties:info:borderColor;cellProperties:info:wordWrap;cellProperties:info:hAlign;cellProperties:info:vAlign;cellProperties:info:width;cellProperties:info:height;cellProperties:info:widthType;';

    config.dialogFieldsDefaultValues =
    {
        table:
        {
            info: {
                txtWidth: ''
            },
            advanced: {
                advCSSClasses: 'table'
            }
        }
    };

	config.image_prefillDimensions = false;
	config.filebrowserBrowseUrl = window.vbcknd.base_url + 'services/file_browser/index/';
	config.filebrowserWindowWidth = '640';
	config.filebrowserWindowHeight = '480';
};
