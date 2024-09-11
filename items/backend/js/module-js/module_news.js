function new_module_news(id, parent) {
  var new_elem = {
    module: null,
    type: 'news',
    text: '',
    id: id,
    parent: parent,
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

      let modNaming = 'News'
      let modClass = 'module_news'

      var stream = `<div module_id='${this.id}' link='${this.link}' top='${
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

        $('.popup_edit').hide()

        $('.newModuleParent').find('.moduleEdit').removeClass('inverted')
        $(this).addClass('inverted')

        let parentModule = $(this).closest('.newModuleParent')
        let childModule = parentModule.find('.module')


        var popupElem = $('#popup_module_news')

        popupElem.find('textarea').val(childModule.html())
        popupElem.find('#newsletterLinkInput').val(parentModule.attr('link'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {
          parentModule.attr('link', $('#newsletterLinkInput').val())
          childModule.html(nl2br(popupElem.find('textarea').val(), false))
          console.log('news updated')
        })


      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'news',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),
        
        link: parentModule.attr('link'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
