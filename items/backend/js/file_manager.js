
 var guides = [];
 var images = [];
 var tour_id;


 $(document).ready( function () {
         loadDataInTable();
         
 
        
 
     
 
 } );
 
 
 
 
 
 function loadDataInTable(){
	 
       $('#images').DataTable({
	       			"dom": '<"wrapper"flipt>',
	       			 "filter": true,
                     "paging": true,
                     responsive: true,
                     data: images,
                     columns: [
                        { data: 'fname' },
                        { data: 'size' },
                        {
	                        "render": function (data, type, JsonResultRow, meta) {
	                            return '<a target="_blank" href="' + JsonResultRow.link + '">' + JsonResultRow.pretty_url + '</a>';
	                        }
                        },
                        {
	                        "render": function (data, type, JsonResultRow, meta) {
	                            return '<a target="_blank" href="' + JsonResultRow.cms + '">' + JsonResultRow.pretty_url + '</a>';
	                        }
                        },
                        {
	                        "render": function (data, type, JsonResultRow, meta) {
	                            return '<img style="display: block; margin: 0 auto; height: 200px; width:auto;" src="'+JsonResultRow.preview+'">';
	                        }
                    	},
						{ data: 'type' }
                  
                     ],
                    
                 });
        $('#images').css('width','100%')
 }