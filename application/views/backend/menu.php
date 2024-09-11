<div id="messagecontainer"></div>



<div id="menu" class="">

      <div id="side_menu_bg">

      </div>


      <div class="menuLeft df">

        <div class="menuOpener js-opener">
          <div class="menuDot"></div>
          <div class="menuDot"></div>
          <div class="menuDot"></div>
          <div class="menuDot"></div>
        </div>


      <a href="<?= site_url('backend') ?>">
        <div class="leckerLogo imgContain">
          <img id="lecker_logo_black" class="lecker_logo desktop_menu_item"
            src="<?= site_url('items/backend/logo/lecker2024.svg') ?>" alt="">
          <!-- <img id="lecker_logo_white" class="lecker_logo side_menu_element"
          src="<?= site_url('items/backend/img/logo/logo_white.svg') ?>" alt=""> -->
        </div>
      </a>

      </div>



  <!-- menu and search field -->
  <!-- <div class="menu_middle regular">
    <div id="menu_btn" class="menu_item desktop_menu_item">
      <img class="menu_item_icon" src="<?= site_url('items/backend/img/icon_menu.svg') ?>" alt="">
      Menu
    </div>

    <a class="menu_item desktop_menu_item" href="<?= site_url('Authentication/usersettings') ?>">
      <img class="menu_item_icon rotate" src="<?= site_url('items/backend/img/icon_settings.svg') ?>" alt="">
      Settings
    </a>

  </div> -->

  <!-- log out and side menu close btn -->

    <!-- <div class="menu_right regular desktop_menu_item"> -->
    <div class="menuRight">

      <div>
        <a class="menu_item desktop_menu_item" href="<?= site_url('Authentication/usersettings') ?>">
          <!-- <img class="menu_item_icon rotate" src="<?= site_url('items/backend/img/icon_settings.svg') ?>" alt=""> -->
          Settings
        </a>
      </div>

      <div>
        Logged in as
        <span class="bold">
            <a href="<?= site_url('Authentication/usersettings') ?>">
              <?= $username ?>
            </a>
        </span>
      </div>

      <div>
        <a id="logout" class="" href="<?= site_url('Authentication/logout') ?>">
          Log out
        </a>
      </div>

    </div>

</div>



<?
  if(isset($typeName)):
  include(APPPATH . 'views/backend/' . "steps.php");
endif;
?>




