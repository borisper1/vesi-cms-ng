/**
 * Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the "stylescombo" plugin, which shows a combo
// in the editor toolbar, containing all styles. Other plugins instead, like
// the div plugin, use a subset of the styles on their feature.
//
// If you don't have plugins that depend on this file, you can simply ignore it.
// Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.

CKEDITOR.stylesSet.add( 'default', [
	/* Inline Styles */


	{ name: 'Big',				element: 'big' },
	{ name: 'Small',			element: 'small' },
	{ name: 'Typewriter',		element: 'tt' },

	{ name: 'Computer Code',	element: 'code' },
	{ name: 'Keyboard Phrase',	element: 'kbd' },
	{ name: 'Sample Text',		element: 'samp' },
	{ name: 'Variable',			element: 'var' },

	{ name: 'Deleted Text',		element: 'del' },
	{ name: 'Inserted Text',	element: 'ins' },

	{ name: 'Cited Work',		element: 'cite' },
	{ name: 'Inline Quotation',	element: 'q' },

	/* Object Styles */

	{
		name: 'Standard table',
		element: 'table',
		attributes: { 'class': 'table' }
	},
	{
		name: 'Bordered table',
		element: 'table',
		attributes: { 'class': 'table table-bordered' }
	},
    {
        name: 'Striped table',
        element: 'table',
        attributes: { 'class': 'table table-striped' }
    },
    {
        name: 'Striped bordered table',
        element: 'table',
        attributes: { 'class': 'table table-bordered table-striped' }
    },

	{ 
		name: 'Square Bulleted List',	
		element: 'ul',		
		styles: { 'list-style-type': 'square' } 
	}
] );

