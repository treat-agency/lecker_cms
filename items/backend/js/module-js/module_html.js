function new_module_html(id, parent) {
  var new_elem = {
    module: null,
    id: id,
    type: 'html',
    parent: parent,

    html: '',

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

      let modNaming = 'HTML'
      let modClass = 'module_html'

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

        createModuleHelpers($(this), '#popup_module_html')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')


        popupElem.find('textarea').val(childModule.html())
        
        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()



        popupElem.find('.popup_save_button').click(function () {

          // modules[active_id].html_code = popupElem.find('textarea').val()
          parentModule.find('.module_html_content').html(popupElem.find('textarea').val())
          childModule.html(popupElem.find('textarea').val())

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)
        })



      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')


      var ret = {
        type: 'html',
        top: parseInt(parentModule.position().top),
        column: this.parentModule.attr('id'),
        dbid: parentModule.attr('dbid'),
        
        html: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
