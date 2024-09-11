function new_module_newsletter(id, parent) {
  var new_elem = {
    module: null,
    type: 'newsletter',
    text: '',
    label_firstname: '',
    label_lastname: '',
    label_email: '',
    nl_type: '1008802',
    form_title: '',
    button_text: '',
    success_message: '',
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
      var html =
        '<div module_id="' +
        this.id +
        '" class="module module_newsletter" data-text="Newsletter module" button_text="" label_firstname="" label_lastname="" label_email="" form_title="" success_message="Newsletter signup success" list_type="1008802" style="top: ' +
        Math.ceil(resize_col(this.parent) / 10) * 10 +
        ';">' +
        '<div class="contact_title">Form title</div>' +
        '<form class="module_form" method="post">' +
        '<label class="module_contact_label"></label>' +
        '<input class="module_contact_input" type="text" name="firstname" placeholder="Firstname"/>' +
        '<label class="module_contact_label"></label>' +
        '<input class="module_contact_input" type="text" name="lastname" placeholder="Lastname"/>' +
        '<label class="module_contact_label"></label>' +
        '<input class="module_contact_input" type="text" name="email" placeholder="E-mail"/>' +
        '</form>' +
        '<div class="module_newsletter_send">SEND</div>' +
        '</div>'
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

        var popupElem = $('#popup_module_newsletter')


        popupElem.find('#newsletterLinkInput').val(active_module.attr('link'))
        
        $('.crud_tab_item[type="module_content"]').click()
        popupElem.show()

        $('#newsletter_firstname').val(active_module.attr('contact_firstname'))
        $('#newsletter_lastname').val(active_module.attr('contact_lastname'))
        $('#newsletter_email').val(active_module.attr('contact_email'))
        $('#newsletter_title').val(active_module.attr('contact_title'))
        $('#newsletter_button').val(active_module.attr('contact_button'))
        $('#nl_list_type').val(active_module.attr('list_type'))
        $('#newsletter_success').val(active_module.attr('success_message'))
        $('#newsletter_success').val(active_module.attr('link'))

        popupElem.find('.popup_save_button').click(function () {
          var the_first = $('#newsletter_firstname').val()
          var the_last = $('#newsletter_lastname').val()
          var the_email = $('#newsletter_email').val()
          var the_title = $('#newsletter_title').val()
          var the_button = $('#newsletter_button').val()
          var the_nl_type = $('#nl_list_type').val()
          var the_nl_success = $('#newsletter_success').val()

          active_module.attr('link', $('#newsletterLinkInput').val())

          active_module.attr('contact_firstname', the_first)
          active_module.attr('contact_lastname', the_last)
          active_module.attr('contact_email', the_email)
          active_module.attr('contact_title', the_title)
          active_module.attr('contact_button', the_button)
          active_module.attr('list_type', the_nl_type)
          active_module.attr('success_message', the_nl_success)

          this.label_firstname = the_first
          this.label_lastname = the_last
          this.label_email = the_email
          this.form_title = the_title
          this.button_text = the_button
          this.nl_type = the_nl_type
          this.success_message = the_nl_success

          active_module
            .find('.module_contact_input[name="firstname"]')
            .prev('label')
            .text(this.label_firstname)
          active_module
            .find('.module_contact_input[name="firstname"]')
            .attr('placeholder', this.label_firstname)

          active_module
            .find('.module_contact_input[name="firstname"]')
            .prev('label')
            .text(this.label_firstname)
          active_module
            .find('.module_contact_input[name="firstname"]')
            .attr('placeholder', this.label_firstname)

          active_module
            .find('.module_contact_input[name="lastname"]')
            .prev('label')
            .text(this.label_lastname)
          active_module
            .find('.module_contact_input[name="lastname"]')
            .attr('placeholder', this.label_lastname)

          active_module
            .find('.module_contact_input[name="email"]')
            .prev('label')
            .text(this.label_email)
          active_module
            .find('.module_contact_input[name="email"]')
            .attr('placeholder', this.label_email)

          active_module.find('.module_newsletter_send').text(this.button_text)
          active_module.find('.contact_title').text(this.form_title)

          popupElem.hide()
        })

        popupElem.find('.popup_cancel_button').click(function () {
          popupElem.hide()
        })

        popupElem.find('.popup_delete_button').click(function () {
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
          popupElem.hide()
        })
      })
    },

    getSaveData: function () {

      let parentModule = $('.newModuleParent[module_id=' + this.id + ']')
      let childModule = this.parentModule.find('.module')

      var ret = {
        type: 'newsletter',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        
        content: '',
        label_firstname: parentModule.attr('contact_firstname'),
        label_lastname: parentModule.attr('contact_lastname'),
        label_email: parentModule.attr('contact_email'),
        form_title: parentModule.attr('contact_title'),
        button_text: parentModule.attr('contact_button'),
        list_type: parentModule.attr('list_type'),
        success_message: parentModule.attr('success_message'),
        link: parentModule.attr('link'),
      }

      return ret
    },

    load: function (properties) {},
  }

  return new_elem;
}
