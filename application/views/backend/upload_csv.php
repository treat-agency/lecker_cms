<div style="margin-top:200px;">Upload your CSV here:</div>
<input type="file" id="upload_csv" />
<input type="hidden" id="item_id" value="<?= $itemId ?>">

<div id="result_holder"></div>
<script>


  $('#upload_csv').on('change', function() {

    var xhr = new XMLHttpRequest();
    var fd = new FormData;

    var files = $(this).prop('files');
    fd.append('data', files[0]);
    fd.append('filename', files[0].name);

    xhr.addEventListener('load', function(e) {
      var ret = $.parseJSON(this.responseText);


      if (ret.success) {
        $('#result_holder').empty();
        var iid = $('#item_id').val();
        $.ajax({
          type: "POST",
          url: rootUrl + "entities/Content/csvUpdateWhereId",
          data: {
            filename: ret.filename,
            iid: iid
          },

          success: function(data) {

            var json = $.parseJSON(data);
            var rows = json.returndata;

            for (var i = 0; i < rows.length; i++) {

               var elem = "<div>"+rows[i].firstname+" "+rows[i].lastname+" ("+rows[i].email+")</div>"

              $('#result_holder').append(elem);
            }


          }
        });

      } else {
        alert('Error while uploading');
      }
    });

    xhr.open('post', rootUrl + 'entities/Content/upload_file');
    xhr.send(fd);
  })


</script>
