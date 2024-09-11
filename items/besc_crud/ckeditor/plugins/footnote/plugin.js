CKEDITOR.plugins.add( 'footnote', {
    icons: 'footnote',
    init: function( editor ) {
        
		editor.addCommand( 'addFootnote', {
		    exec: function( editor ) {
		        var current = $('#footnote_container').find('.footnote_item').length;   
		    	var new_number = current+1;
		    		
		        editor.insertHtml( '<a id="footnote-'+new_number+'-ref" href="#footnote-'+new_number+'">['+new_number+']</a>' );
		        
		        
		        
		        var elem = '<div class="footnote_item" number="'+new_number+'"><div class="footnote_number">['+new_number+']</div><textarea class="footnote_text"></textarea><div class="footnote_delete">X</div></div>';
		        $('#footnote_container').append(elem);
		        
		        
		        $('.footnote_delete').unbind('click');
		        
		        $('.footnote_delete').click(function(){
			        var number = $(this).parent().attr('number');
					$(this).parent().remove();
		        });
		    }
		});
		
		
		editor.ui.addButton( 'Footnote', {
		    label: 'Insert Footnote',
		    command: 'addFootnote',
		    toolbar: 'insert'
		});
    }
});