function new_module_event(id, parent) {
  var new_elem = {
    module: null,
    type: 'event',
    id: id,
    parent: parent,
    slider: 0,

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
        ' type="category" rel_id="0" class="module module_event has_placeholder" num_items="" slider="0" future_events="0" data-text="Event module" style="top: ' +
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

        var popupElem = $('#popup_module_events')

        var rel_id = active_module.attr('rel_id')
        var future_events = active_module.attr('future_events')
        var num_items = active_module.attr('num_items')

        $('#popup_edit_related_holder').empty()

        toggleRelatedListener(false)

        $('#event_tag_select').val(rel_id)
        $('#future_events').val(future_events)
        $('#event_item_number').val(num_items)

        toggleRelatedListener(true)


        $('#popup_module_events').show()

        $('#popup_module_events')
          .find('.popup_save_button')
          .click(function () {
            var sel_tag = $('#event_tag_select').val()
            var sel_tag_name = $('#event_tag_select option:selected').text()
            var fe = $('#future_events').val()
            var item_number = $('#event_item_number').val()
            active_module.empty()

            active_module.attr('future_events', fe)
            active_module.attr('rel_id', sel_tag)
            active_module.text('List: ' + sel_tag_name)
            active_module.attr('num_items', item_number)

            // position_tools(active_module)

            //$('#popup_module_gallery').hide();

            // clear the repo
            $('.repo_item_select').removeClass('selected')
            $('.repo_item_select').parent().removeClass('selected_item')
          })

        $('#popup_module_events')
          .find('.popup_cancel_button')
          .click(function () {
            $('#popup_module_events').hide()

            // clear the repo
            $('.repo_item_select').removeClass('selected')
            $('.repo_item_select').parent().removeClass('selected_item')
          })

        $('#popup_module_events')
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
            $('#popup_module_events').hide()

            // clear the repo
            $('.repo_item_select').removeClass('selected')
            $('.repo_item_select').parent().removeClass('selected_item')
          })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'event',
        rel_type: 'tag',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parentModule.attr('id'),

        rel_id: parentModule.attr('rel_id'),
        future_events: parentModule.attr('future_events'),
        num_items: parentModule.attr('num_items'),
      }

      return ret
    },

    load: function (properties) {
      this.setText(properties.content)
      this.setMarginBottom(properties.margin_bottom)
      this.setMarginTop(properties.margin_top)
      this.setFontColor(properties.font_color)
      this.setFontSize(properties.font_size)
      this.setTextAlign(properties.align)
      this.setSidebarImage(properties.right_side_img)
      this.setSidebarText(properties.right_side_img_text)
    },
  }

  return new_elem;
}
