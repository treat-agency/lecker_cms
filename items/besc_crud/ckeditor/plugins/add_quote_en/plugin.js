CKEDITOR.plugins.add( 'add_quote_en', {

    init: function( editor ) {
        
		editor.addCommand( 'addQuoteEN', {
		    exec: function( editor ) {
		        
		    	var elem = '&ldquo;' + editor.getSelection().getSelectedText() + '&rdquo;';	
		        editor.insertHtml(elem);
		        
		    }
		});
		
		
		editor.ui.addButton( 'addQuoteEN', {
		    label: 'Insert Quote EN',
		    command: 'addQuoteEN',
		    toolbar: 'insert',
		    icon: this.path + 'icons/icon.png'
		});
    }
});