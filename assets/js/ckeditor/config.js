/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */


//csslocation = site_url + '/assets/css/import/ckEditor.css';

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
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
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	config.width = '100%';
	config.removePlugins = 'elementspath';
	config.resize_enabled = false;

	config.format_tags = 'p;h2;h3';
	config.stylesSet = 'my_styles';

	config.toolbarCanCollapse = false;

	//config.contentsCss = csslocation;

};


CKEDITOR.stylesSet.add( 'my_styles',
[
    // Block-level styles
    { name : 'Main heading', element : 'h2' },
    { name : 'Sub heading' , element : 'h3' },
    { name : 'Paragraph' , element : 'p' },
 
    // Inline styles
    { name : 'Pull-Left', element : 'p', attributes : { 'class' : 'pull pull-left' } },
    { name : 'Pull-Right', element : 'p', attributes : { 'class' : 'pull pull-right' } },
    { name : 'Image: Pull Left', element : 'img', attributes : { 'class' : 'pull pull-left' } },
    { name : 'Image: Pull Right', element : 'img', attributes : { 'class' : 'pull pull-right' } },
    { name : 'Image: Centre', element : 'img', attributes : { 'class' : 'img-centre' } }
]);
