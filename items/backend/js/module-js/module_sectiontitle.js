function new_module_sectiontitle(id, parent) {
  var new_elem = {
    module: null,
    type: 'sectiontitle',
    text: '',
    id: id,
    parent: parent,
    size: 0,

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

      let modNaming = 'Headline'
      let modClass = 'module_sectiontitle'

      var stream = `<div module_id='${this.id}' size='${this.size}'  top='${
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
        
        createModuleHelpers($(this), '#popup_module_sectiontitle')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        popupElem.find('#sectiontitle_size').val(parentModule.attr('size'))
        popupElem.find('#module_sectiontitle_editor').val(childModule.text().trim())

        $('.crud_tab_item[type="module_content"]').click()

        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {
          parentModule.attr('size', $('#sectiontitle_size').find(':selected').val())
          childModule.html(nl2br(popupElem.find('textarea').val(), false))

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(parentModule)
        })
      })
    },


    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: 'sectiontitle',
        top: parseInt(parentModule.position().top),
        column: this.parentModule.attr('id'),
        dbid: parentModule.attr('dbid'),

        size: parentModule.attr('size'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
