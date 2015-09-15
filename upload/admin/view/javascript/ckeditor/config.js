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

	config.filebrowserWindowWidth = '800';
	config.filebrowserWindowHeight = '480';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;

	config.htmlEncodeOutput = false;
	config.resize_enabled = true;
	config.allowedContent = true;

	config.extraPlugins = 'simplebutton';
	config.extraPlugins = 'codemirror';
	config.codemirror = {
		theme: 'vibrant-ink',
		mode: 'htmlmixed',
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: true,
		autoCloseBrackets: false,
		autoCloseTags: false,
		highlightMatches: true,
		enableSearchTools: true,
		showSearchButton: true,
		showFormatButton: false,
		showCommentButton: false,
		showUncommentButton: false,
		showAutoCompleteButton: true,
		showTrailingSpace: true
	};
};
