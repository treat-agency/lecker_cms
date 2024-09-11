function new_module_download(id, parent) {
  var new_elem = {
    module: null,
    type: 'download',
    path: '',
    fname: '',
    file_tag: "",
    pdf: "",

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

      let modNaming = 'Download'
      let modClass = 'module_download'

      var stream = `<div module_id='${this.id}' download_fname="" path="${this.path}"  pdf="${this.pdf}"  file_tag="${this.file_tag}"  top='${Math.ceil(resize_col(this.parent) / 10) * 10}' class='newModuleParent' data-text='${modNaming}'>
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
			<div  class='module ${modClass} has_placeholder'><div class="downloadTitle"></div><div class="downloadSubTitle"></div></div>`;

      return stream
    },

    bindListeners: function () {

      this.editButton.click(function () {

        $('select').select2();

        createModuleHelpers($(this), '#popup_module_download')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')
        popupElem.find('.downloadChange').unbind('change')


        // CHANGE
        // var mod_id = active_module.attr('module_id')

        // for (var i = 0; i < modules.length; i++) {
        //   if (modules[i] !== undefined) {
        //     if (modules[i].id == mod_id) {
        //       active_id = i
        //       break
        //     }
        //   }
        // }

        if (parentModule.attr('pdf') != '' && parentModule.attr('pdf') != 0) {
            console.log('a')
            $('#download_source').val('0').trigger('change')
            $('#download_pdf').val(parentModule.attr('pdf')).trigger('change')
            
          } else if(parentModule.attr('file_tag') != '' && parentModule.attr('file_tag') != 0) {
            console.log('b')
            $('#download_source').val('1').trigger('change')
            $('#download_tag').val(parentModule.attr('file_tag')).trigger('change')

        } else if (parentModule.attr('path') != '' && parentModule.attr('path') != 0) {
            console.log('c')
            $('#download_source').val('2').trigger('change')
            $('#download_path').val(parentModule.attr('path'))
            
          } else {
            console.log("DDDD")
            $('#download_source').val('0').trigger('change')
            $('#download_path').val()
        }


        $('#download_pdf').select2()
        $('#download_tag').select2()
        // $('#download_background').select2()

        // popupElem.find('#download_path').val(parentModule.attr('path'))
        // popupElem.find('#download_pdf').val(parentModule.attr('pdf'))
        // popupElem.find('#download_tag').val(parentModule.attr('file_tag'))
        


        $('.crud_tab_item[type="module_content"]').click()

        popupElem.show();

        popupElem.find('.popup_save_button').click(function () {


          let tempType = $('#download_source').val()

          if (tempType == 0) {
            let tempVal = $('#download_pdf').val()
            let tempText = $('#download_pdf option:selected').text()
            
            parentModule.attr('pdf', tempVal)
            parentModule.attr('file_tag', '')
            parentModule.attr('path', '')
            childModule.find('.downloadTitle').html(`Download module for <span class="boldAndUnderline">file</span>`)
            childModule.find('.downloadSubTitle').html(`${tempText}`)

          } else if (tempType == 1) {
            let tempVal = $('#download_tag').val()
            let tempText = $('#download_tag option:selected').text()

            parentModule.attr('pdf', '')
            parentModule.attr('file_tag', $('#download_tag').val())
            parentModule.attr('path', '')
            childModule
              .find('.downloadTitle')
              .html(`Download module for <span class="boldAndUnderline">file tag</span>`)
            childModule.find('.downloadSubTitle').html(`${tempText}`)

          } else if (tempType == 2) {
            let tempVal = $('#download_path').val()
            let tempText = $('#download_path').val()
            
            parentModule.attr('pdf', '')
            parentModule.attr('file_tag', '')
            parentModule.attr('path', $('#download_path').val())
            childModule
              .find('.downloadTitle')
              .html(`Download module for <span class="boldAndUnderline">external link</span>`)
            childModule.find('.downloadSubTitle').html(`${tempText}`)

          }
          

          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule);

        })



      })

    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'download',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),
        fname: parentModule.attr('fname'),
        file_tag: parentModule.attr('file_tag'),
        path: parentModule.attr('path'),
        pdf: parentModule.attr('pdf'),
      }
      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
