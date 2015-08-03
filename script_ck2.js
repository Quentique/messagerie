			CKEDITOR.replace('test2'); 
			var editor;

			CKEDITOR.on( 'instanceReady', function( ev ) {
			editor = ev.editor;
			editor.setReadOnly(true);

		});