<? if(!isset($type)): ?>
<div class="bcTitle">Images</div>
<? endif; ?>

<!-- Stylesheets -->

<link rel="stylesheet" type="text/css" href="<?= site_url("items/besc_crud/css/crud_edit.css?ver=" .time()); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/imgareaselect-default.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/repository_overview.css?ver=" .time()); ?>">

<!-- Scripts -->

<script>

var COUNT_LOADED_IMAGES = <?= COUNT_LOADED_IMAGES ?>;
var rootUrl = "<?= site_url() ?>";
var repoController = "repository_overview"

</script>

<? if(isset($multiple)): ?>
<script>
var multiple = <?= $multiple ? 'true' : 'false' ?>;
</script>
<? endif; ?>

<? if(isset($type) && $type): ?>
<script>
repoController = "teaser_selector";
var entity_id = '<?= $entity->id ?>';
var type = '<?= $type ?>';
var has_article = '<?= $has_article ?>';
</script>

<? endif; ?>

<? if (isset($module_type) && $module_type): ?>
  <!-- true -->

  <script>

  repoController = "repo_module";
  var module_item_id = '<?= $module_item_id ?>';
  var module_type = '<?= $module_type ?>';
  var module_id = '<?= $module_id ?>';
  </script>

<? endif; ?>

<script>
console.log("repoController", repoController)



</script>

<script type="text/javascript" src="<?= site_url("items/backend/js/repo.js?ver=" . VERSION); ?>"></script>
<!-- <script type="text/javascript" src="<?= site_url("items/backend/js/jquery.imgareaselect.min.js"); ?>"></script> -->
<script type="text/javascript" src="<?= site_url("items/backend/js/repository_overview.js?ver=") . time(); ?>"></script>



<!-- container that holds all repo elements -->
<div class="bigRepoContainer">


    <?
    // include(APPPATH . 'views/backend/' . "steps.php");
    ?>

  <div class="repoContentWithoutBar">




<div id="files_relation_container">

  <div id="repo_overlay" class='no_scrollbar'>
    <div id="current">
      <!-- <div class="content_h1" style="border:0px;">Image repository</div> -->
      <div id='repo_filters_container' >

        <div class="repoToolbox">

          <div class="buttonRepo ui-rounded2 invertHover" id="show_upload3">
            <img class="iconRepo" src="<?= site_url('items/backend/icons/uploadIcon.svg') ?>">
            <div class="textRepoButton" >upload image</div>
          </div>

          <div class="buttonRepo ui-rounded2 invertHover" id="filterForRepo" style="display: none">
              <img class="iconRepo" src="<?= site_url('items/backend/img/filter.png') ?>">
              <div  class="customizeImages textRepoButton">filter</div>
          </div>

          <!-- repofilter -->
          <div class="buttonRepo js-moreRepoElems">
            <div class="df ui-rounded1">
                <div  class="customizeImages textRepoButton">load more</div>
                <div  class="customizeImages currentRepoButton"><?= " " . COUNT_LOADED_IMAGES ?></div>
                <div  class="customizeImages">/</div>
                <div  class="customizeImages countRepoButton"><?= $repo_total ?></div>
              </div>
          </div>

          <!-- keep -->

    <?   if(isset($customize_selected)): ?>

          <div class="buttonRepo ui-rounded2 selectAllImages invertHover">
                  <div class="textRepoButton">select all</div>
        </div>

        <div class="buttonRepo ui-rounded2 invertHover" id="show_edit_repo">
            <div  class="customizeImages textRepoButton">customize selected</div>
         </div>
        <div class="buttonRepo ui-rounded2 invertHover" id="download_zip">
            <div  class="customizeImages textRepoButton">download selected</div>
         </div>
         <? endif ?>

        </div>



        <div id="repo_filters">



          <div class="select2CustomHolder">

            <img class="iconRepo" src="<?= site_url('items/backend/icons/gridIcon.svg') ?>">
            <select name="repo_category" id="repo_category">
              <option value="0">all categories</option>
              <?php foreach ($repo_categories as $cat): ?>
                <option <?= isset($category) && $category == $cat->id ? 'selected' : '' ?> value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
              <?php endforeach; ?>
            </select>

          </div>


          <div class="select2CustomHolder">

            <img class="iconRepo" src="<?= site_url('items/backend/icons/tagIcon.svg') ?>">
            <select name="repo_tag" id="repo_tag">
              <option value="0">all tags</option>
              <?php foreach ($repo_tags as $t): ?>
                  <option <?= isset($tag) && $tag == $t->id ? 'selected' : '' ?> value="<?= $t->id; ?>"><?= $t->name; ?></option>
              <?php endforeach; ?>
            </select>

          </div>


          <div class="select2CustomHolder">

            <select name="repo_date_added" id="repo_date_added">
                <option value="0">all dates uploaded</option>
                <?php foreach ($date_added_selector as $date): ?>
                    <option <?= isset($date_added) && $date_added == $date ? 'selected' : '' ?> accesskey="" value="<?= $date; ?>"><?= $date; ?></option>
                <?php endforeach; ?>
            </select>

          </div>


          <div class="select2CustomHolder">

            <div id="sort_select">
              <select name="repo_sort_type" id="repo_sort_type">
                <option <?= isset($sort) && $sort == 'asc' ? 'selected' : '' ?> value="asc">ascending</option>
                <option <?= isset($sort) && $sort == 'desc' ? 'selected' : '' ?> value="desc">descending</option>
              </select>
            </div>
          </div>

          <!-- reset button -->
          <div class="select2CustomHolder">

            <div class="buttonRepo js-resetFilter filterResetButton">
                <div class="customizeImages">reset filter</div>
            </div>
          </div>

          <!-- search input -->
          <div class="select2CustomHolder">

            <div id="name_search" class="searchHolder buttonRepo">
              <img class="iconRepo" id="search_icon"  data-name="Ebene 1" src="<?= site_url('items/backend/icons/lupeIcon.svg') ?>">
              <input type="text" name="repo_name_search" id="repo_name_search" <?= isset($text) && $text != '' ? 'value="' . $text . '"' : '' ?> placeholder="Search..." />
            </div>
          </div>



      </div>

    </div>
  </div>


  </div>
  </div>

  <? include(APPPATH . 'views/backend/' . "repo_upload.php"); ?>

  <div id="repo_edit_overlay" style="opacity: 0.6;">

