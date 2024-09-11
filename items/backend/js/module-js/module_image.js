function new_module_image(id, parent) {
  var new_elem = {
    module: null,
    type: 'image',
    filename: '',
    description: '',
    link: '',
    full: 0,
    id: id,
    parent: parent,
    layout: 0,

    // MODULE BASIC
    init: function (parent) {
      this.parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      this.childModule = this.parentModule.find('.module')
      this.editButton = this.parentModule.find('.moduleEdit')
      this.deleteButton = this.parentModule.find('.moduleDelete')

      this.bindListeners()
      igniteDragging()
    },


    getPrototypeHTML: function () {

      let modNaming = 'Image'
      let modClass = 'module_image'

      var stream = `<div module_id='${this.id}' layout='${this.layout}' top='${
        Math.ceil(resize_col(this.parent) / 10) * 10
      }' repo_id="" display_type="0" full="0" description=" " link="" class='newModuleParent' data-text='${modNaming}'>
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
        <div class="moduleImageHolder"></div>
			</div>
		</div>`

      return stream
    },

    bindListeners: function () {

      this.editButton.click(function () {

        createModuleHelpers($(this), '#popup_module_image')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')


        // popup id
        popupElem.find('.js-repoPopup').attr('module_id', 'false');
        if (parentModule.attr('dbid') != undefined) {
          popupElem.find('.js-repoPopup').attr('module_id', parentModule.attr('dbid'));
        }

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


        popupElem.find('#image_link').val(parentModule.attr('link'));
        popupElem
          .find('#image_display_type')
          .val(parentModule.attr('display_type'));



        $('#repo_type').val('edit_image')



        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {

          var the_link = $('#image_link').val()
          parentModule.attr('link', the_link)

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)

        })

      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'image',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: parentModule.attr('id'),
        link: parentModule.attr('link'),
        display_type: parentModule.attr('display_type'),
      };

      return ret
    },

    load: function (properties) {
      this.setText(properties.content)
      this.setMarginBottom(properties.margin_bottom)
      this.setMarginTop(properties.margin_top)
      this.setFontColor(properties.font_color)
      this.setFontSize(properties.font_size)
      this.setTextAlign(properties.align)
      this.setSidebarImage(properties.right_side_img)
      this.setSidebarText(properties.right_side_img_text)
    },
  }

  return new_elem;
}
