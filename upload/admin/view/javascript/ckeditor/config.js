/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.filebrowserBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashUploadUrl = 'index.php?route=common/filemanager';

	config.filebrowserWindowWidth = '850';
	config.filebrowserWindowHeight = '500';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;

	config.extraPlugins = 'codemirror';
	config.codemirror = {
		theme: 'default',
		mode: 'htmlmixed',
		lineNumbers: true,
		matchBrackets: true,
		highlightActiveLine: false,
		enableSearchTools: true,
		showSearchButton: true,
		showFormatButton: false,
		showCommentButton: false,
		showUncommentButton: false,
		showAutoCompleteButton: true,
		showTrailingSpace: true
	};
};
