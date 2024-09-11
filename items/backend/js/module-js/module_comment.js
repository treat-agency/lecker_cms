function new_module_comment(id, parent) {
  var new_elem = {
    module: null,
    type: 'comment',
    text: '',
    id: id,
    parent: parent,
    prev_text: '',
    long_text: '',
    collapsable: 0,

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
        ' class="module module_comment has_placeholder" data-text="Text module"  style="top: ' +
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

        var popupElem = $('#popup_module_comment')


        popupElem.find('textarea').val(active_module.html())
        popupElem.find('#module_comment_previewtext_editor').val(active_module.attr('prev_text'))
        popupElem.find('#module_comment_longtext_editor').val(active_module.attr('long_text'))
        popupElem.find('#comment_collapsable_type').val(active_module.attr('collapsable'))
        
        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        popupElem.find('.popup_save_button').click(function () {
          active_module.html(nl2br(popupElem.find('textarea').val(), false))
          active_module.attr(
            'prev_text',
            popupElem.find('#module_comment_previewtext_editor').val()
          )
          active_module.attr('long_text', popupElem.find('#module_comment_longtext_editor').val())
          active_module.attr(
            'collapsable',
            popupElem.find('#comment_collapsable_type').find(':selected').val()
          )

          resize_col(active_module.parent())
          // position_tools(active_module)
          /*	$('#popup_module_text').hide();
					$('#popup_translate_holder').hide();*/
        })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'comment',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        prev_text: parentModule.attr('prev_text'),
        long_text: parentModule.attr('long_text'),
        collapsable: parentModule.attr('collapsable'),
        content: childModule.html(),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
