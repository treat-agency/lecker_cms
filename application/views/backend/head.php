<!-- peter -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
  <title>lecker CMS</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/reset.css"); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/fonts.css"); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/backend.css?ver=" . VERSION); ?>">

  <link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.css"); ?>">
  <!-- <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/jquery-ui.structure.css"); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/jquery-ui.theme.css"); ?>"> -->


    <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/_backend.css?ver=" . VERSION); ?>">

  <!-- // treatstart -->
  <link rel="icon" type="image/png" href="<?= site_url('items/frontend/img/logo/logo.png'); ?>">

    <!-- // CKEDITORstart -->

  <script src="<?= site_url("items/besc_crud/ck5/build/ckeditor_toolbar.js?ver=" . VERSION); ?>"></script>

    <script type="text/javascript" src="<?= site_url("items/besc_crud/ck5/build/ckeditor.js?ver=" . VERSION); ?>"></script>

        <!-- // CKEDITORstart -->


    <!-- // CKEDITORold -->


  <!-- <script type="text/javascript" src="<?= site_url("items/besc_crud/ckeditor/ckeditor.js?ver=" . VERSION); ?>"></script> -->


    <!-- // CKEDITORold -->



  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/select2.css?ver=" . VERSION); ?>">


  <!-- JS -->
  <script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-1.11.2.min.js"); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-ui.min.js"); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/backend/js/tinysort.js?"); ?>"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>

  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/TweenMax.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/utils/Draggable.min.js"></script>

  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js">
    </script>
  <script type="text/javascript" src="<?= site_url("items/backend/js/select2.min.js?"); ?>"></script>

    <script type="text/javascript" src="<?= site_url("items/backend/js/drag_and_drop.js?ver=" .time()); ?>"></script>



  <script type="text/javascript" src="<?= site_url("items/backend/js/backend.js?ver=" . VERSION); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/backend/js/_backend.js?ver=" .time()); ?>"></script>

  <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script> -->

  <?php if ($userdata->menu_type == 1) : ?>
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/menu1.css?ver=" . VERSION); ?>">
  <script type="text/javascript" src="<?= site_url("items/backend/js/menu1.js"); ?>"></script>

      <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/ckeditor.css?ver=" . VERSION); ?>">
  <?php endif; ?>


  <!-- VARIABLES -->
  <script type="text/javascript">
  var rootUrl = "<?= site_url(); ?>";
  const imgUpUrl = rootUrl  + 'items/backend/icons/iconArrowUp.svg'
  const imgDownUrl = rootUrl + 'items/backend/icons/iconArrowDown.svg';
  const imgEditIcon = rootUrl + 'items/backend/icons/editIcon.svg';
  const imgBinIcon = rootUrl + 'items/backend/icons/binIcon.svg';


  $(document).ready(function() {
    checkLoggedIn();
  });
  var MAIN_LANGUAGE = "<?= MAIN_LANGUAGE ?>";
  var SECOND_LANGUAGE = "<?= SECOND_LANGUAGE ?>";
  var NUMBER_OF_LANGUAGES = "<?= NUMBER_OF_LANGUAGES ?>";
  </script>

</head>

<body>





  <div id="widget_overlay">
    <div class="overlay_close">✕</div>
    <div class="overlay_content">
      <div class="content_h1">Add widget</div>
      <label for="category_select">Select the page you want to create a quicklink to.</label>
      <select name="category_select" id="category_select">
        <option value="Content">Content</option>
        <option value="Repository">Repository</option>
        <!--<option value="Settings">Settings</option>-->
      </select>

      <label for="Content_select">Select the section you want to create a quicklink to.</label>

      <select style="display:block;" class="sub_category" name="Content_select" id="Content_select">

        <option value="items">Articles</option>
        <option value="categories">Categories</option>
        <option value="calendar_tags">Calendar tags</option>
        <option value="Collection">Collection</option>
        <option value="menu">Menu</option>
        <option value="participants">Signups</option>
        <option value="slides">Slides</option>
        <option value="tags">Tags</option>
        <option value="opening_times">Opening times</option>
        <option value="closed_days">Closed days</option>
      </select>


      <select style="" class="sub_category" name="Repository_select" id="Repository_select">
        <option value="categories">Categories</option>
        <option value="items">Items</option>
      </select>




      <label for="icon_select">Select Color</label>
      <div id="color_select">
        <div class="color_select_item white_flag color_flag active" color="" style="background-color: white"></div>
        <?php foreach ($colors as $color) :
          if (isset($color->flag) && $color->flag == 1) { ?>

          <!-- <div class="color_select_item color_flag " color="<?= $color->name ?>"
            style="background-color: <?= $color->name ?>"></div> -->
          <?php }

				endforeach; ?>
      </div>

      <label for="note">Note</label>
      <textarea id="note" class="regular" placeholder="My note..."></textarea>
      <div id="add_widget">Add widget</div>
    </div>
  </div>





  <div id="reset_overlay">
    <div class="overlay_close">✕</div>
    <div class="overlay_title">Reset password</div>
    <div class="overlay_content">
      <label for="category_select">Are you sure you want to reset this users password and email a new one?</label>

      <div id="yes_reset">Yes</div>
      <div id="no_reset">No</div>
      <div id="reset_error">Please wait...</div>
    </div>
  </div>

  <div id="backend_container">
