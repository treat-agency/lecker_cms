/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for a single toolbar row.
	config.toolbarGroups = [
		{ name: 'document'},
		{ name: 'clipboard'},
		{ name: 'editing'},
		{ name: 'forms' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph'},
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' },
		{ name: 'about' }
	];

	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Strike,About,Anchor,Font,FontSize,NumberedList,BulletedList,Outdent,Indent';

	// Dialog windows are also simplified.
	config.removeDialogTabs = 'link:advanced';
	
	//config.extraPlugins = 'footnote';
	config.uploadUrl = rootUrl+'/items/uploads/images/';
	config.removePlugins = 'link';
	config.extraPlugins = 'adv_link';
	config.allowedContent = true;
	config.timestamp = "1abcd12";
};
