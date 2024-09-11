function new_module_gallery(id, parent) {
  var new_elem = {
    module: null,
    type: 'gallery',
    id: id,
    parent: parent,
    slider: 0,

    // MODULE BASIC
    init: function (parent) {
      this.parentModule = $('.newModuleParent[module_id=' + this.id + ']');
      this.childModule = this.parentModule.find('.module');
      this.editButton = this.parentModule.find('.moduleEdit');
      this.deleteButton = this.parentModule.find('.moduleDelete');

      this.bindListeners();
      igniteDragging();
    },

    getPrototypeHTML: function () {
      let imgUpUrl = rootUrl + 'items/backend/icons/iconArrowUp.svg';
      let imgDownUrl = rootUrl + 'items/backend/icons/iconArrowDown.svg';
      let imgEditIcon = rootUrl + 'items/backend/icons/editIcon.svg';
      let imgBinIcon = rootUrl + 'items/backend/icons/binIcon.svg';
      let modNaming = 'Gallery';
      let modClass = 'module_gallery';

      var stream = `<div module_id='${
        this.id
      }' slider="1" scale_images="0" top='${
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
        <div class="moduleImageHolder"></div>
      </div>
    </div>`;

      return stream;
    },

    bindListeners: function () {
      this.editButton.click(function () {

      createModuleHelpers($(this), '#popup_module_gallery')

      // unbind
      popupElem.find('.popup_save_button').unbind('click')


           popupElem.find('.js-repoPopup').attr('module_id', 'false');
              if (parentModule.attr('dbid')) {
                popupElem
                  .find('.js-repoPopup')
                  .attr('module_id', parentModule.attr('dbid'));
              }


                active_id = active_module.attr('module_id');

                var mod_id = active_module.attr('module_id');

                for (var i = 0; i < modules.length; i++) {
                  if (modules[i] !== undefined) {
                    if (modules[i].id == mod_id) {
                      active_id = i;
                      break;
                    }
                  }
                }



        var slider = active_module.attr('slider');
        var scale_images = active_module.attr('scale_images');

        $('#gallery_slider').val(slider)


        $('#gallery_scale_images').val(scale_images)



        // $('#popup_module_gallery').find('.popup_cancel_button').unbind('click');
        // $('#popup_module_gallery').find('.popup_save_button').unbind('click');
        // $('#popup_module_gallery').find('.popup_delete_button').unbind('click');


         $('.crud_tab_item[type="module_content"]').click();

          popupElem.show();

        $('#popup_module_gallery').find('.popup_save_button').click(function () {
            console.log('clicked')

            var the_slider = $('#gallery_slider').val();
            var the_scale = $('#gallery_scale_images').val();

            active_module.attr('slider', the_slider);
            active_module.attr('scale_images', the_scale);
            this.slider = the_slider;
            this.scale = the_scale;


            $('#popup_module_gallery').hide();

            // clear the repo
            $('.repo_item_select').removeClass('selected');
            $('.repo_item_select').parent().removeClass('selected_item');

            popupElem.find('.popup_save_button').unbind('click')
            emptyPopupAndMessage(popupElem, parentModule)

          });





      });
    },


    getSaveData: function () {
      let parentModule = $('.newModuleParent[module_id=' + this.id + ']');
      let childModule = this.parentModule.find('.module');

      var ret = {
        type: 'gallery',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: parentModule.attr('id'),
        slider: parentModule.attr('slider'),
        scale_images: parentModule.attr('scale_images'),
      };

      return ret;
    },

    load: function (properties) {
      this.setText(properties.content);
      this.setMarginBottom(properties.margin_bottom);
      this.setMarginTop(properties.margin_top);
      this.setFontColor(properties.font_color);
      this.setFontSize(properties.font_size);
      this.setTextAlign(properties.align);
      this.setSidebarImage(properties.right_side_img);
      this.setSidebarText(properties.right_side_img_text);
    },
  };

  return new_elem;
}
