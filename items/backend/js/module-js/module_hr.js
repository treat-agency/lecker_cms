function new_module_hr(id, parent) {
  var new_elem = {
    module: null,
    type: 'hr',
    text: '',
    id: id,
    parent: parent,
    visible: 0,

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

      let modNaming = 'Divider'
      let modClass = 'module_hr'

      var stream = `<div module_id='${this.id}' visible='${this.visible}' top='${
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

        createModuleHelpers($(this), '#popup_module_hr')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')


        popupElem.find('#hr_display_type').val(active_module.attr('visible'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {

          var selected_type = $('#hr_display_type').find(':selected').val()
          parentModule.attr('visible', selected_type)

          var display_text = 'No'

          switch (selected_type) {
            case '0': {
              display_text = 'Visible - No'
              break
            }
            case '1': {
              display_text = 'Visible - Yes'
              break
            }

            default: {
              break
            }
          }

          parentModule.attr('data-text', display_text)
          childModule.text(display_text)

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)
        })
      })
    },


    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')


      var ret = {
        type: 'hr',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),
        
        visible: parentModule.attr('visible'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
