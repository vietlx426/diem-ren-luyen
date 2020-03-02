/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,RemoveFormat,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Maximize,ShowBlocks,About';
	
	config.uiColor = '#E4E4E4';
	// '#A1CFF3'
	var protocol = location.protocol;
	var slashes = protocol.concat("//");
	var host = slashes.concat(window.location.hostname).concat("/diemrenluyen/");
	config.enterMode = CKEDITOR.ENTER_BR;
	// alert(host);
	// Configuration for CKFinder.
	config.filebrowserBrowseUrl = host.concat("public/js/ckfinder/ckfinder.html");
	config.filebrowserImageBrowseUrl = host.concat("public/js/ckfinder/ckfinder.html?type=Images");
	// config.filebrowserFlashBrowseUrl = host.concat("js/ckfinder/ckfinder.html?type=Flash");
	config.filebrowserUploadUrl = host.concat("js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files");
	config.filebrowserImageUploadUrl = host.concat("js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images");
	// config.filebrowserFlashUploadUrl = host.concat("js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash");
};
