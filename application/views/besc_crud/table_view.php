<!-- not displaying value on top -->
<? $ignored_keys = ['pk', 'table_name', 'original_article', 'related_article', 'count_teasers', 'entity_link', 'teaser_button', 'related_article_id', 'article_id'] ?>



<!-- url fo pagination - Display all -->

<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
  $url = "https://";
else
  $url = "http://";
// Append the host(domain name, ip) to the URL.
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$url .= $_SERVER['REQUEST_URI'];

if(str_contains($url, '?pagination=all')){
  $url = str_replace('?pagination=all', '', $url);
  $buttonDisplayAll = 'Display Less';

} else {
  $url = $url . '?pagination=all';
  $buttonDisplayAll = 'Display All';
}



?>

<?php if (!$ajax): ?>
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/fonts.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/lightbox.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/select2.css"); ?>">

<script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-1.11.2.min.js"); ?>"></script>

<!-- <script type="text/javascript" src="<?= site_url("items/general/js/libraries/lightbox.min.js"); ?>"></script> -->
<script type="text/javascript" src="<?= site_url("items/backend/js/select2.min.js?"); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud.js?ver=" . VERSION); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud_list.js?ver=" . VERSION); ?>"></script>
<script>


// specific table view css



<?php foreach ($bc_urls as $key => $value): ?>
var <?= $key ?> = "<?= $value ?>";
<?php endforeach; ?>


var bc_paging_active = <?= $paging['currentPage'] ?>;
</script>
<div class="bc_message_container"></div>


<!-- <div class="bc_title"><?= $main_title . " - " . $table_name ?></div> -->
<div class="bcTitle"><?= $main_title . " - " . $table_name ?></div>



<? if ($back_to != NULL): ?>
<a style="text-decoration: none;" href="<?= site_url('' . $back_to) ?>">
  <div class="back_button"><img style="" src="<?= site_url('items/frontend/img/arrow_left.png') ?>">Back</div>
