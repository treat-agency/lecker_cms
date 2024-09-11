var bc_message_phasing = 200;
var bc_message_id = 0;
var bc_message_lingering = 4000;

$(document).ready(function () {
  bc_positionMessageContainer();

  controlled_elements();
});

function bc_positionMessageContainer() {
  /*var parent = $('.bc_message_container').parent();
	var width = parent.width() + parseInt(parent.css('margin-left')) + parseInt(parent.css('margin-right')) + parseInt(parent.css('padding-left')) + parseInt(parent.css('padding-right'));
	$('.bc_message_container').css({'left': parent.position().left, 'top': parent.position().top, 'width': width});*/
}

// handling controlled elements
function controlled_elements() {
  $('[controlling_element]').each(function () {
    var controlled_elements = $(this).attr('controlling_element');
    var controlled_element_id = $(this).val();
    show_controlled_elements(controlled_elements, controlled_element_id);
  });

  $('[controlling_element]').change(function () {
    var controlled_elements = $(this).attr('controlling_element');
    var controlled_element_id = $(this).val();
    show_controlled_elements(controlled_elements, controlled_element_id);
  });
}

function show_controlled_elements(controlled_by, controlled_id) {
  /* $('[controlled_by="' +controlled_by +'"] select, [controlled_by="' +controlled_by +'"] input').val(""); */
  $('[controlled_by="' + controlled_by + '"]').slideUp();

  $(
    '[controlled_by="' +
      controlled_by +
      '"][controlled_id="' +
      controlled_id +
      '"]',
  ).slideDown();
}

function showMessage(type, message) {
  switch (type) {
    case 'error':
      var bg_class = 'bc_message_error';
      break;
    case 'success':
      var bg_class = 'bc_message_success';
      break;
  }

  $('.bc_message_container').prepend(
    '<div bc_message_id="' +
      bc_message_id +
      '" class="bc_message ' +
      bg_class +
      '">' +
      message +
      '</div>',
  );

  $('.bc_message[bc_message_id="' + bc_message_id + '"]').animate(
    { 'line-height': 40 },
    bc_message_phasing,
    function () {
      $(this).click(function () {
        $(this).animate({ 'line-height': 0 }, bc_message_phasing, function () {
          $(this).remove();
        });
      });
      setTimeoutMessageDisappear($(this));
    },
  );
  bc_message_id++;
}