<div id="sidebar">

  <div class="latch js-latch">
    <div class="latchArrow">
      <span class="arrow_down"></span>
    </div>
  </div>

  <div class="menuVertical">
    <div>M</div>
    <div>E</div>
    <div>N</div>
    <div>U</div>
  </div>


  <div class="innerSidebar">


    <div id="menu_list">


      <!-- ********************* START ********************* -->



      <!-- ********************* DEV AREA ********************* -->


      <!-- DEV -->
      <? if ($dev != 0): ?>


      <fieldset class='dev_fieldset'>
        <div class="sidebar_headline semibold active" menu="dev_area">
          <span class="headline_text">
            Dev Area
          </span>


          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
        </div>

        </div>



        <div class="sidebar_itemcontainer" menu="dev_area">

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/items') ?>">Articles</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/translations') ?>">Translations</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/constants') ?>">Constants</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/error_log') ?>">Error Log</a>
          </div>


        </div>
      </div>


      <!-- ********************* TAGS & CATEGORIES ********************* -->

      <fieldset>

      <div class="sidebar_headline semibold active" menu="tags">
        <span class="headline_text">
          Tags & Categories
        </span>

        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer open" menu="tags">




        <div class="sidebar_menuitem" style="">
          <a href="<?= site_url('entities/Content/normal_tags') ?>">Special Standard Article Tags</a>
        </div>


        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/tags') ?>">Tags</a>
        </div>
      </div>

    </fieldset>


    <? if (IS_SHOP == 1): ?>

    <!-- *************/////////////////******** SHOP STARTS ********/////////////////////************* -->

    <!-- ********************* PRODUCTS ********************* -->
    <fieldset>
      <legend class="shop_fieldset">Shop</legend>



      <div class="sidebar_headline semibold active" menu="products">
        <span class="headline_text">
          Products
        </span>

        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer open" menu="products">

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/products') ?>">Products</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/product_categories') ?>">Product Categories</a>
        </div>


        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/product_tags') ?>">Product Tags</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/product_versions') ?>">Product Versions</a>
        </div>

      </div>


      <!-- ********************* ORDERS ********************* -->

      <div class="sidebar_headline semibold active" menu="orders">
        <span class="headline_text">
          Orders
        </span>

        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer open" menu="orders">
        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/orders') ?>">Orders</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/ordered_products') ?>">Ordered Products</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/order_notes') ?>">Order Notes</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/taxes') ?>">Taxes</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/vouchers') ?>">Vouchers</a>
        </div>


      </div>

      <!-- ********************* CUSTOMERS ********************* -->

      <div class="sidebar_headline semibold active" menu="customer_data">
        <span class="headline_text">
          Customers
        </span>

        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer open" menu="customer_data">
        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/customers') ?>">Customers</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/favorites') ?>">Favorites</a>
        </div>

      </div>

    </fieldset>
    <!-- *************/////////////////******** SHOP ENDS ********/////////////////////************* -->

    <? endif ?>

    <!-- ********************* CONTENT / META SETTINGS ********************* -->

    <fieldset class='general_fieldset'>
      <legend>
        General
      </legend>

      <div class="sidebar_headline semibold active" menu="content">
        <span class="headline_text">
          Meta
        </span>

        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer open" menu="content">


        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/main_menu') ?>">Menu</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/page_settings/edit/1') ?>">Page settings</a>
        </div>

        <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/languages') ?>">Languages</a>
        </div> -->

        <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/colors') ?>">Colors</a>
        </div> -->
<!--
        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/searches') ?>">Search Terms</a>
        </div> -->



      </div>



      <!-- ********************* USERS ********************* -->


      <div class="sidebar_headline semibold active " menu="users">
        <span class="headline_text">
          Users
        </span>

        <span class="arrow_down"></span>
      </div>
      <div class="sidebar_itemcontainer" menu="users">

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Users/items') ?>">CMS Users</a>
        </div>
      </div>

    </fieldset>


    <!-- ********************* REPOSITORIES ********************* -->

    <fieldset class='repositories_fieldset'>
      <legend>
        Repositories
      </legend>

      <!-- IMAGEES -->
      <div class="sidebar_headline semibold active " menu="image_repository">
        <span class="headline_text">
          Image Repository
        </span>

        <span class="arrow_down"></span>
      </div>
      <div class="sidebar_itemcontainer" menu="image_repository">

        <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Repository/items') ?>">Images</a>
        </div> -->
        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/repository_overview') ?>">Images Overview</a>
        </div>


        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Repository/tags') ?>">Image Tags</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Repository/categories') ?>">Image Categories</a>
        </div>
      </div>

      <!-- FILES -->

      <div class="sidebar_headline semibold active " menu="file_repository">
        <span class="headline_text">
          File Repository
        </span>
        <span class="arrow_down"></span>
      </div>

      <div class="sidebar_itemcontainer" menu="file_repository">


        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/files') ?>">Files</a>
        </div>
        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/file_tags') ?>">File tags</a>
        </div>
      </div>
    </fieldset>


    <!-- //copy_openai -->
      <!-- ********************* OPENAI ********************* -->


      <!-- <fieldset class='openai_fieldset'>

      <div class="sidebar_headline semibold active" menu="openai">
        <span class="headline_text">
          Openai
        </span>

        <span class="arrow_down"></span>
      </div>



    <div class="sidebar_itemcontainer" menu="openai">

            <div class="sidebar_menuitem">
        <a href="<?= site_url('entities/Content/openai_chat_log') ?>">Chats</a>
      </div>
           <div class="sidebar_menuitem">
        <a href="<?= site_url('entities/Content/openai_prompts') ?>">Prompts</a>
      </div>
      <div class="sidebar_menuitem">
        <a href="<?= site_url('entities/Content/openai_debug') ?>">Debug</a>
      </div>
           <div class="sidebar_menuitem">
        <a href="<?= site_url('entities/Content/openai_question_translations') ?>">Question Translations</a>
      </div>
