<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- seo_purpose -->
<html lang="<?= $page_language = isset($item) ? $item->lang : MAIN_LANGUAGE ?>" class="no-js">

<head>
  <meta id="vp" name="viewport" content="width=device-width, initial-scale=1 , user-scalable=yes">
  <meta name="description" content="<?= SITE_NAME ?>">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- seo_purpose start -->
  <!-- OG start -->
  <meta property="og:title" content="<?= $og_title ?>" />
  <meta property="og:image" content="<?= $og_img ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?= $og_url ?>" />
  <meta property="og:site_name" content="<?= SITE_NAME ?>" />
  <meta property="og:description" content="<?= $og_description ?>" />
  <!-- OG end -->

  <!-- SEO -->
  <? if (isset($other_language_article) && $other_language_article) : ?>
    <link rel="alternate" hreflang="<?= $other_language_article->lang  ?>" href="<?= site_url() . $other_language_article->pretty_url ?>" />
  <? endif; ?>

  <link rel="canonical" href="<?= $canonical ?>" />

  <!-- seo_purpose end -->

  <title><?= (isset($page_title)) ? $page_title :  SITE_NAME; ?></title>
  <meta name="description" content="<?= $seo_description ?>">


  <!-- FAVICON -->
  <!-- // treatstart -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= site_url() . 'items/frontend/icons/favicon/apple-touch-icon.png' ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url() . 'items/frontend/icons/favicon/favicon-32x32.png' ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= site_url() . 'items/frontend/icons/favicon/favicon-16x16.png' ?>">
  <!-- <link rel="manifest" href="<?= site_url() . 'items/frontend/icons/favicon/site.webmanifest' ?>"> -->
  <link rel="mask-icon" href="<?= site_url() . 'items/frontend/icons/favicon/safari-pinned-tab.svg' ?>" color="#000000">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">


  <!-- CSS / LIBRARIES -->
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/general/css/jquery-ui.css'); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/general/css/lightbox.css'); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/libraries/slick.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/libraries/select2.min.css'); ?>" />


  <!-- CSS / CUSTOM -->
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/frontend/css/fonts.css?ver=") . time(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_vars.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_basic.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_navigation.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_footer.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_general.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_forms.css?ver=') . time(); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?= site_url('items/frontend/css/_mobile.css?ver=') . time(); ?>" media="all" />


  <!-- JS / LIBRARIES -->
  <script src="<?= site_url("items/general/js/libraries/jquery-1.11.3.min.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/jquery-ui.min.js"); ?>"></script>
  <!-- <script src="<?= site_url("items/frontend/js/libraries/packery.pkgd.min.js"); ?>"></script> -->
  <script src="<?= site_url("items/general/js/libraries/jquery-touch-punch.js"); ?>"></script>
  <!-- <script src="<?= site_url("items/frontend/js/libraries/masonry.js"); ?>"></script> -->
  <script src="<?= site_url("items/frontend/js/libraries/placeholders.min.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/lightbox.js"); ?>"></script>
  <!-- <script src="<?= site_url("items/frontend/js/libraries/dat.gui.min.js"); ?>"></script> -->
  <!-- <script src="<?= site_url("items/general/js/libraries/hammer.min.js"); ?>"></script> -->
  <script src="<?= site_url("items/general/js/libraries/jquery.hammer.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/jquery.mousewheel.min.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/imgViewer.js?ver=4"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/jquery.lazy.min.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/jquery.lazy.plugins.min.js"); ?>"></script>
  <script src="<?= site_url("items/general/js/libraries/select2.min.js"); ?>"></script>
  <script src="<?= site_url("items/frontend/js/libraries/slick.min.js"); ?>"></script>
  <!-- <script src="<?= site_url("items/frontend/js/libraries/gsap.min.js"); ?>"></script> -->
  <!-- <script src="<?= site_url("items/frontend/js/libraries/scrolltrigger.min.js"); ?>"></script> -->


  <!-- JS / CUSTOM -->
  <script src="<?= site_url("items/frontend/js/_listeners.js?ver=") . time(); ?>"></script>
  <script src="<?= site_url("items/frontend/js/desktop.js?ver=") . time(); ?>"></script>
  <!-- <script src="<?= site_url("items/frontend/js/_search.js?ver=") . time(); ?>"></script> -->
  <!-- <script src="<?= site_url("items/frontend/js/shop.js?ver=") . time(); ?>"></script> -->

  <script>
    var rootUrl = '<?= site_url() ?>';
    var lang = '<?= $lang ?>';
  </script>



