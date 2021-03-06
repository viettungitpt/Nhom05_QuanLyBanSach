/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
// Define changes to default configuration here. For example:

	 var url_base_ckfinder = 'http://127.0.0.1/duongdung/admin/public/';

config.filebrowserBrowseUrl = url_base_ckfinder+'ckfinder/ckfinder.html';

config.filebrowserImageBrowseUrl = url_base_ckfinder+'ckfinder/ckfinder.html?type=Images';

config.filebrowserFlashBrowseUrl = url_base_ckfinder+'ckfinder/ckfinder.html?type=Flash';

config.filebrowserUploadUrl = url_base_ckfinder+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

config.filebrowserImageUploadUrl = url_base_ckfinder+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

config.filebrowserFlashUploadUrl = url_base_ckfinder+'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'links' },
		{ name: 'insert' },
		
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode'] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
