CKEDITOR.plugins.add( 'add_quote', {
    init: function( editor ) {
        
		editor.addCommand( 'addQuote', {
		    exec: function( editor ) {
		        
		    	var elem = '„' + editor.getSelection().getSelectedText() + '”';	
		        editor.insertHtml(elem);
		        
		    }
		});
		
		
		editor.ui.addButton( 'Footnote', {
		    label: 'Insert Quote',
		    command: 'addQuote',
		    toolbar: 'insert',
		    icon: this.path + 'icons/icon.png'
		});
    }
});