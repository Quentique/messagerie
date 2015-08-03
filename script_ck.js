var editor; 
CKEDITOR.replace('txt-aref');
CKEDITOR.on( 'instanceReady', function( ev ) { 
editor = ev.editor; 
editor.setReadOnly(false);
}
);