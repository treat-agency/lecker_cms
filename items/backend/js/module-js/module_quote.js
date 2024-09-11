function new_module_quote(id, parent) {
  var new_elem = {
    module: null,
    id: id,
    parent: parent,
    type: 'quote',

    text: '',
    author: '',

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

      let modNaming = 'Quote'
      let modClass = 'module_quote'

      var stream = `<div module_id='${this.id}' author="${this.author}"  top='${
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
        
        createModuleHelpers($(this), '#popup_module_quote')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')


        var content = childModule.text();
        var author = parentModule.attr('author');

        popupElem.find('textarea#module_quote_editor').val(content)
        popupElem.find('textarea#module_quoteauthor_editor').val(author)
        
        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()


        popupElem.find('.popup_save_button').click(function () {

          let quoteContent = nl2br(popupElem.find('textarea').val(), false)
          let authorContent = popupElem.find('#module_quoteauthor_editor').val()

          parentModule.attr('author', authorContent)
          childModule.html(quoteContent)

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)
        })
      })
    },



    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: 'quote',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        author: parentModule.attr('author'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
