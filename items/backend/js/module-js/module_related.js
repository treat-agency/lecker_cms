function new_module_related(id, parent) {
  var new_elem = {
    module: null,
    type: 'related',
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
      var related_module_name = 'Article list:';
      var html =
        '<div module_id=' +
        this.id +
        ' type="tag" rel_id="0" class="module module_related has_placeholder" num_items="" slider="0" data-text="Related module" style="top: ' +
        Math.ceil(resize_col(this.parent) / 10) * 10 +
        ';">' +
        related_module_name +
        '<div class="related_holder"></div></div>';
      return html;
    },

    getPrototypeHTML: function () {
      let modNaming = 'Article list';
      let modClass = 'module_related';

      var stream = `<div module_id='${
        this.id
      }' type="tag" rel_id="0" num_items="" slider="0" top='${
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
      <div class='related_type'></div>
      <div class='related_holder'></div>
			</div>
		</div>`;

      return stream;
    },

    bindListeners: function () {

      this.editButton.click(function () {

        createModuleHelpers($(this), '#popup_module_related')

        // unbind
        popupElem.find('.popup_save_button').unbind('click')

        // var popupElem = $('#popup_edit_gallery_holder')

        var rel_id = active_module.attr('rel_id');
        var type = active_module.attr('type');
        var num_items = active_module.attr('num_items');

        var rel_id_array = rel_id.split(',');

        $('#related_' + type + '_select').val(rel_id_array);

        function handleSelect2(selector, values) {
          jQuery(selector).each(function () {
            var $this = jQuery(this);
            if ($this.attr('data-reorder')) {
              $this.on('select2:select', function (e) {
                var elm = e.params.data.element;
                $this.append(jQuery(elm));
                $this.trigger('change.select2');
              });
            }
            $this.select2();

            // Set the values in the specified order
            if (values) {
              values.forEach(function (value) {
                var option = $this.find('option[value="' + value + '"]');
                $this.append(option).trigger('change.select2');
              });
            }
          });
        }

        handleSelect2('#related_articles_select');
        handleSelect2('#related_tag_select');
        handleSelect2('#related_' + type + '_select', rel_id_array);

        $('.popup_edit').hide();

        $('.newModuleParent').find('.moduleEdit').removeClass('inverted');
        $(this).addClass('inverted');

        $('.related_add_article_button').hide();
        $('#popup_edit_related_holder').empty();

        toggleRelatedListener(false);

        $('#module_related_type').val(type);

        $('.relSelector').hide();
        $('.' + type + 'Selector').show();

        $('#related_item_number').val(num_items);

        toggleRelatedListener(true);

        $('#popup_module_related').show();

        $('#popup_module_related').find('.popup_save_button').click(function () {

            var type = $('#module_related_type').val();
            var items = $('#related_' + type + '_select option:selected');
            var item_number = $('#related_item_number').val();

            if (type == 'articles') {
              selected = $('#related_articles_select');
            } else if (type == 'tag') {
              selected = $('#related_tag_select');
            }


              selectedIds = selected.val();

                if (items.length == 0) {
                  selectedIds = 0;
                }

            active_module.attr('rel_id', selectedIds);

            active_module.find('.related_holder').empty();

            $(items).each(function () {
              var item = $(this);
              var elem =
                '<div class="relModelem module_related_item_front" style="position:relative">' +
                item.text() +
                '</div>';

              var related_holder = active_module.find('.related_holder');
              related_holder.append(elem);
            });

            var typeLabel = $('#module_related_type option:selected').text();

            active_module.find('.related_type').text(typeLabel);

            active_module.attr('type', type);
            active_module.attr('num_items', item_number);

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
        type: 'related',
        top: parseInt(parentModule.position().top),
        dbid: parentModule.attr('dbid'),
        column: this.parent.attr('id'),

        rel_id: parentModule.attr('rel_id'),
        rel_type: parentModule.attr('type'),
        num_items: parentModule.attr('num_items'),
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
