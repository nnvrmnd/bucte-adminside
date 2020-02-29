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

	config.removeButtons = 'Styles,Format,Font,FontSize,TextColor,BGColor,ShowBlocks,Image,Flash,Table,HorizontalRule,Smiley,PageBreak,Iframe,SpecialChar,Link,Unlink,Language,BidiRtl,BidiLtr,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,CreateDiv,Outdent,Indent,CopyFormatting,RemoveFormat,Strike,Subscript,Superscript,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Checkbox,Scayt,Find,Replace,Redo,Undo,Cut,Copy,Paste,PasteText,Templates,Save,NewPage,Preview,Print,Anchor,Italic,PasteFromWord';

	config.extraPlugins = 'autogrow, confighelper';
};