=======


      </fieldset> -->

      <? endif ?>


      <!-- ********************* ENTITIES ********************* -->
      <fieldset class='content_fieldset'>
        <legend>
          Content
        </legend>


        <div class="sidebar_headline semibold active" menu="entities">
          <span class="headline_text">
            <a href="<?= site_url('entities/Content/normals') ?>">
              <div class="sidebar_menuitem">
                  Standard Articles
                </div>
            </a>
          </span>
        </div>

        <div class="sidebar_itemcontainer open" menu="entities">



          <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/event_tags') ?>">Event Tags</a>
        </div>
         -->
          <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/event_categories') ?>">Event Categories</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/exhibitions') ?>">Exhibitions</a>
        </div> -->

        <a href="<?= site_url('entities/Content/normals') ?>">
          <div class="sidebar_menuitem">
              Standard Articles
            </div>
            </a>

          <!-- <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/locations') ?>">Locations</a>
        </div> -->



        </div>

        <!-- ********************* NOARTICLES ********************* -->

        <div class="sidebar_headline semibold active" menu="noarticles">
          <span class="headline_text">
            Tables
          </span>
          <span class="arrow_down"></span>
        </div>

        <div class="sidebar_itemcontainer open" menu="noarticles">
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/artworks') ?>">Artworks</a>
          </div>
        </div>


        <!-- ********************* TAGS & CATEGORIES ********************* -->

        <div class="sidebar_headline semibold active" menu="tags">
          <span class="headline_text">
            Tags & Categories
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer open" menu="tags">




          <div class="sidebar_menuitem" style="">
            <a href="<?= site_url('entities/Content/normal_tags') ?>">Special Standard Article Tags</a>
          </div>


          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/tags') ?>">Tags</a>
          </div>
        </div>

      </fieldset>


      <? if (IS_SHOP == 1): ?>

      <!-- *************/////////////////******** SHOP STARTS ********/////////////////////************* -->

      <!-- ********************* PRODUCTS ********************* -->
      <fieldset>
        <legend class="shop_fieldset">Shop</legend>



        <div class="sidebar_headline semibold active" menu="products">
          <span class="headline_text">
            Products
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer open" menu="products">

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/products') ?>">Products</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/product_categories') ?>">Product Categories</a>
          </div>


          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/product_tags') ?>">Product Tags</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/product_versions') ?>">Product Versions</a>
          </div>

        </div>


        <!-- ********************* ORDERS ********************* -->

        <div class="sidebar_headline semibold active" menu="orders">
          <span class="headline_text">
            Orders
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer open" menu="orders">
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/orders') ?>">Orders</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/ordered_products') ?>">Ordered Products</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/order_notes') ?>">Order Notes</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/taxes') ?>">Taxes</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/vouchers') ?>">Vouchers</a>
          </div>


        </div>

        <!-- ********************* CUSTOMERS ********************* -->

        <div class="sidebar_headline semibold active" menu="customer_data">
          <span class="headline_text">
            Customers
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer open" menu="customer_data">
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/customers') ?>">Customers</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/favorites') ?>">Favorites</a>
          </div>

        </div>

      </fieldset>
      <!-- *************/////////////////******** SHOP ENDS ********/////////////////////************* -->

      <? endif ?>

      <!-- ********************* CONTENT / META SETTINGS ********************* -->

      <fieldset class='general_fieldset'>
        <legend>
          General
        </legend>

        <div class="sidebar_headline semibold active" menu="content">
          <span class="headline_text">
            Meta
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer open" menu="content">


          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/main_menu') ?>">Menu</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/page_settings/edit/1') ?>">Page settings</a>
          </div>

          <!-- <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/languages') ?>">Languages</a>
          </div> -->

          <!-- <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/colors') ?>">Colors</a>
          </div> -->
          <!--
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/searches') ?>">Search Terms</a>
          </div> -->



        </div>



        <!-- ********************* USERS ********************* -->


        <div class="sidebar_headline semibold active " menu="users">
          <span class="headline_text">
            <div class="sidebar_menuitem">
              <a href="<?= site_url('entities/Users/items') ?>">CMS Users</a>
            </div>
          </span>

        </div>
        <div class="sidebar_itemcontainer" menu="users">

        </div>

      </fieldset>


      <!-- ********************* REPOSITORIES ********************* -->

      <fieldset class='repositories_fieldset'>
        <legend>
          Repositories
        </legend>

        <!-- IMAGEES -->
        <div class="sidebar_headline semibold active " menu="image_repository">
          <span class="headline_text">
            Image Repository
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>
        <div class="sidebar_itemcontainer" menu="image_repository">

          <!-- <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Repository/items') ?>">Images</a>
          </div> -->
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/repository_overview') ?>">Images Overview</a>
          </div>


          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Repository/tags') ?>">Image Tags</a>
          </div>

          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Repository/categories') ?>">Image Categories</a>
          </div>
        </div>

        <!-- FILES -->

        <div class="sidebar_headline semibold active " menu="file_repository">
          <span class="headline_text">
            File Repository
          </span>
          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>

        <div class="sidebar_itemcontainer" menu="file_repository">


          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/files') ?>">Files</a>
          </div>
          <div class="sidebar_menuitem">
            <a href="<?= site_url('entities/Content/file_tags') ?>">File tags</a>
          </div>
        </div>
      </fieldset>




      <!-- //copy_openai -->
        <!-- ********************* OPENAI ********************* -->


        <!-- <fieldset class='openai_fieldset'>

        <div class="sidebar_headline semibold active" menu="openai">
          <span class="headline_text">
            Openai
          </span>

          <div class="fieldsetArrow">
          <span class="arrow_down"></span>
          </div>
        </div>



      <div class="sidebar_itemcontainer" menu="openai">

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_chat_log') ?>">Chats</a>
        </div>
             <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_prompts') ?>">Prompts</a>
        </div>
             <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_question_translations') ?>">Question Translations</a>
        </div>
                <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_langlines') ?>">Langlines</a>
        </div>
             <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_languages') ?>">Languages</a>
        </div>

        <div class="sidebar_menuitem">
          <a href="<?= site_url('entities/Content/openai_inputs') ?>">Custom Inputs</a>
        </div>

      </div> -->

        <!-- //copy_openai -->





        <!-- general info articles -->

        <fieldset class='repositories_fieldset'>

          <div class="sidebar_headline semibold active" menu="entities">
            <span class="headline_text">
              <a href="<?= site_url('entities/Content/normals') ?>">
                <div class="sidebar_menuitem">
                    Settings
                  </div>
              </a>
            </span>
          </div>

          <div class="sidebar_headline semibold active" menu="entities">
            <span class="headline_text">
              <a href="<?= site_url('entities/Content/normals') ?>">
                <div class="sidebar_menuitem">
                    Contact
                  </div>
              </a>
            </span>
          </div>

          <div class="sidebar_headline semibold active" menu="entities">
            <span class="headline_text">
              <a href="<?= site_url('entities/Content/normals') ?>">
                <div class="sidebar_menuitem">
                    Imprint
                  </div>
              </a>
            </span>
          </div>

        </fieldset>





    </div>

  </div>





</div>

<div class="overlayBlur"></div>



<?