<!-- GTAG -->
<? include(APPPATH . 'views/frontend/' . "gtag.php"); ?>
<!-- GTAG END -->

</head>








<body>

<!-- COOKIE -->
<? include(APPPATH . 'views/frontend/' . "cookie.php"); ?>
<!-- COOKIE END -->



  <div class="hamOverlay">


    <div class="hamMenuWrapper">

      <div class="hamMenuPoint">
        <a href='<?= base_url() ?>'>

          <!-- // treat start -->
          <div class="hamMenuPointText">
            <img src="<?= site_url('items/frontend/icons/logo/treat_logo_2023.svg') ?>" alt='Logo' class='logo' width="250" />
          </div>
        </a>
      </div>

      <div class="hamMenuPoint">
        <a href='<?= site_url('/ueber') ?>'>
          <div class="hamMenuPointText">
            <div>Text</div>
          </div>
        </a>
      </div>

      <div class="hamMenuPoint">
        <a href="<?= site_url('/anwendung') ?>">
          <div class="hamMenuPointText">
            <div>Text</div>
          </div>
        </a>
      </div>

      <div class="hamMenuPoint inline">
        <div <? if ($this->language == MAIN_LANGUAGE) : ?> class='lang_btn hamMenuPointText
          lang_btnActive' <? else : ?> class='lang_btn lang_btnInactive hamMenuPointText' <? endif; ?> lang="<?= MAIN_LANGUAGE ?>">DE
        </div>
        <div class='hamMenuPointText'> | </div>
        <div <? if ($this->language == SECOND_LANGUAGE) : ?> class='lang_btn hamMenuPointText
          lang_btnActive' <? else : ?> class='lang_btn lang_btnInactive hamMenuPointText' <? endif; ?> accesskey="" lang="<?= SECOND_LANGUAGE ?>">EN
        </div>
      </div>

    </div>
  </div>
  <!-- hamburger menu end -->

  <!-- mainNavigation start -->

  <header>
    <nav class='mainNavigation' style="position:relative">

      <div class='leftNav'>
        <a href='<?= base_url() ?>'><img class="treatLogo" src="https://treat.agency/items/frontend/img/logo/treat_logo_2023.svg" alt='' class='' /></a>
      </div>

      <div class="rightNav">


        <!-- SHOPSTUFF -->
        <!-- <a href="<?= site_url('shopping_cart'); ?>">
          <div id="cart_holder">
            <img id="cart_img" src="" />
            <div id="cart_num"></div>
          </div>
        </a>

        <?php if (!$user) : ?>
          <div id="menu_login">LOGIN</div>
        <?php else : ?>
          <div id="menu_user">Logged in as: <?= $user->email ?></div>
          <div id="menu_logout">LOGOUT</div>
        <?php endif; ?> -->
        <!-- SHOPSTUFF END-->

        <div <? if ($this->language == MAIN_LANGUAGE) : ?> class='lang_btn
          lang_btnActive' <? else : ?> class='lang_btn lang_btnInactive' <? endif; ?> lang="<?= MAIN_LANGUAGE ?>">DE
        </div>
        <div <? if ($this->language == SECOND_LANGUAGE) : ?> class='lang_btn
          lang_btnActive' <? else : ?> class='lang_btn lang_btnInactive' <? endif; ?> accesskey="" lang="<?= SECOND_LANGUAGE ?>">EN
        </div>

        <div class='sandwichElement'></div>
      </div>
      </div>
    </nav>
  </header>








  <div id="container" style="">
