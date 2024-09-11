function new_module_shop(id, parent) {
  var new_elem = {
    module: null,
    type: 'shop',
    text: '',
    id: id,
    parent: parent,
    shop_item: null,

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
      var html =
        '<div sid="" shoptext="" module_id=' +
        this.id +
        ' class="module module_shop has_placeholder" data-text="Enter item text here"  style="top: ' +
        Math.ceil(resize_col(this.parent) / 10) * 10 +
        ';"></div>'
      return html
    },

    bindListeners: function () {

      this.editButton.click(function () {

        $('.popup_edit').hide()

        $('.newModuleParent').find('.moduleEdit').removeClass('inverted')
        $(this).addClass('inverted')

        let parentModule = $(this).closest('.newModuleParent')
        let childModule = parentModule.find('.module')
        active_module = parentModule

        var popupElem = $('#popup_module_shop')

        $('#popup_module_shop').find('.popup_cancel_button').unbind('click')
        $('#popup_module_shop').find('.popup_save_button').unbind('click')
        $('#popup_module_shop').find('.popup_delete_button').unbind('click')

        $('#shop_text').val(active_module.attr('shoptext'))
        $('#shop_item_select option[value="' + active_module.attr('sid') + '"]').prop(
          'selected',
          true
        )

        $('#popup_module_shop').show()

        $('#popup_module_shop')
          .find('.popup_save_button')
          .click(function () {
            //active_module.html(nl2br($('#popup_module_shop').find('textarea').val(), false));
            active_module.attr('shoptext', $('#shop_text').val())
            active_module.attr('sid', $('#shop_item_select').val())
            active_module.text($('#shop_text').val())
            resize_col(active_module.parent())
            $('#popup_module_shop').hide()
          })

        $('#popup_module_shop')
          .find('.popup_cancel_button')
          .click(function () {
            $('#popup_module_shop').hide()
          })

        $('#popup_module_shop')
          .find('.popup_delete_button')
          .click(function () {
            var parent = active_module.parent()
            var mod_id = active_module.attr('module_id')

            for (var i = 0; i < modules.length; i++) {
              if (modules[i] !== undefined) {
                if (modules[i].id == mod_id) {
                  modules.splice(i, 1)
                  break
                }
              }
            }
            active_module.remove()

            resize_col(parent)
            $('#popup_module_shop').hide()
          })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'shop',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        
        text: parentModule.attr('shoptext'),
        shop_item: parentModule.attr('sid'),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
