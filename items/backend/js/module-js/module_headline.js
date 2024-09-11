function new_module_headline(id, parent) {
  var new_elem = {
    module: null,
    type: 'headline',
    text: '',
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

    getPrototypeHTML: function () {

      let modNaming = 'Headline'
      let modClass = 'module_headline'

      var stream = `<div module_id='${this.id}'
      collapsable='${this.collapsable}'
      repo_id='${this.repoId}'
      title='${this.title}'
      subtitle='${this.subtitle}'
      module_id='${this.id}'
      top='${
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

        createModuleHelpers($(this), '#popup_module_headline')

        headline_editor.setData(childModule.html())
        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()



        popupElem.find('.popup_save_button').click(function () {

          var headline = headline_editor.getData()
          childModule.html(nl2br(headline, false))

          parentModule.attr('collapsable', $('#text_collapsable_type').find(':selected').val())

        })



      })
    },



    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'headline',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),
        
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
