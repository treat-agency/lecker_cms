function new_module_column_end(id, parent) {
  var new_elem = {
    module: null,
    type: 'column_end',
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

      let modNaming = 'Column end'
      let modClass = 'module_column_end'

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

        createModuleHelpers($(this), '#popup_module_column_end')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()


      })
    },



    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: 'column_end',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
