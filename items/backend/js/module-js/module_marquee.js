function new_module_marquee(id, parent) {
  var new_elem = {
    module: null,
    type: 'marquee',
    text: '',
    id: id,
    parent: parent,
    marquee: 0,
    link: '',

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

      let modNaming = 'Marquee'
      let modClass = 'module_marquee'

      var stream = `<div module_id='${this.id}' marquee='${this.marquee}' link='${this.link}' top='${Math.ceil(resize_col(this.parent) / 10) * 10}' class='newModuleParent' data-text='${modNaming}'>
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

        createModuleHelpers($(this), '#popup_module_marquee')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        // $('.crud_tab_item[type="module_content"]').click()

        $('#image_display_type').val(active_module.attr('display_type'))

        popupElem.find('textarea').val(childModule.html())
        popupElem.find('#marquee_display_type').val(parentModule.attr('marquee'))
        popupElem.find('#marqueeLinkInput').val(parentModule.attr('link'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {

          parentModule.attr('link', $('#marqueeLinkInput').val())
          parentModule.attr('marquee', $('#marquee_display_type').find(':selected').val())
          childModule.html(popupElem.find('textarea').val())

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)

        })
      })
    },


    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: 'marquee',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        marquee: parentModule.attr('marquee'),
        link: parentModule.attr('link'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
