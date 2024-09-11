$(document).ready(function () {
  /********** SCROLLING SAVE **********/
  goToLastScroll();

  function goToLastScroll() {
    setTimeout(function () {
      var lsElem = sessionStorage.getItem(window.location.href);
      if (lsElem > 100) {
        window.scrollTo(0, lsElem);
      }
    }, 1000);
  }

  // on scroll
  $(document).scroll(function () {
    sessionStorage.setItem(window.location.href, $('body').scrollTop());
  });

  $('.subMenuElem').on('click', function () {
    if ($(this).attr('pretty') == 'category/podcasts') {
      window.location.href = rootUrl + $(this).attr('pretty');
    } else if ($(this).attr('pretty') == 'category/shop') {
      window.location.href = rootUrl + $(this).attr('pretty');
    } else {
      $(this).parent().parent().parent().toggleClass('active');
    }
  });



  // get rid of additional pictures in slider with screenmode {

  var mobileWidth = $('.mobileElem').css('display') == 'block';

  if (mobileWidth) {
    $('.emptySlide').remove();
  }


  // OPEN AI

  $('#openai_form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);

    // console.log('ha');

    $.ajax({
      type: 'POST',
      url: rootUrl + 'Frontend/openai_controller',
      data: form.serialize(),
      success: function (data) {
        var json = JSON.parse(data);

        //   btn.show();
        // } else {
        //   $('#form').hide();
        // }
        if (json.success == true) {

          $('#openai_answer').html(json.answer).show();
        } else {
            $('#openai_answer').html("Something went wrong").show();

        }
      },
    });
  });



  //  MEDIA AND VIDEO CONTROLS



  // video play pause mute unmute

  $('.js-playPause').on('click', function () {
    var videoElem = $('#friesVideoElem').get(0);

    $(this)
      .children()
      .each(function () {
        if ($(this).hasClass('dn')) {
          $(this).removeClass('dn');
          videoElem.play();
        } else {
          $(this).addClass('dn');
          videoElem.pause();
        }
      });
  });

  $('.js-muteUnmute').on('click', function () {
    var videoElem = $('#friesVideoElem');

    $(this)
      .children()
      .each(function () {
        if ($(this).hasClass('dn')) {
          $(this).removeClass('dn');
          videoElem.prop('muted', 'muted');
        } else {
          $(this).addClass('dn');
          videoElem.prop('muted');
        }
      });
  });




  // slick slider

  // $('.gallSliderContainer').each(function() {

  //   let container = $(this);
  //   let slickElem = container.find('.gallSliderSlick')
  //   let slickArrows = container.find('.gallSliderArrows')
  //   let leftArrow = container.find('.js-gallSliderLeft')
  //   let rightArrow = container.find('.js-gallSliderRight')

  //   console.log(slickArrows)

  //   $('.gallSliderSlick').slick({
  //     infinite: false,
  //     slidesToShow: 1,
  //     slidesToScroll: 1,
  //     arrows: true,
  //     // appendArrows: slickArrows,
  //     prevArrow: leftArrow,
  //     nextArrow: rightArrow,
  //   })

  // })


    // let container = $(this);
    // let slickElem = container.find('.gallSliderSlick')
    // let slickArrows = container.find('.gallSliderArrows')
    // let leftArrow = container.find('.js-gallSliderLeft')
    // let rightArrow = container.find('.js-gallSliderRight')


    $('.gallSliderSlick').each(function() {

      let slickElem = $(this)
      let parentContainer = slickElem.closest('.gallSliderContainer')
      let leftArrow = parentContainer.find('.js-gallSliderLeft')
      let rightArrow = parentContainer.find('.js-gallSliderRight')

      slickElem.slick({
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: leftArrow,
        nextArrow: rightArrow,
      })

    })


  




  var $slickElement = $('.detailSlider');

  $slickElement.each(function () {
    var $status = $(this).parent().find('.slideCounter');
    var $arrowHolder = $(this).parent().find('.sliderArrowHolder');

    $(this).on(
      'init reInit afterChange',
      function (event, slick, currentSlide, nextSlide) {
        var i = (currentSlide ? currentSlide : 0) + 1;
        if ($('.mobileElem').css('display') == 'block') {
          $status.text(i + '/' + slick.slideCount);
        } else {
          $status.text(i + '/' + (slick.slideCount - 2));
        }

        if (slick.slideCount < 4 && $('.mobileElem').css('display') == 'none') {
          $arrowHolder.hide();
        }
      },
    );

    $(this).on('init reInit', function (slick, currentSlide) {
      $('.leftArrowClass').addClass('greyArrow');
    });

    $(this).on('afterChange', function (slick, currentSlide) {
      if (!mobileWidth) {
        if (currentSlide.currentSlide === 0 || currentSlide.slideCount <= 3) {
          $(this).parent().find('.leftArrowClass').addClass('greyArrow');
        } else {
          $(this).parent().find('.leftArrowClass').removeClass('greyArrow');
        }
      } else {
        if (currentSlide.currentSlide === 0) {
          $(this).parent().find('.leftArrowClass').addClass('greyArrow');
        } else {
          $(this).parent().find('.leftArrowClass').removeClass('greyArrow');
        }
      }

      if (!mobileWidth) {
        if (
          currentSlide.currentSlide === currentSlide.slideCount - 3 ||
          currentSlide.slideCount <= 3
        ) {
          $(this).parent().find('.rightArrowClass').addClass('greyArrow');
        } else {
          $(this).parent().find('.rightArrowClass').removeClass('greyArrow');
        }
      } else {
        if (currentSlide.currentSlide === currentSlide.slideCount - 1) {
          $(this).parent().find('.rightArrowClass').addClass('greyArrow');
        } else {
          $(this).parent().find('.rightArrowClass').removeClass('greyArrow');
        }
      }
    });
  });








});
