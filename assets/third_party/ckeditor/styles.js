/**
 * Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the "stylescombo" plugin which shows the Styles drop-down
// list containing all styles in the editor toolbar. Other plugins, like
// the "div" plugin, use a subset of the styles for their features.
//
// If you do not have plugins that depend on this file in your editor build, you can simply
// ignore it. Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.
//
// For more information refer to: http://docs.ckeditor.com/#!/guide/dev_styles-section-style-rules

CKEDITOR.stylesSet.add( 'default', [
	/* Inline Styles */
	{ name: 'Small',			element: 'small' },
	{ name: 'Typewriter',		element: 'tt' },

	{ name: 'Computer Code',	element: 'code' },
	{ name: 'Keyboard Phrase',	element: 'kbd' },

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
	},

	/* Widget styles */
	{ name: 'Clean Image', type: 'widget', widget: 'image', attributes: { 'class': 'image-clean' } },
	{ name: 'Grayscale Image', type: 'widget', widget: 'image', attributes: { 'class': 'image-grayscale' } },

	{ name: 'Featured Snippet', type: 'widget', widget: 'codeSnippet', attributes: { 'class': 'code-featured' } },

	{ name: 'Featured Formula', type: 'widget', widget: 'mathjax', attributes: { 'class': 'math-featured' } },

] );

