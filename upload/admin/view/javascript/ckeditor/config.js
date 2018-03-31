/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.filebrowserWindowWidth = '640';
	config.filebrowserWindowHeight = '440';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;

	config.allowedContent = true;
	config.htmlEncodeOutput = false;
	config.resize_enabled = true;
	config.scayt_autoStartup = false;
	config.toolbarCanCollapse = true;
	config.toolbarStartupExpanded = true;

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
