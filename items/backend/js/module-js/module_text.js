function new_module_text(id, parent) {
  var new_elem = {
    module: null,
    type: "text",
    id: id,
    parent: parent,

    text: "",
    collapsable: 0,
    layout: 0,

    // MODULE BASICD
    init: function (parent) {
      this.parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      this.childModule = this.parentModule.find('.module')
      this.editButton = this.parentModule.find('.moduleEdit')
      this.deleteButton = this.parentModule.find('.moduleDelete')

      this.bindListeners();
      igniteDragging();

    },

    getPrototypeHTML: function () {


      let modNaming = 'Text';
      let modClass = 'module_text';

		var stream = `<div module_id='${this.id}' collapsable='${this.collapsable}' layout='${this.layout}' top='${Math.ceil(resize_col(this.parent) / 10) * 10}' class='newModuleParent' data-text='${modNaming}'>
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

      return stream;
    },

    bindListeners: function () {

      this.editButton.click(function () {

        createModuleHelpers($(this), '#popup_module_text')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')


        popupElem.find('#text_layout_type').val(parentModule.attr('layout'))
        popupElem.find('#text_collapsable_type').val(parentModule.attr('collapsable'))

        // field for ckeditor
        text_editor.setData(childModule.html())

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()



        popupElem.find('.popup_save_button').click(function () {

          parentModule.attr('layout', $('#text_layout_type').find(':selected').val())
          parentModule.attr('collapsable', $('#text_collapsable_type').find(':selected').val())

          // field for ckeditor
          var text = text_editor.getData()
          childModule.html(nl2br(text, false))

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)

        })


      })
    },



    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = parentModule.find('.module')

      var ret = {
        type: "text",
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr("id"),

        collapsable: parentModule.attr("collapsable"),
        layout: parentModule.attr("layout"),

        content: childModule.html(),

      };

      return ret;
    },

    load: function (properties) {},
  };

  return new_elem;
}
