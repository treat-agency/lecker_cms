$(document).ready(function() {

  $('.js-latch').on('click', function () {
    $('#sidebar').toggleClass('inwindow')
    $('.overlayBlur').toggleClass('active')
  })

  $('.js-blackBarHam').on('click', function () {
    $('#blackBar').toggleClass('active')
  })

  $('.js-crudMover').on('click', function () {
    $('#crud_editor').toggleClass('inside')
  })
  





  // deleting a module

  $('#col_left').on('click', '.js-moduleDelete', function () {
    var parentModule = $(this).closest('.newModuleParent')
    parentModule.remove();

    // delete from modules array
    console.log(modules)
    modules = modules.filter((e) => e.id != parentModule.attr('module_id'))
    console.log(modules)

  })

  // moving the modules

  // $('.js-moduleUp').click(function () {
  $('#col_left').on('click', '.js-moduleUp', function () {
    var that = $(this).closest('.newModuleParent')
    var prev = that.prev('.newModuleParent')

    if (prev.length > 0) {
      that.detach().insertBefore(prev)
    }
  })

  // $('.js-moduleDown').click(function () {
  $('#col_left').on('click', '.js-moduleDown', function () {
    var that = $(this).closest('.newModuleParent')
    var next = that.next('.newModuleParent')

    console.log(that, next)

    if (next.length > 0) {
      that.detach().insertAfter(next)
    }
  })


  $('.js-downloadGroup').on('change', function() {
    $('.downloadGroup').hide();
    $(`.downloadGroup[type="${$(this).val()}"]`).show()

  })

  







  // new repo

     async function callSaveItem(module_type, item_id, module_id) {
       try {
         const result = await saveItem();

         module_id = module_id != "false" ? module_id : ""

         window.location.href =
           rootUrl +
             'entities/Content/repo_module/' +
             module_type +
             '/' +
             item_id +
             '/' +
             module_id;
       } catch (error) {
         console.error(error);
       }
     }


      $('.js-repoPopup').click(function () {

         var module_type = $(this).attr('module_type');
         var module_id = $(this).attr('module_id');
         var item_id = $("#item_container").attr("item_id");

         callSaveItem(module_type, item_id, module_id);
       });







  // $('.js-repoContainer').click(function () {

  //   $('.js-newRepoSelectAll').show();
  //   $('.js-newRepoSelect').removeClass('selected')

  //   var existing_image_ids = [];

  //   // exception for image module
  //   if ($(this).parents('#popup_module_image').length > 0) {
  //     $('.js-newRepoSelectAll').hide()

  //     existing_image_ids.push(
  //       $(this)
  //         .parents('#popup_module_image')
  //         .find('.imageTarget')
  //         .attr('repo_id'),
  //     );

  //   }

  //   console.log('errer')

  //   $('.js-newRepoSelect').each(function () {


  //       if (
  //         existing_image_ids.includes($(this).find('.newRepoImg').attr('iid'))
  //       ) {
  //         $(this).addClass('selected');
  //       }

  //     });


  //   $('#newRepoContainer').show()
  // })

  // $('.js-newRepoClose').click(function () {
  //   $('#newRepoContainer').hide()
  // })

  // $('.js-newRepoUpload').click(function () {
  //   $('#repo_upload_holder').show()
  // })

  // $('.js-newRepoSelect').click(function () {
  //   $(this).toggleClass('selected')



  // })

  // $('.js-newRepoSelectAll').click(function () {
  //   if($(this).hasClass('allSelected')) {
  //     $(this).removeClass('allSelected')
  //     $('.newRepoAllText').text('Select all')
  //     $('.newRepoElem').removeClass('selected')
  //   } else {
  //     $(this).addClass('allSelected')
  //     $('.newRepoAllText').text('Deselect all')
  //     $('.newRepoElem').addClass('selected')
  //   }
  // })





})