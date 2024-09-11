function new_module_column_start(id, parent, $rightColStart) {
  var new_elem = {
    module: null,
    type: 'column_start',
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

      let modNaming = 'Column start'
      let modClass = 'module_column_start'

      let colType = $rightColStart ? 1 : 0 ;

      var stream = `<div module_id='${this.id}' col_left_50" col_type="${colType}" top='${
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

        createModuleHelpers($(this), '#popup_module_column_start')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        popupElem.find('#column_start_type').val(parentModule.attr('col_type'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()


        popupElem.find('.popup_save_button').click(function () {

          var selected_type = $('#column_start_type').find(':selected').val()
          parentModule.attr('col_type', selected_type)

          var display_text = 'Column start module: Left 50%'

          switch (selected_type) {
            case '0': {
              display_text = 'Column start module: Left 50%'
              break
            }
            case '1': {
              display_text = 'Column start module: Right 50%'
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
        type: 'column_start',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        col_type: parentModule.attr('col_type'),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
