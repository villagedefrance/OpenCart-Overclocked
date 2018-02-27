/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.filebrowserWindowWidth = '640';
	config.filebrowserWindowHeight = '440';

	config.allowedContent = true;
	config.autoUpdateElement = false;
	config.htmlEncodeOutput = false;
	config.ignoreEmptyParagraph = true;
	config.linkJavaScriptLinksAllowed = true;
	config.resize_enabled = true;
	config.scayt_autoStartup = false;
	config.toolbarCanCollapse = true;
	config.toolbarStartupExpanded = true;

	config.extraAllowedContent = '*(*);*{*}';

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
