function new_module_dropdown(id, parent) {
  var new_elem = {
    module: null,
    type: 'dropdown',
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
      var html =
        '<div module_id=' +
        this.id +
        ' class="module module_dropdown has_placeholder" data-text="Enter Text here"  style="top: ' +
        Math.ceil(resize_col(this.parent) / 10) * 10 +
        ';"><div class="dropdown_module_title has_placeholder" data-text="Doubleclick here"></div><div class="dropdown_module_content"></div></div>'
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

        var popupElem = $('#popup_module_dropdown')

        $('#popup_module_dropdown').find('.popup_cancel_button').unbind('click')
        $('#popup_module_dropdown').find('.popup_save_button').unbind('click')
        $('#popup_module_dropdown').find('.popup_delete_button').unbind('click')


        $('#popup_module_dropdown')
          .find('.dropdown_module_title')
          .html(active_module.find('.dropdown_module_title').html())
        $('#popup_module_dropdown')
          .find('.dropdown_module_sub_title')
          .html(active_module.find('.dropdown_module_sub_title').html())
        $('#popup_module_dropdown')
          .find('.dropdown_module_content')
          .html(active_module.find('.dropdown_module_content').html())
        $('#popup_module_dropdown').show()

        $('#popup_module_dropdown')
          .find('textarea')
          .val(active_module.find('.dropdown_module_content').html())
        $('#popup_module_dropdown').find('#dropdown_title').val(active_module.attr('title'))
        $('#popup_module_dropdown').find('#dropdown_sub_title').val(active_module.attr('sub_title'))
        $('#popup_module_dropdown').show()

        $('#popup_module_dropdown')
          .find('.popup_save_button')
          .click(function () {
            var the_title = $('#popup_module_dropdown').find('#dropdown_title').val()
            var the_sub_title = $('#popup_module_dropdown').find('#dropdown_sub_title').val()
            active_module
              .find('.dropdown_module_content')
              .html(nl2br($('#popup_module_dropdown').find('textarea').val(), false))
            active_module.find('.dropdown_module_title').html(the_title)
            active_module.attr('title', the_title)
            active_module.find('.dropdown_module_sub_title').html(the_sub_title)
            active_module.attr('sub_title', the_sub_title)
            resize_col(active_module.parent())
            // position_tools(active_module)
            /* $("#popup_module_dropdown").hide();
            $("#popup_translate_holder").hide(); */
          })

        $('#popup_module_dropdown')
          .find('.popup_cancel_button')
          .click(function () {
            $('#popup_module_dropdown').hide()
            $('#popup_translate_holder').hide()
          })

        $('#popup_module_dropdown')
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
            $('#popup_module_dropdown').hide()
            $('#popup_translate_holder').hide()
          })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'dropdown',
        top: parseInt(this.module.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        content: parentModule.find('.dropdown_module_content').html(),
        title: this.module.attr('title'),
        sub_title: this.module.attr('sub_title'),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
