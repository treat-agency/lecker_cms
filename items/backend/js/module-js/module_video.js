function new_module_video(id, parent) {
  var new_elem = {
    module: null,
    id: id,
    parent: parent,
    type: 'video',

    url: '',
    text: 'Video text goes here',
    display_type: '',
    playauto: 0,

    // layout: 0,
    // control_options: 0,

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

      let modNaming = 'Video'
      let modClass = 'module_video'

      var stream = `<div draggable="true" module_id='${this.id}' text='${this.text}' url='${this.url}' display_type='${
        this.display_type
      }' playauto=${this.playauto}
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
        <video autoplay muted src="${this.url}"></video>
			</div>
		</div>`

      return stream
    },


    bindListeners: function () {

      this.editButton.click(function () {

        createModuleHelpers($(this), '#popup_module_video')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        popupElem.find('#video_type_y').val(parentModule.attr('display_type'))
        popupElem.find('#video_url_input').val(parentModule.attr('url'))
        popupElem.find('#video_autoplay_type').val(parentModule.attr('playauto'))
        popupElem.find('#video_text_input').val(parentModule.attr('text'))

        // popupElem.find('#video_controls_type').val(parentModule.attr('control_options'))
        // popupElem.find('#video_display_type').val(parentModule.attr('layout'))

        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()




        popupElem.find('.popup_save_button').click(function () {

          parentModule.attr('display_type', $('#video_type_y').find(':selected').val())
          parentModule.attr('url', popupElem.find('#video_url_input').val())
          parentModule.find('video').attr('src', popupElem.find('#video_url_input').val())
          parentModule.attr('playauto', $('#video_autoplay_type').find(':selected').val())
          parentModule.attr('text', popupElem.find('#video_text_input').val())
       
          popupElem.find('.popup_save_button').unbind('click')
          emptyPopupAndMessage(popupElem, parentModule)

        })



      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'video',
        dbid: parentModule.attr('dbid'),
        top: parseInt(parentModule.position().top),
        column: this.parentModule.attr('id'),

        url: parentModule.attr('url'),
        text: parentModule.attr('text'),
        autoplay: parentModule.attr('playauto'),
        display_type: parentModule.attr('display_type'),

        // layout: parentModule.attr('layout'),
        // controls: parentModule.attr('control_options'),
      }
      // console.log(ret)

      return ret
    },
  }

  return new_elem;
}
