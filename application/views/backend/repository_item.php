           <?
           $tempClassString = "";
           if (isset($images)):
             if (count($images) < 1) {
               } else {
               foreach ($images as $exh_im):

                 if ($exh_im->id == $img->id) {
                   $tempClassString = 'selected_item';
                   break;
                   } else {
                   $tempClassString = '';
                   }

               endforeach;
               }
           endif;
           ?>

          <div class="repo_item no_scrollbar lazy <?= $tempClassString ?>" data-id="<?= $img->id; ?>" img="<?= $img->img_path ?>" last="<?= $img->last_edited; ?>" loading="lazy" data-title="<?= $img->title; ?>" cid="<?= $img->category; ?>">

            <img class="repo_img <?= $img->public != 1 ? 'unPublicImage' : '' ?>" src="<?= $img->img_path ?>" img_path_full=<?= $img->img_path_full ?> loading="lazy" />

            <div class="repo_item_tags">
              <? foreach ($img->tags as $tag) {
                echo '<div class="image_repo_tag" tag="' . $tag->id . '">' . $tag->name . '</div>';
                } ?>
           </div>

           <? if (!isset($images)): ?>
              <div class="repoEditHolder">

              <input class="repo_item_title repo_item_data repo_e
            " value="<?= $img->title; ?>" placeholder="Title" >
              <input class="repo_item_data repo_e repo_item_title_en" value="<?= $img->title_en; ?>" placeholder="Title EN" >
              <input class=" repo_item_data repo_e repo_item_credits" value="<?= $img->credits; ?>" placeholder="Credits DE" >
              <input class="repo_item_credits_en repo_item_data repo_e " value="<?= $img->credits_en; ?>" placeholder="Credits EN">


                <!-- add more if needed -->


              </div>


              <div class='actions_container'>

                <div class="repoActionsLeft">

                  <div class="repoActionSave repoActionButton ui-rounded1 invertHover repo_item_save" item_id="<?= $img->id ?>">
                    <img src="<?= site_url() . 'items/backend/icons/tableIcons/tableIcon-save.svg' ?>" alt="">
                  </div>

                  <a href="<?= site_url('entities/Repository/items/edit/' . $img->id) ?>" target="_blank">
                    <div class="repoActionEdit repoActionButton ui-rounded1 invertHover">
                    <img src="<?= site_url() . 'items/backend/icons/editIcon.svg' ?>" alt="">
                  </div>
                  </a>

                </div>

                <div class="repoActionsRight">

                <!-- checker start -->
                <div class="acElem">
                  <div class="selectRepo ui-rounded1 invertHover">Select</div>



              <!-- <div class="selectRepo">
                <div>select</div>
                <div class="imageChecker">
                  <img class="checker_image" src="<?= site_url() . 'items/backend/img/checkbox.png' ?>" />
                </div>
              </div> -->

            </div>
            <!-- checker end -->

                 <a href="<?= site_url() . 'items/uploads/images/' . $img->fname ?>"  download>
                <div class="repoActionDownload repoActionButton ui-rounded1 invertHover">
                  <img src="<?= site_url() . 'items/backend/icons/tableIcons/tableIcon-download.svg' ?>" alt="">
                </div>
              </a>

                </div>
                  </div>


              <? else: ?>

                  <div class="<?= isset($module_type) ? "js-moduleSelect" : "" ?> <?= $multiple ? "js-multipleSelect" : "" ?> repo_item_select teaser ui-rounded1 invertHover" title="<?= $img->title; ?>" type="<?= isset($type) ? $type : "" ?>" has_article="<?= isset($has_article) ? $has_article : ""; ?>" iid="<?= $img->id; ?>" fname="<?= $img->fname ?>" >
                    Select
                  </div>

              <? endif; ?>

          </div>