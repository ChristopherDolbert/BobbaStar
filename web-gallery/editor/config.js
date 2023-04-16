/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	config.scayt_autoStartup = false;
	config.language = 'fr';
	config.skin = 'moono';
	config.stylesSet = 'style_journalisme';
	config.format_tags = 'div';
	config.enterMode = CKEDITOR.ENTER_DIV;
	config.removePlugins = 'magicline';
	config.toolbar_Journalisme =
	[
		{ name: 'document', items : [ 'Source' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Iframe' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
	];
	config.toolbar_Newsletter =
	[
		{ name: 'document', items : [ 'Source' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert', items : [ 'Image','Table','HorizontalRule' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
		{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','FontSize' ] }
	];
	config.toolbar_Articles =
	[
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','Subscript','Superscript' ] },
		{ name: 'colors', items : [ 'TextColor'] }
	];
	config.toolbar_Recrutements =
	[
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','Subscript','Superscript' ] },
		{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
	];
	config.toolbar_NotedeService =
	[
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert', items : [ 'Image','Table','HorizontalRule'] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','Subscript','Superscript' ] },
		'/',
		{ name: 'paragraph', items : [ 'NumberedList','Outdent','Indent','-','Blockquote',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'styles', items : [ 'Styles'] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
	];
	config.toolbar_Forum =
	[
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker'] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Iframe' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
	];
	config.toolbar_Commentaireforum =
	[
		{ name: 'clipboard', items : [ 'Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll'] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
		{ name: 'paragraph', items : [ 'Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'styles', items : [ 'Styles'] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
	];
};
CKEDITOR.stylesSet.add( 'style_journalisme',
[
    { name : 'Normal', element : 'div' },
    { name : 'Source', element : 'div', styles : { 'color' : '#5b5b5b', 'text-align' : 'right', 'font-style' : 'italic' } },
    { name : 'Codes', element : 'div', styles : { 'padding' : '7px', 'border' : '1px solid #5f5f5f', 'background-color' : '#d0d0d0', 'max-height' : '400px', 'overflow-y' : 'auto' } }
]);