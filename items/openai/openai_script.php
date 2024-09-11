<script>
$(document).ready(function () {

  ////////// INPUT DATA

  //// PROMPTS

  var prompts = <?= json_encode($prompts) ?>;

///LANGUAGLINES

  var langlines = <?= json_encode($langlines) ?>;


  ////////// LAUNCHER - o_button or o_question

  var launcher

if($('.questionHolder').length > 0) {

  console.log('wtf')

  launcher = $('.o_question');

} else { // input and buttons

  launcher = $('.o_button');

}

  ///////// LANGUAGE STUFF

  var language = <?= $preselected_language ?>; // coming from website language

  ///// STARTING LANGUAGE

  updateQuestionOrButton()
  updateLangesAndLanglines()

  // coming from language selector
  if($("#o_language").length > 0) {

        $("#o_language").select2();

        $("#o_language").change(function() {
          updateLangesAndLanglines()
          updateQuestionOrButton()
        });

  };


  var currentLanglines = getLanglines(language);


///////////// FUNCTIONS FOR LANGUAGE PROCESSING

//// LANGLINES UPDATE

  function updateLangesAndLanglines() {

        language = $("#o_language").length > 0 ? $("#o_language").val() : language;
        currentLanglines = getLanglines(language);

        // list of updated langlines
        $('#inputField').attr('placeholder', getOneLangline('ask'));
  };

  function getLanglines(lang) {
    newLanglines = langlines.filter(function(lang) {
      return lang.language == language;
    });

    return newLanglines;
  }


//// QUESSTION OR BUTTON UPDATE

  function updateQuestionOrButton() {

        launcher.each(function() {

          var topic = $(this).attr('topic');

          for (var i = 0; i < prompts.length; i++) {
            var prompt = prompts[i];

            if(prompt.topic == topic) {

              var translations = prompt.translations;

              for (var j = 0; j < translations.length; j++) {
                var translation = translations[j];

                if(translation.language == language) {
                  $(this).html(translation.question);
                }

              }

            }

          }


        });

    }

///////// GET ONE LANGLINE

  function getOneLangline(key) {
    var langline = currentLanglines.find(function(lang) {
      return lang.key == key;
    });

    return langline.translation;
  }

//////////////// SENDING AND RECEIVING DATA

launcher.each(function() {
  console.log('each')
    $(this).on('click', function() {

      var user_input = '';

    if($('#inputField').length > 0) {
      user_input = $('#inputField').val();
    }

        var topic = $(this).attr('topic');
        var chat_id = $(this).parent().attr('chat_id');

        // loading
        var loading_text_line = getOneLangline('loading');
        $('.response').html(loading_text_line);

        $.ajax({
            url: rootUrl + 'OpenaiController/startController', // replace with your URL
            type: 'POST',
            data: {  topic, language, chat_id, user_input },
            success: function(data) {

                var json = $.parseJSON(data);

                if(json.success == true) {

                    $('.response').html(json.response);

                    // additional updates

                    // var locations = json.used_locations;

                    // locations.forEach((location)  => {
                    //     $('.locationHolder').append('<div class="location">' + location + '</div>');
                    //   });


                } else {
                    $('.response').html("Something went wrong");
                }




            },
        });

    });

});


});
</script>