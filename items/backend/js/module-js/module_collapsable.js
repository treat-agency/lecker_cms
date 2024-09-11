function new_module_collapsable(id, parent) {
  var new_elem = {
    module: null,
    type: 'collapsable',
    id: id,
    parent: parent,

    text: '',
    title: '',

    // MODULE BASICD
    init: function (parent) {
      this.parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      this.childModule = this.parentModule.find('.module')
      this.editButton = this.parentModule.find('.moduleEdit')
      this.deleteButton = this.parentModule.find('.moduleDelete')

      this.bindListeners()
      igniteDragging()
    },

    getPrototypeHTML: function () {
      let modNaming = 'Collapsable'
      let modClass = 'module_collapsable'

      var stream = `<div module_id='${this.id}' title='${this.title}'  top='${
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
        createModuleHelpers($(this), '#popup_module_collapsable')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        popupElem.find('#module_colltitle').val(parentModule.attr('title'))
        // popupElem.find('#text_collapsable_type').val(parentModule.attr('collapsable'))

        // field for ckeditor
        collapsable_editor.setData(childModule.html())

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {

          parentModule.attr('title', $('#module_colltitle').val())
          // parentModule.attr('collapsable', $('#text_collapsable_type').find(':selected').val())

          // field for ckeditor
          var text = collapsable_editor.getData()
          childModule.html(nl2br(text, false))
          console.log(childModule)
          console.log(text)

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)
        })
      })
    },

    getSaveData: function () {
      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: 'collapsable',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        title: parentModule.attr('title'),

        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem
}