</a>
<? endif; ?>

  <div id="repo_edit_holder">
    <div id="repo_edit_details">
      <br>
      <br>
      <div class="" style="text-align:center;font-size:22px;">Add following attributes to selected:</div>
      <br>
      <div class="" style="text-align:center;font-size:18px;">Please note, that existing information won’t be changed.</div>
      <img id="close_repo_upload2" src="<?= site_url('items/backend/img/x.svg') ?>" />


        <form id="repo_customize_form" method="post">

          <br />
          <select name="image_tag" id="image_tag2" placeholder="">
            <option value="">all tags</option>
            <?php foreach ($repo_tags as $tag): ?>
              <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
            <?php endforeach; ?>
          </select><br />
          <br />



          <input type="checkbox" name="image_public"
            style="width: unset;position: relative;display: inline-block;top: 1px;">
          <label for="image_public" style="display: inline-block;margin: 20px 0 0px 5px;">public</label>
          <br />
          <br />

          <div class="buttonRepoSmall" id="repo_customize" >
            <img src="<?= site_url() . 'items/backend/img/save3.png' ?>" />
            <div  class="textRepoButton">save</div>
            <!-- <div class="repo_item_crop" type="teaser" iid="<?= $img->id; ?>" fname="<?= $img->fname; ?>">Crop</div> -->
          </div>
        </form>
      </div>
    </div>

  <!-- overlay for edit multiple -->

    <div id="js-entity_editor" class="popup_window_holder" style="display:none">
      <div id="popup_details" style="position: relative">
        <br>
        <br>
        <div class="" style="text-align:center;font-size:22px;">Edit selected:</div>
        <br>

        <img id="close_popup" src="<?= site_url('items/backend/img/x.svg') ?>" />


        <form id="entity_editor_form" method="post">

          <!-- <br />
          <select name="image_tag" id="image_tag2" placeholder="">
            <option value="">all tags</option>
            <?php foreach ($repo_tags as $tag): ?>
              <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
            <?php endforeach; ?>
          </select><br />
          <br /> -->

          <!-- TYPE ENTITIES WITH ARTICLES -->

          <? if($has_article == 1): ?>

        Add Tag: <select name="general_tag_add" id="general_tag_add" placeholder="">
          <option value="">all tags</option>
          <?php foreach ($general_tags as $tag): ?>
                <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
              <?php endforeach; ?>
            </select><br />
            <br />

          Remove Tag: <select name="general_tag_delete" id="general_tag_delete" placeholder="">
          <option value="">all tags</option>
          <?php foreach ($general_tags as $tag): ?>
                      <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
                  <?php endforeach; ?>
                </select><br />
                <br />


                  <input type="checkbox" name="article_visible" class="article_visible"
                    style="width: unset;position: relative;display: inline-block;top: 1px;">
                  <label for="article_visible" style="display: inline-block;margin: 20px 0 0px 5px;">visibility</label>
                  <br>
          <? endif; ?>

          <!-- TYPE UNIVERSAL-->

          <input type="checkbox" name="delete_entity_article" class="delete_entity_article"
            style="width: unset;position: relative;display: inline-block;top: 1px;">
          <label for="delete_entity_article" style="display: inline-block;margin: 20px 0 0px 5px;">delete</label>
          <br />
          <br />

          <div class="buttonPopupSmall">
            <img src="<?= site_url() . 'items/backend/img/save3.png' ?>" />
            <div  class=" v" id="js-edit_selected_button">save</div>
          </div>
        </form>
      </div>
    </div>


    <div class="actionsAndFiltering">

      <div class="bc_table_actions tableActions">


          <div class="controlButtons">

            <div class="controlLeft">

              <?php if ($allow_add): ?>
                <span class="basicButton invertHover bc_table_action">
                  <a class="" href="<?= current_url() . '/add' ?>">
                    <div class="df-aic gap5">
                      <div class="smallIcon imgContain">
                        <img class="" src="<?= site_url('items/backend/icons/plusIcon.svg') ?>"
                          title="Add new <?= $title ?>" />
                      </div>
                      <div>Add <?= $title ?></div>

                    </div>
                  </a>
                </span>
              <?php endif; ?>

              <span class="basicButton invertHover js-edit_selected_entities">
                Edit Selected
              </span>

              <span class="basicButton invertHover js-edit_select_all">
                Select All
              </span>

              <span class="basicButton invertHover" id="js-resetFilterButton">
                Reset Filter
              </span>

              <span class="basicButton invertHover">
                <a href="<?= $url?>">
                <?= $buttonDisplayAll ?>
                </a>
              </span>

              <span class="basicButton invertHover getMeTableCSV"  >
                  <a href="<?= site_url() . 'entities/Content/dbTableToBlankCSV/' . $table ?>" target="_blank">
                  CSV template
                  </a>
              </span>

              <span class="basicButton invertHover uploadCSVToDb"  >
                    <input type="file" id="csvFileUpload" accept=".csv" tableName="<?= $table ?>">
                    <div id="csvUploadError"></div>
                  Insert CSV

              </span>

              <span class="basicButton invertHover downloadTableCSV"  >
                <a href="<?= site_url() . 'entities/Content/exportTableToCSV/' . $table ?>" target="_blank">
                  Download CSV
                </a>
              </span>

            </div>


              <!-- <div id="bc_filter_toggle" class="filterToggle">

                  <div class="basicButton invertHover">
                    <span class="text_open">Search / Filter</span>
                    <img style="" src="<?= site_url('items/backend/icons/filterIcon.svg') ?>" alt="">
                  </div>

              </div> -->


              <? include(APPPATH . 'views/besc_crud/_pageNav.php'); ?>


          </div>





          <?php if ($ordering != array()): ?>

            <span class="bc_table_action">
              <a href="<?= current_url() . '/ordering' ?>">
                <img class="bc_table_action_icon" src="<?= site_url('items/besc_crud/img/ordering.png') ?>"
                  title="Sort <?= $title ?>" /> Order <?= $title ?>
              </a>
            </span>
          <?php endif; ?>

          <?php foreach ($custom_action as $action): ?>

            <span class="bc_table_action">
              <a href="<? echo $action['url'];
                  if ($action['add_pk'])
                    echo '/' . $row['pk']; ?>">
                <img class="bc_table_action_icon" src="<?= $action['icon'] ?>" title="<?= $action['name'] ?>" />
                <?= $action['name'] ?>
              </a>
            </span>

          <?php endforeach; ?>

    </div>

    <!-- //openai_copy -->
        <?php if ($table_name == 'Prompts'): ?>

                <div class="bc_table_actions">
                  <span class="bc_table_action">
                    <a target="_blank" href="<?= site_url() . 'OpenaiController/translateQuestions' ?>">
                      Translate Questions
                    </a>
                  </span>
                </div>
        <?php endif; ?>

        <?php if ($table_name == 'Question Langlines'): ?>

                    <div class="bc_table_actions">
                      <span class="bc_table_action">
                        <a target="_blank" href="<?= site_url() . 'OpenaiController/translateLangLines' ?>">
                          Translate Langlines
                        </a>
                      </span>
                    </div>
          <?php endif; ?>
        <!-- //openai_copy -->


    <?= $paging_and_filtering ?>

    <?php endif; ?>



  </div>
  <!-- paging and filtering end -->



  <div class="fullTableHolder">








  <div id="bc_table_holder" class="bcTableHolder">

    <table class="bc_table">

      <thead>

        <td>
      </th>

          <!-- TABLE HEADERS -->

          <!-- teaser image -->
          <? if (isset($teaser_button)): ?>

              <td class='greyText bc_sortable' col='teaser_image'>
                Teaser Images
                <span class="infoHoverButton" infoId="0">
                  <img src="<?= site_url("items/backend/icons/other") . "/info-button.png"  ?>" alt="">
                </span>
              </th>

          <? endif ?>

          <!-- original article -->
          <? if ($has_article == 1): ?>

            <td class="greyText bc_sortable tdArt" col="pretty_url">
              Original Article
              <span class="infoHoverButton" infoId="1">
                <img src="<?= site_url("items/backend/icons/other") . "/info-button.png"  ?>" alt="">
              </span>
            </th>

          <? endif ?>

          <!-- entity link -->

          <? if ($has_entity == 1): ?>

            <td class="greyText bc_sortable " col="entity">Entity</th>

          <? endif ?>

          <!-- second language -->

          <? if ($has_related_article == 1 && NUMBER_OF_LANGUAGES > 1): ?>

              <!-- column name won't display if number of languages constant is set to 1 -->
              <td class="greyText tdArt">
                Second Language
                <span class="infoHoverButton" infoId="2">
                  <img src="<?= site_url("items/backend/icons/other") . "/info-button.png"  ?>" alt="">
                </span>
              </th>

          <? endif ?>

          <?php foreach ($headers as $header): ?>

            <?
            if($header['sortable']) {
              $tempClassString = "bc_sortable ";
            } else {
              $tempClassString = " ";
            }

            if ($sorting_col == $header['id']) {
              $tempClassString .= $sorting_direction_class;
            }

            ?>


            <td class="greyText <?= $tempClassString ?>" col="<?= $header['id'] ?>">
              <?= $header['display_as'] ?>
                <? if($header['display_as'] == "Intern Name") : ?>
                  <span class="infoHoverButton" infoId="3">
                    <img src="<?= site_url("items/backend/icons/other") . "/info-button.png"  ?>" alt="">
                  </span>
                <? endif; ?>
              </th>

          <?php endforeach; ?>

      </thead>


      <tbody>


      <?php $i = 0; foreach ($rows as $row): ?>


          <!-- getting article ids if present  -->

          <?php if ($has_article == 1): ?>
          <?
            $articleIds = '';
            if(isset($row['article_id']) && $row['article_id']){
              $articleIds .=  $row['article_id'];
            }

            if(isset($row['related_article_id']) && $row['related_article_id']){
              $articleIds .= ',' . $row['related_article_id'];
            }
          ?>

          <?php endif ?>



                <tr <?php if ($i % 2 == 1): ?> class="bc_erow" <?php endif; ?>>

                  <td class="bc_row_actions_container greyText">

                    <div class="bcRowActionContainer">

                      <!-- checkbox for multiple edit -->
                      <div class="bc_row_action_container">
                          <input table="<?= $table ?>" type="checkbox" pk="<?= $row['pk'] ?>" articleType="<?= isset($article_type) ? $article_type : ''  ?>" articleIds="<?= isset($articleIds) ? $articleIds : '' ?>"  name="entitiesSelected" class="entitiesSelected" >
                      </div>

                      <div class="tableIconOuterGrid">


                        <div class="tableIconGrid">

                          <div class="tableIcon1">

                              <?php if ($allow_delete): ?>
                                <div class="bc_row_action_container">
                                  <img title="Delete" class="bc_row_action delete" src="<?= site_url('items/backend/icons/binIcon.svg') ?>"
                                    row_id="<?= $row['pk'] ?>" />
                                </div>
                              <?php endif; ?>

                              <?php if ($allow_edit): ?>
                                <div class="bc_row_action_container">
                                    <a href="<?= $bc_urls['bc_edit_url'] . $row['pk'] ?>" target="_blank">
                                      <img title="Edit" class="bc_row_action edit" src="<?= site_url('items/backend/icons/tableIcons/pencil.svg') ?>"  />
                                    </a>
                                  </div>
                              <?php endif; ?>


                            <?php foreach ($custom_button as $button): ?>

                              <!-- changed -->
                              <? if ($button['url'] != 'teaser_selector'): ?>

                              <div class="bc_row_action_container">

                                <? if ($button['url'] != 'reset_view' && $button['url'] != 'reset_view_front'): ?>

                                  <?php if ($button['url'] == 'sub_submenu'): ?>

                                    <a href="<?php echo site_url('entities/Website/') . $button['url']; ?><? if ($button['add_pk']) echo '/' . $row['pk']; ?><? if (isset($button['add_type']) && $button['add_type'] >= 0) echo '/' . $button['add_type']; ?>"<? if ( isset($button['has_article']) && $button['has_article']==false ) echo '/0' ?>>
                                      <img class="bc_row_action" src="<?= $button['icon'] ?>" title="<?= $button['name'] ?>" />
                                    </a>

                                  <?php else: ?>

                                    <? $url = $button['url']; ?>

                                    <a href="<?php echo $url; ?><? if ($button['add_pk'])echo '/' . $row['pk']; ?><? if (isset($button['add_type']) && $button['add_type'] >= 0) echo '/' . $button['add_type']; ?><? if (isset($button['has_article']) && $button['has_article'] == false)echo '/0' ?>" <?php if (isset($button['blank']) && $button['blank'])echo 'target = "_blank" '; ?>>
                                      <img class="bc_row_action" src="<?= $button['icon'] ?>" title="<?= $button['name'] ?>" />
                                    </a>

                                  <?php endif; ?>


                                  <? else: ?>
                                  <img class="bc_row_action rest_password_view <?= $button['url'] == 'reset_view_front' ? 'front' : ''; ?>"
                                    iid="<?= $row['pk'] ?>" src="<?= $button['icon'] ?>" title="<?= $button['name'] ?>" />

                                  <? endif; ?>

                                <? endif; ?>

                            </div>



                          <?php endforeach; ?>


                          </div>




                        </div>


                      </div>



                    </div>



                  </td>

                  <!-- TABLE CELLS -->


                  <?php foreach ($row as $key => $value): ?>

                      <!-- teaser image preview -->
                      <?php if ($key == 'teaser_button'): ?>
                        <?= $value ?>
                      <? endif; ?>

                      <!-- link to the entity -->
                      <?php if ($key == 'entity_link'): ?>
                        <?= $value ?>
                      <? endif ?>


                      <!-- original article -->

                      <?php if ($has_article != 0 && $key == 'original_article'): ?>
                        <?= $value ?>
                      <? endif; ?>

                      <!-- second language -->

                      <?php if ($has_related_article != 0 && $key == 'related_article' && NUMBER_OF_LANGUAGES > 1): ?>
                        <!-- column value won't display if number of languages constant is set to 1 -->
                        <?= $value ?>
                      <? endif ?>

                  <?php endforeach ?>


                  <?php foreach ($row as $key => $value): ?>

                      <?php if (!in_array($key, $ignored_keys)): ?>
                        <?= $value ?>
                      <?php endif; ?>

                  <?php endforeach; ?>



                </tr>


            <?php $i++;
        endforeach; ?>


      </tbody>
    </table>
  </div>






  </div>




<?php if (!$ajax): ?>
<div class="bc_fade"></div>
<div class="bc_delete_dialog">
  <h3>Delete </h3>
  <div class="bcDeleteText"> Are you sure you want to delete?

    <? if($has_article) : ?>
      <div  class="bcDeleteWarningText">
        All articles connected to this entity will be deleted.
      </div>
    <? endif; ?>

  </div>

      <div class="df-jcc gap5">
        <div class="bc_delete_button basicButton invertHover bc_delete_ok">Delete</div>
        <div class="bc_delete_button basicButton invertHover bc_delete_cancel">Cancel</div>
      </div>
    </div>
<?php endif; ?>
