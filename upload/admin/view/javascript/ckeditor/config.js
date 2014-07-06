/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	// Default Values.
	config.smiley_images = [
	'1.gif','2.gif','3.gif','4.gif','5.gif','6.gif','7.gif','8.gif','9.gif','10.gif',
	'11.gif','12.gif','13.gif','14.gif','15.gif','16.gif','17.gif','18.gif','19.gif','20.gif',
	'21.gif','22.gif','23.gif','24.gif','25.gif','26.gif','27.gif','28.gif','29.gif','30.gif',
	'31.gif','32.gif','33.gif','34.gif','35.gif','36.gif','37.gif','38.gif','39.gif','40.gif',
	'41.gif','42.gif','43.gif','44.gif','45.gif','46.gif','47.gif','48.gif','49.gif','50.gif',
	'51.gif','52.gif','53.gif','54.gif','55.gif','56.gif','57.gif','58.gif','59.gif','60.gif',
	'61.gif','62.gif','63.gif','64.gif','65.gif','66.gif','67.gif','68.gif','69.gif','70.gif',
	'71.gif','72.gif','73.gif','74.gif','75.gif','76.gif','77.gif'];

	config.filebrowserBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashBrowseUrl = 'index.php?route=common/filemanager';
	config.filebrowserUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserImageUploadUrl = 'index.php?route=common/filemanager';
	config.filebrowserFlashUploadUrl = 'index.php?route=common/filemanager';

	config.filebrowserWindowWidth = '800';
	config.filebrowserWindowHeight = '500';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;

	config.resize_enabled = true;
	config.htmlEncodeOutput = false;
	config.entities = false;

	config.extraPlugins = 'codemirror';
	config.codemirror_theme = 'rubyblue';

	config.skin = 'moono';
};