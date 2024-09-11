  <? include(APPPATH . 'views/backend/crud/' . "crud_head_universal.php"); ?>

  <?
  include(APPPATH . 'views/backend/' . "steps.php");
  ?>



  <?php if (!$show_mods): ?>

      <!-- ****** NO MODULES VIEW  ****** -->

      <!-- repo overlay -->
      <? include(APPPATH . 'views/backend/crud/' . "crud_repo_overlay.php"); ?>

      <!-- data -->
      <?= $crud_data ?>




  <?php else: ?>

      <!-- ****** MODULES VIEW ****** -->

      <!-- crud head modules -->
      <? include(APPPATH . 'views/backend/crud/' . "crud_head_modules.php"); ?>

      <!-- new repo container taric -->
      <? include(APPPATH . 'views/backend/crud/crud_repo_overlay.php'); ?>


      <div class="bothEditors">


      <!-- TABS ON THE RIGHT SIDE -->

      <div id="crud_editor" class="inside">

        <div class="crudMover js-crudMover">
          <div class="crudMoveHolder">
            <div class="crudMoverText"></div>
            <div class="crudMoveArrow">
              <img src="<?= site_url() . 'items/backend/icons/iconArrowDown.svg' ?>" alt="">
            </div>
          </div>
        </div>


        <div class="crudOpacHolder">

          <div class="crudTabHolder">

            <div id="crud_tabs">
              <div class="crud_tab_item active" type="module_content">Module content</div>
              <div class="crud_tab_item" type="repository" style="display:none;">Repository</div>
            </div>

          </div>

          <!-- REPO OVERLAYS -->

            <!-- DATA -->
            <!-- <div class="crud_tab" type="attributes" style="display:block;"> -->
              <?= $crud_data ?>



            <!-- </div> -->

        </div>
        <!-- crud oppac holder end -->


        <div id="module_editor">

            <div id="tooltip"></div>

            <div id="edit_container">

              <!-- module icon list -->
              <? include(APPPATH . 'views/backend/crud/' . "crud_module_icon_list.php"); ?>

              <!-- modules preview -->

              <? include(APPPATH . 'views/backend/crud/' . "crud_modules_preview.php"); ?>

            </div>

        </div>


      </div>
      <!-- crud editor end -->


      <!-- </div>


    </div> -->

  <?php endif; ?>




</div>
