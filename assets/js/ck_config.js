CKEDITOR.editorConfig = function( config ) {
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

	config.removeButtons = 'ShowBlocks,BGColor,TextColor,Styles,Font,FontSize,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Link,Unlink,Anchor,BidiLtr,BidiRtl,Language,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,CreateDiv,Indent,Outdent,CopyFormatting,RemoveFormat,Italic,Strike,Subscript,Superscript,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Scayt,SelectAll,Find,Replace,Undo,Redo,Cut,Copy,Paste,PasteText,PasteFromWord,Templates,Save,NewPage,Preview,Print';

	config.extraPlugins = 'autogrow, confighelper';
};