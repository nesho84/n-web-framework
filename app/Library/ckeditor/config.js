/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.removePlugins = 'save,newpage,flash,about,exportpdf,iframe,language,easyimage';

	// Allowing bootstrap claasses and Icons
	config.allowedContent = true;
	config.protectedSource.push(/<i class[\s\S]*?\>/g);
	// php tags
	// config.protectedSource.push(/<\?[\s\S]*?\?>/g);
	config.protectedSource.push(/<\/i>/g);
	// <?php> tags.

	// config.toolbar = [
	// 	{ name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', '-', 'Find', 'Replace', '-', 'ShowBlocks', 'SelectAll', '-', 'Scayt'] },
	// 	{ name: 'tools', items: ['Source', '-', 'Maximize', '-', 'About'] },
	// 	'/',
	// 	{ name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe', 'CreateDiv', '-', 'Link', 'Unlink', 'Anchor'] },
	// 	{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
	// 	'/',
	// 	{ name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] }
	// ];
};