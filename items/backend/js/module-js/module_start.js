function new_module_start(id, parent) {
  var new_elem = {
    module: null,
    type: 'start',
    filename: '',
    description: '',
    title: '',
    img_credits: '',
    subtitle: '',
    id: id,
    parent: parent,

    // MODULE BASIC
    init: function (parent) {
      this.parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      this.childModule = this.parentModule.find('.module')
      this.editButton = this.parentModule.find('.moduleEdit')
      this.deleteButton = this.parentModule.find('.moduleDelete')

      this.bindListeners()
      igniteDragging()
    },

    // getPrototypeHTML: function () {
    //   var html =
    //     '<div module_id=' +
    //     this.id +
    //     ' repo_id="" class="module module_start" title="" img_credits="" subtitle="" description=" " data-text="Start/header module" filename="" style="top:0;"><div class="start_title has_placeholder" data-text="Start/header module"></div><img src=""/><div class="start_credits"></div><div class="start_subtitle"></div><div class="start_intro"></div></div>'
    //   return html
    // },

    // getPrototypeHTML: function () {
    //   var html =
    //     '<div module_id=' +
    //     this.id +
    //     ' class="module module_headline has_placeholder" data-text="Headline module" style="top: ' +
    //     Math.ceil(resize_col(this.parent) / 10) * 10 +
    //     ';"></div>'
    //   return html
    // },

    getPrototypeHTML: function () {

      let modNaming = 'Start module'
      let modClass = 'module_start'

      var stream = `<div module_id='${this.id}' top='${
        Math.ceil(resize_col(this.parent) / 10) * 10
      }' class='newModuleParent' data-text='${modNaming}'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">${modNaming}</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="${imgBinIcon}" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="${imgEditIcon}" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="${imgUpUrl}" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="${imgDownUrl}" alt="">
						</div>
					</div>
				</div>

			</div>		
			<div  class='module ${modClass} has_placeholder'>
			</div>
		</div>`

      return stream
    },

    bindListeners: function () {

      this.editButton.click(function () {

        $('.popup_edit').hide()

        $('.newModuleParent').find('.moduleEdit').removeClass('inverted')
        $(this).addClass('inverted')

        let parentModule = $(this).closest('.newModuleParent')
        let childModule = parentModule.find('.module')
        active_module = parentModule
        active_id = active_module.attr('module_id')

        var mod_id = active_module.attr('module_id')

        for (var i = 0; i < modules.length; i++) {
          if (modules[i] !== undefined) {
            if (modules[i].id == mod_id) {
              active_id = i
              break
            }
          }
        }
        $('#repo_type').val('edit_start')

        var popupElem = $('#popup_module_start')


        popupElem.find('#pop_start_img').attr('src', parentModule.find('img').attr('src'))
        popupElem.find('#pop_start_img').attr('fname', parentModule.attr('filename'))
        popupElem.find('#pop_start_img').attr('repo_id', parentModule.attr('repo_id'))
        $('#module_start_title').val(parentModule.attr('title'))
        $('#module_start_credits').val(parentModule.attr('img_credits'))
        $('#module_start_subtitle').val(parentModule.attr('subtitle'))
        $('#module_start_editor').val(parentModule.attr('description'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {
          parentModule.css({float: '', 'margin-right': '0px'})

          var the_description = $('#module_start_editor').val()
          var the_credits = $('#module_start_credits').val()
          var the_title = $('#module_start_title').val()
          var the_subtitle = $('#module_start_subtitle').val()

          the_credits = the_credits.replace(/\"/g, '”')
          the_subtitle = the_subtitle.replace(/\"/g, '”')
          the_title = the_title.replace(/\"/g, '”')
          the_description = the_description.replace(/\"/g, '”')

          // if (the_title == "") {
          //   $("#module_start_title").css({ border: "1px solid red" }).focus();
          // } else {
          $('#module_start_title').css({border: '1px solid black'})
          parentModule.attr('description', the_description.replace(/"/g, '“'))
          parentModule.attr('title', the_title)
          parentModule.attr('img_credits', the_credits)
          parentModule.attr('subtitle', the_subtitle)
          parentModule.attr('filename', popupElem.find('#pop_start_img').attr('fname'))

          modules[active_id].filename = popupElem.find('#pop_start_img').attr('fname')
          parentModule.find('img').attr('src', popupElem.find('#pop_start_img').attr('src')).show()
          parentModule.attr('repo_id', popupElem.find('#pop_start_img').attr('repo_id'))

          this.description = the_description.replace(/"/g, '“')
          this.title = the_title
          this.img_credits = the_credits
          this.subtitle = the_subtitle
          this.filename = active_module.attr('filename')
          parentModule.find('.start_title').text(this.title)
          parentModule.find('.start_subtitle').text(this.subtitle)
          parentModule.find('.start_intro').text(this.description)
          parentModule.find('.start_credits').text(this.img_credits)
          // position_tools(parentModule)
          //popupElem.hide();
          //$('#pop_start_img').imgAreaSelect({disable:true,hide:true});
          // }
        })

        $('.repo_item').off('click')
        $('.repo_item').on('click', function () {
          $this = $(this).find('.repo_item_select')

          var iid = $this.attr('iid')
          var fname = $this.attr('fname')
          var fullPath = rootUrl + 'items/uploads/images/' + fname

          active_id = parentModule.attr('module_id')

          var mod_id = parentModule.attr('module_id')

          for (var i = 0; i < modules.length; i++) {
            if (modules[i] !== undefined) {
              if (modules[i].id == mod_id) {
                active_id = i
                break
              }
            }
          }

          modules[active_id].filename = fname
          //active_module.find('img').attr('src', fullPath);
          $('#pop_start_img').attr('src', fullPath)
          $('#pop_start_img').attr('fname', fname)
          $('#pop_start_img').attr('repo_id', iid)
          closeRepo()
        })

        // popupElem.find('.popup_upload_button').click(function () {
        //   var selected = []
        //   var repo_id = $('#pop_start_img').attr('repo_id')
        //   selected.push(parseInt(repo_id))

        //   $('.repo_item').each(function () {
        //     var did = $(this).data('id')
        //     if ($.inArray(did, selected) !== -1) {
        //       $(this).addClass('selected_item')
        //     }
        //   })

        //   //active_module.find('input').click();
        //   //openFilemanager('image', active_module.attr('module_id'));
        //   //$('.crud_tab_item[type="repository"]').click();
        //   $('#repo_overlay').show()
        //   lazy_load_start()
        //   // setInterval(function () {
        //   //   lazy_load_start();
        //   // }, 300);
        // })

        popupElem.find('.popup_remove_image_button').click(function () {
          popupElem
            .find('img')
            .attr('src', rootUrl + 'items/uploads/images/module_image_preview.png')
          popupElem.find('img').attr('fname', 'module_image_preview.png')
          popupElem.find('img').attr('repo_id', 0).hide()

          this.filename = 'module_image_preview.png'
        })

        popupElem.find('.popup_cancel_button').click(function () {
          popupElem.hide()
          $('#pop_start_img').imgAreaSelect({disable: true, hide: true})
        })

        popupElem.find('.popup_delete_button').click(function () {
          var parent = parentModule.parent()
          var mod_id = parentModule.attr('module_id')

          for (var i = 0; i < modules.length; i++) {
            if (modules[i] !== undefined) {
              if (modules[i].id == mod_id) {
                modules.splice(i, 1)
                break
              }
            }
          }
          active_module.remove()

          resize_col(parent)
          $('#pop_start_img').imgAreaSelect({disable: true, hide: true})
          popupElem.hide()
        })

        popupElem.find('.popup_switch_button').click(function () {
          if (parentModule.parent().attr('id') == 'col_left') parentModule.appendTo($('#col_right'))
          else parentModule.appendTo($('#col_left'))

          resize_col($('#col_right'))
          resize_col($('#col_left'))

          modules[active_id].parent = parentModule.parent()

          popupElem.hide()
        })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')
      
      var ret = {
        type: 'start',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        header_img: parentModule.attr('filename'),
        img_credits: parentModule.attr('img_credits'),
        title: parentModule.attr('title'),
        sub_title: parentModule.attr('subtitle'),
        content: parentModule.attr('description'),
        repo_id: parentModule.attr('repo_id'),
      }

      console.log(ret)

      return ret
    },

    load: function (properties) {
      /*this.setText(properties.content);
			this.setMarginBottom(properties.margin_bottom);
			this.setMarginTop(properties.margin_top);
			this.setFontColor(properties.font_color);
			this.setFontSize(properties.font_size);
			this.setTextAlign(properties.align);
			this.setSidebarImage(properties.right_side_img);
			this.setSidebarText(properties.right_side_img_text);*/
    },
  }

  return new_elem;
}
