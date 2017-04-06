CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'selection', 'find', 'spellchecker', 'editing' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		'/',
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Templates,Find,Form,RemoveFormat,Maximize,About,Blockquote,BidiLtr,Print,Replace,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Format,Images,Anchor,ShowBlocks,Language,BidiRtl,CreateDiv,Indent,Outdent,Strike,Subscript,Superscript,Scayt,PasteFromWord,PasteText,Undo,Redo,Styles,Preview,Save';
	
	config.height = 75;
};