</div>

  <div id="repo_edit_holder">
    <div id="repo_edit_details">
      <br>
      <br>
      <div class="">Add following attributes to selected:</div>
      <br>
      <div class="">Please note, that existing information won’t be changed.</div>
      <img id="close_repo_upload2" src="<?= site_url('items/backend/img/x.svg') ?>" />


      <form id="repo_customize_form" method="post">

        <br />
        Add Tag: <select name="image_tag" id="image_tag2" placeholder="">
          <option value="">all tags</option>
          <?php foreach ($repo_tags as $tag): ?>
              <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
          <?php endforeach; ?>
        </select><br />
        <br />
        Remove Tag: <select name="image_tag_remove" id="image_tag2_remove" placeholder="">
          <option value="">all tags</option>
          <?php foreach ($repo_tags as $tag): ?>
                <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
          <?php endforeach; ?>
        </select><br />
        <br />

        <input type="checkbox" name="image_delete" style="width: unset;position: relative;display: inline-block;top: 1px;">
      <label for="image_delete" style="display: inline-block;margin: 20px 0 0px 5px;">delete</label>
        <br />

        <input checked type="checkbox" name="image_public"
          style="width: unset;position: relative;display: inline-block;top: 1px;">
        <label for="image_public" style="display: inline-block;margin: 20px 0 0px 5px;">public</label>
        <br />
        <br />

        <div class="buttonRepoSmall ui-rounded2 invertHover" id="repo_customize" >
          <div  class="textRepoButton">save</div>
        </div>

      </form>
    </div>
  </div>

  <div id="repo_content">



      <div id="repo_container" class="repoContainerA" loading="lazy" >

      <? foreach ($repository_images as $key => $img): ?>

        <? if ($key < $display_number): ?>
          <? include(APPPATH . 'views/backend/repository_item.php') ?>
        <? endif ?>

      <? endforeach; ?>
    </div>



<!-- ???? -->
       <? if (isset($images)): ?>


        <!-- only for teaser_selector -->
        <style>
          #repo_content {
            height: calc(100vh - 170px);
          }

          #repo_container {
            overflow: scroll;
          }

          #current_image_holder {
            height: calc(100vh - 320px)
          }

        </style>

              <div class="current_holder">
                <div id="close_repo_back"
                <? if(isset($module_type)): ?>
                  module_type="<?= $module_type ?>"
                <? endif; ?>
                class="ui-rounded2 invertHover">DONE</div>
                <div class="current">Selected Images:</div><br />


                <div id="current_image_holder">


                  <?php if (count($images) > 0):
                    foreach ($images as $image): ?>

                          <div class="selected_image" repo_id="<?= $image->id ?>"
                          ordering="<?= isset($image->ordering) ? $image->ordering : '1' ?>"

                          <? if(isset($module_type) && $module_type): ?>
                            module_item_id="<?= $module_item_id ?>"
                            module_type="<?= $module_type ?>"
                            module_id="<?= $module_id ?>"
                          <? else: ?>
                            has_article="<?= $has_article ?>"
                            type="<?= $type ?>"
                          <? endif ?>

                          >

                            <div class="repoImgAndDesc">

                              <div class="repoCurrentImgWrapper">
                                <img class="current_img <?= $image->public != 1 ? 'unPublicImage' : '' ?>" src="<?= $image->img_path ?>" />
                              </div>


                              <? if(isset($module_type) && $module_type): ?>
                              <div class="repoDescriptionHolder">
                                <textarea rows="4" cols="50"><?= $image->specialDescription; ?></textarea>
                              </div>
                              <? endif; ?>

                            </div>


                            <div class="remove_upload ui-rounded1 <?= isset($module_type) ? 'js-removeModuleRepo' : '' ?>"
                            <? if(isset($type) && $type): ?>
                            has_article="<?= $has_article ?>" type="<?= $type ?>"
                            <? endif ?>
                            >Remove</div>

                          </div>

                      <?php endforeach; ?>
                  <? endif; ?>

                </div>


              </div>


      <? endif ?>



  </div>

</div>
</div>







<script>
$(document).ready(function() {



  $('#repo_container').on('scroll', function() {
    lazy_load_start();
  })

  setTimeout(function() {
    lazy_load_start();
  }, 300);



  var edit_timer;
  $('#repo_content').on('mouseenter click', '.repo_img', function() {
    clearTimeout(edit_timer);
    var item = $(this).parent();
    if (!item.hasClass('edit_item')) {
      edit_timer = setTimeout(function() {
        item.addClass('edit_item');
        console.log('edit_item');
      }, 2000);
    };

  });

  $('#repo_content').on('mouseleave', '.repo_img', function() {
    $('.edit_item').removeClass('edit_item');
    clearTimeout(edit_timer);
  });

})
</script>