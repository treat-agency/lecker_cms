<?


$step_nr = 0;
// 1) which step I have
$current_url = $_SERVER['REQUEST_URI'];
$is_article_teaser = substr($current_url, -1) != '0' ? true : false;
$teaser_subpage = str_contains($current_url, 'entities/Content/teaser_selector/') && $is_article_teaser;
$teaser_step = 4;



$stepsArray = [1, 2, 3, 4];

if (!isset($is_table) || $teaser_subpage):


  // 1) active
  if (isset($article_type) && !isset($is_table) && !$is_article) {
    $step_nr = 1;
    } elseif (isset($is_article) && $is_article == true && $is_second_lang == false) {
    $step_nr = 2;
    } elseif (isset($is_second_lang) && $is_second_lang == true) {
    $step_nr = 3;
    } elseif ($teaser_subpage) {
    $step_nr = $teaser_step;
    }

  // names
  $step_name1 = 'GENERAL SETTINGS';
  $step_name2 = 'CONTENT DE';
  $step_name3 = NUMBER_OF_LANGUAGES == 1 ? '' : 'CONTENT EN';
  ${'step_name' . $teaser_step} = 'TEASER IMAGES';

  // 1) availability

  // if second language and

  if (NUMBER_OF_LANGUAGES > 1 && $step_nr && isset($is_article) && $is_article == true && isset($second_language)) {
    $step_nr = 2;
    }

endif;



if ($step_nr):

  $step_link1 = '';
  $step_link2 = '';
  $step_link3 = '';
  $step_link4 = '';

  $specialClass = '';



  switch ($step_nr) {

    case 1:

      $step_link1 = '';

      if ($edit_or_add == BC_EDIT) {

        // step 2
        if ($articleForEntity) {
          $step_link2 = site_url() . 'entities/Content/items/edit/' . $articleForEntity->id;
          }


        // step 3
        if ($englishArticleForEntity) {
          $step_link3 = site_url() . 'entities/Content/items/edit/' . $englishArticleForEntity->id;
          }

        // step 4
        if ($article_type && !$is_article) {
          ${'step_link' . $teaser_step} = site_url() . '/entities/Content/teaser_selector/' . $article_type . '/' . $pk;
          }

        } else {

        // right to next article
        // if ($article_type && $last_entity && !$is_article):

        //   $specialClass = 'saveAndNextEntity';

        // endif;

        }

      break;

    case 2:

      $step_link1 = site_url() . '/entities/Content/' . $entity_table . '/edit/' . $entity_id;

      if ($edit_or_add != BC_ADD) {

        if ($englishArticle) {
          $step_link3 = site_url() . 'entities/Content/items/edit/' . $englishArticle->id;
          }

        } else {
        // does english article already exist
        $step_link3 = '';
        }

      if ($is_article && $article_type && $entity_id) {
        $step_link4 = site_url() . '/entities/Content/teaser_selector/' . $article_type . '/' . $entity_id;
        }

      break;


    case 3:

      // step 1
      if (isset($entity_id) && $entity_id) {
        $step_link1 = site_url() . '/entities/Content/' . $entity_table . '/edit/' . $entity_id;
        }

      // step 2
      if (isset($originalId) && $originalId) {
        $step_link2 = site_url() . 'entities/Content/items/edit/' . $originalId;
        }

      // step 3
      $step_link3 = '';

      // step 4

      if (isset($is_article) && $is_article && $article_type && $entity_id) {
        ${'step_link' . $teaser_step} = site_url() . '/entities/Content/teaser_selector/' . $article_type . '/' . $entity_id;
        }


      break;

    case 4:

      $step_link1 = site_url() . '/entities/Content/' . $typeName . '/edit/' . $entityId;

      if ($articleForTeaser) {
        $step_link2 = site_url() . 'entities/Content/items/edit/' . $articleForTeaser->id;
        }

      if ($englishArticleForTeaser) {
        $step_link3 = site_url() . 'entities/Content/items/edit/' . $englishArticleForTeaser->id;
        }

      $step_link4 = '';

      break;

    }


  // if($step_nr = 2 || $step_nr) {
  //   $step_link = 'active';

  // }


  ?>




    <!-- StepHOlder -->

      <div id="blackBar">

        <div id="edit_title_text">
          <?= isset($item) && isset($item->pretty_url) ? $item->pretty_url : ""; ?>

        </div>

        <div class="stepOuterHolder">

            <div class="stepHamburger js-blackBarHam">
              <!-- <div class="ham1 hamLine"></div>
          <div class="ham2">
            <div class="ham21 hamLine"></div>
            <div class="ham22 hamLine"></div>
          </div>
          <div class="ham3 hamLine"></div> -->
              <div class="menuDot"></div>
              <div class="menuDot"></div>
              <div class="menuDot"></div>
              <div class="menuDot"></div>
            </div>


            <div class="stepHolder">

              <? foreach ($stepsArray as $s):
                $activeStep = $step_nr == $s ? 'activeStep' : '';

                $stepLink = false;

                if ($activeStep != $s && ${'step_link' . $s} != ''):
                  $stepLink = ${'step_link' . $s};
                endif;

                $teaserCount = '';

                if ($step_nr == $teaser_step && $s == $teaser_step):
                  $teaserCount = ' (' . $teaser_counts . ')';

                elseif ($s == $teaser_step):
                  $teaserCount = ' (' . $teaser_count . ')';

                endif;

                ?>


                        <div class="stepElem <?= $activeStep ?> <?= $specialClass ?>">

                          <? if ($stepLink): ?>
                                <a href="<?= $stepLink ?>">
                          <? endif ?>

                          <?= ${'step_name' . $s} ?>
                          <?= $teaserCount ?>

                          <? if ($stepLink): ?>
                                </a>
                          <? endif ?>

                        </div>


              <? endforeach; ?>



            </div>

        </div>



        <!-- <div id="button_container_main">

      <span class="unselectable item_save" title="Speichern" type="html"><a href="<?= site_url() . '/entities/Content/teaser_selector/' . $article_type . '/' . $entity_id ?>">Teasers (<?= $teaser_count ?>)</a></span>
          <? if (!$englishArticle && !$is_second_lang): ?>
          <span class="unselectable item_save andEnglish" title="Speichern" type="html">Save & English</span>
        <? endif ?>
      <span class="unselectable item_save" title="Speichern" type="html">Save</span>
      <span class="unselectable item_cancel" link="items" title="Abbrechen" article_type_name="<?= $article_type_name ?>" type="html">Cancel</span>
    </div> -->

      </div>



<? endif; ?>
