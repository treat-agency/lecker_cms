function new_module_pdf(id, parent) {
  var new_elem = {
    module: null,
    type: "pdf",
    filename: "",
    image: "",
    dl_type: "PDF",
    id: id,
    parent: parent,
	running: false,

    // MODULE BASIC
    init: function (parent) {
      this.module = $(".module[module_id=" + this.id + "]");
      this.parent = this.module.parent();
      this.bindListeners();
      //igniteDragging();
    },

    getPrototypeHTML: function () {
      var html =
        '<div repo_id="" title="" text="" dl_type="PDF" link="" button_text="Herunterladen" image="" module_id=' +
        this.id +
        ' class="module module_pdf has_placeholder" data-text="PDF module" style=""></div>';

      resize_col(this.parent);

      return html;
    },

    bindListeners: function () {
      this.module.click(function () {
        active_module = $(this);

        // position_tools(active_module);

        toolListeners();
      });

      this.module.dblclick(function () {
        active_module = $(this);
        active_id = active_module.attr("module_id");

        var mod_id = active_module.attr("module_id");

        for (var i = 0; i < modules.length; i++) {
          if (modules[i] !== undefined) {
            if (modules[i].id == mod_id) {
              active_id = i;
              break;
            }
          }
        }
        $("#repo_type").val("edit_pdf");

        $('.crud_tab_item[type="module_content"]').click();

        $("#popup_module_pdf").find(".popup_cancel_button").unbind("click");
        $("#popup_module_pdf").find(".popup_save_button").unbind("click");
        $("#popup_module_pdf").find(".popup_delete_button").unbind("click");
		//$("#pdf_upload_input").unbind('change');


        var pdf_title = $(this).attr("title");
        var pdf_text = $(this).attr("text");
        var pdf_link = $(this).attr("link");
        var button_text = $(this).attr("button_text");

        this.filename = $(this).attr("filename");
        this.image = $(this).attr("image");
        var pdf_type = $(this).attr("dl_type");

        $("#pdf_image").attr("src", rootUrl + "/items/uploads/images/" + this.image);
        $("#pdf_image").attr("fname", this.image);

        $("#pdf_image").on("error", function () {
          $(this).attr("src", rootUrl + "/items/backend/img/pdf.svg");
        });

        $("#pdf_upload_input").attr("value", this.filename);
        $("#pdf_display_name").val(pdf_title);
        $("#pdf_display_text").val(pdf_text);
        $("#pdf_mod_link").val(pdf_link);

        $("#pdf_button_text").val(button_text);
        $("#pdf_type").val(pdf_type);
        $("#pdf_filename").val(this.filename);

        $("#popup_module_pdf").show();

        $("#popup_module_pdf")
          .find(".popup_save_button")
          .click(function () {
            var title = $("#pdf_display_name").val().replace(/\n/g, "<br>");
            var text = $("#pdf_display_text").val().replace(/\n/g, "<br>");
            var button_text = $("#pdf_button_text").val();
            var input_fname = $("#pdf_filename").val();
            var link = $("#pdf_mod_link").val();
            if (input_fname != "") {
              var fname = input_fname;
            } else {
              var str = $("#pdf_upload_input").val();

              var n = str.lastIndexOf("\\");

              var fname = str.substring(n + 1);
            }

            var image = $("#pdf_image").attr("fname");
            var repo_id = $("#pdf_image").attr("repo_id");
            var dl_type = $("#pdf_type").val();

            this.display_text = text;
            if (image != "" && image != null && image != "module_image_preview.png") {
              var html =
                '<img class="list_item_img" src="' +
                rootUrl +
                "items/uploads/images/" +
                image +
                '" fname="' +
                image +
                '"/>' +
                '<div class="list_item_text_container">' +
                '<div class="list_item_title semibold">' +
                title +
                "</div>" +
                '<div class="list_item_teaser regular">' +
                text +
                "</div>" +
                '<div class="list_item_more semibold">' +
                button_text +
                "</div>" +
                "</div>" +
                "</div>";
            } else {
              var html =
                '<img style="height:60px;width:auto;" class="list_item_img" src="' +
                rootUrl +
                'items/frontend/img/pdf_icon.svg" fname=""/>' +
                '<div class="list_item_text_container" style="height:auto;">' +
                '<div class="list_item_title semibold">' +
                title +
                "</div>" +
                '<div class="list_item_teaser regular">' +
                text +
                "</div>" +
                '<div class="list_item_more semibold">' +
                button_text +
                "</div>" +
                "</div>" +
                "</div>";
            }

            active_module.empty();
            active_module.append(html);
            active_module.attr("title", title);
            active_module.attr("text", text);
            active_module.attr("link", link);
            active_module.attr("button_text", button_text);
            active_module.attr("image", image);
            active_module.attr("dl_type", dl_type);
            active_module.attr("repo_id", repo_id);
            active_module.attr("filename", fname);
            resize_col(active_module.parent());
            // position_tools(active_module);
            //$('#popup_module_pdf').hide();
            $("#pdf_display_name").val("");
            $("#pdf_upload_input").val("");
            $("#pdf_type").val("PDF");
          });

        $(".repo_item").off("click");
        $(".repo_item").on("click", function () {
          $this = $(this).find(".repo_item_select");

          var iid = $this.attr("iid");
          var fname = $this.attr("fname");
          var fullPath = rootUrl + "items/uploads/images/" + fname;

          active_id = active_module.attr("module_id");

          var mod_id = active_module.attr("module_id");

          for (var i = 0; i < modules.length; i++) {
            if (modules[i] !== undefined) {
              if (modules[i].id == mod_id) {
                active_id = i;
                break;
              }
            }
          }

          modules[active_id].filename = fname;
          active_module.find("img").attr("src", fullPath);

          $("#pdf_image").attr("src", fullPath);
          $("#pdf_image").attr("repo_id", iid);
          $("#pdf_image").attr("fname", fname);
          closeRepo();
        });

        $("#popup_module_pdf")
          .find(".popup_cancel_button")
          .click(function () {
            $("#popup_module_pdf").hide();
          });

        $("#popup_module_pdf")
          .find(".popup_remove_image_button")
          .click(function () {
            $("#pdf_image").attr("src", "");
            $("#pdf_image").attr("fname", "");
            $("#pdf_image").attr("repo_id", 0);

            this.image = "module_image_preview.png";
          });

        // $("#popup_module_pdf")
        //   .find(".popup_upload_button")
        //   .click(function () {
        //     //active_module.find('input').click();
        //     //openFilemanager('image', active_module.attr('module_id'));

        //     var selected = [];

        //     var repo_id = $("#pdf_image").attr("repo_id");

        //     selected.push(parseInt(repo_id));

        //     $(".repo_item").each(function () {
        //       var did = $(this).data("id");

        //       if ($.inArray(did, selected) !== -1) {
        //         $(this).addClass("selected_item");
        //       }
        //     });

        //     $("#repo_overlay").show();
        //     lazy_load_start();
        //     setInterval(function () {
        //       lazy_load_start();
        //     }, 300);
        //   });

        $("#popup_module_pdf")
          .find(".popup_delete_button")
          .click(function () {
            var parent = active_module.parent();
            var mod_id = active_module.attr("module_id");

            for (var i = 0; i < modules.length; i++) {
              if (modules[i] !== undefined) {
                if (modules[i].id == mod_id) {
                  modules.splice(i, 1);
                  break;
                }
              }
            }
            active_module.remove();

            resize_col(parent);
            $("#popup_module_pdf").hide();
          });

        $("#pdf_upload_input").click(function () {
          //$("#pdf_upload_input").click();
        });
      });

      $("#pdf_upload_input").change(function () {
	
		if(this.running == true)
		{
			return false;
		}
		else
		{
			this.running = true;
		}
		
		
        active_id = $(this).attr("module_id");

        var mod_id = $(this).attr("module_id");
        var filesize = 0;
        for (var i = 0; i < modules.length; i++) {
          if (modules[i] !== undefined) {
            if (modules[i].id == mod_id) {
              active_id = i;
              break;
            }
          }
        }
        var uploadpath = $(this).attr("uploadpath");
        var xhr = new XMLHttpRequest();
        var fd = new FormData();
        var files = this.files;

        fd.append("data", files[0]);
        fd.append("filename", files[0].name);
        fd.append("uploadpath", uploadpath);
        fd.append("size", files[0].size);

        filesize = files[0].size;

        xhr.addEventListener("load", function (e) {
          var ret = $.parseJSON(this.responseText);

          if (ret.success) {
            this.filename = ret.filename;
            //modules[active_id].filename = ret.filename;
            active_module.attr("filename", ret.filename);
            showMessage("success", "File uploaded!");
            resize_col(active_module.parent());
          } else {
            //alert("Error while uploading, check file extensions!");
            showMessage("error", "File upload failed!");
            $("#pdf_upload_input").val();
          }

			this.running = false;
        });

        // listen for `progress` event
        xhr.upload.onprogress = (event) => {
          // event.loaded returns how many bytes are downloaded
          // event.total returns the total number of bytes
          // event.total is only available if server sends `Content-Length` header
          var fileLoaded = Math.floor((event.loaded / event.total) * 100);

          $("#upload_progress").text(fileLoaded + "%");
        };

        xhr.open("post", rootUrl + "entities/Content/upload_pdf");

        xhr.send(fd);

        /*	
				var element = $(this).attr('id');
				var file = document.getElementById(element).files[0];
				var uploadpath = $(this).attr('uploadpath');
				var reader = new FileReader();
				var url;
				
				reader.readAsDataURL (file);
				reader.onload = function(event)
				{
					var result = event.target.result;
					$.ajax(
					{
						url: rootUrl + 'entities/Website/upload_pdf',
						data: { filename: file.name, data: result , uploadpath: uploadpath},
						method: 'POST',
						success: function(data)
						{
							var ret = $.parseJSON(data);
							
							if(ret.success)
							{
								this.filename = ret.filename;
								modules[active_module.attr('module_id')].filename = ret.filename;
								active_module.attr('filename',  ret.filename);
								
								resize_col(active_module.parent());
							}
							else
							{
								alert('Error while uploading');
							}
						}
					});			
				};*/
      });
    },


    filemanagerResult: function (fileData) {
      active_module.find("img").attr("src", fileData.fullPath);
      //$('#popup_module_image').find('img').attr('src', fileData.fullPath);
      $("#popup_module_pdf").find("img").attr("src", fileData.fullPath);
      $("#popup_module_pdf").find("img").attr("fname", fileData.name);
      closeFilemanager();
    },

    getSaveData: function () {
      var ret = {
        column: this.parent.attr('id'),
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        
        fname: this.module.attr('filename'),
        image: this.module.attr('image'),
        text: this.module.attr('text'),
        title: this.module.attr('title'),
        link: this.module.attr('link'),
        button_text: this.module.attr('button_text'),
        dl_type: this.module.attr('dl_type'),
        repo_id: this.module.attr('repo_id'),
        type: 'pdf',
      }

      return ret;
    },

    load: function (properties) {
      this.setText(properties.content);
      this.setMarginBottom(properties.margin_bottom);
      this.setMarginTop(properties.margin_top);
      this.setFontColor(properties.font_color);
      this.setFontSize(properties.font_size);
      this.setTextAlign(properties.align);
      this.setSidebarImage(properties.right_side_img);
      this.setSidebarText(properties.right_side_img_text);
    },
  };

  return new_elem;
}
