<div id="overview_elements" class="no_scrollbar overview_elements ">

    <div class="subtitleWrapper">
        <!-- module information -->
        <div class="subtitleHeader">
          <!-- <?= $cat->name ?> -->
        </div>

    </div>


  <div class="headerSearch ">
        <div class="headerSearchInner df-fdc">

    <div id="menu_search_container2">

      <input list="menu_search_input" placeholder="<?= $this->language == SECOND_LANGUAGE ? 'I search for' : 'Ich suche nach' ?>" id="menu_search_input" class="treat_input searchTextDesktop2 js-keyupSearch" type="text" value="">

      <div id="search_icon2" class="" activate="">
        search icon here
        <img src="<?= site_url('items/frontend/img/placeholder/search_icon_thicker.svg') ?>" alt="">
      </div>
    </div>

 <div class="beliebteTags df">
              <? foreach ($searches as $e):
                $name = $lang == 1 ? $e->name_en : $e->name;
                ?>
                <div class="tagElem" style="cursor:pointer"><?= $name ?></div>
              <? endforeach ?>
            </div>
  </div>

</div>

    <div class="subtitleWrapper">
        <!-- module information -->
        <div class="subtitleHeader">
          <? if (1): ?>
              <?= $item_count . " Treffer"; ?>
            <? else: ?>
                <?= $item_count . " Results"; ?>
          <? endif; ?>
        </div>

    </div>



  <?php if ($item_count == 0): ?>

        <?= $this->lang->line('no_results') ?>

  <?php else: ?>

      <?php if (count($articles) > 0): ?>

          <div class="allSearchElems">

            <?php foreach ($articles as $item): ?>

                <?

              // add tags for different types of articles
                switch($item->type){
                  case ARTICLE_TYPES['normals']['type_id']:
                    $eTitle = $this->lang->line('normals');
                    $contentStripColor = 'blue';
                    break;
                }



                ?>

                <div class="searchElem">
                  <? if (isset($item->pretty_url)): ?>
                    <a href="<?= $item->pretty_url ?>">
                    <? endif; ?>
                    <div class="eElem">
                      <div class="sTitle bold16"><?= $item->name; ?></div>
                      <? if (isset($item->result_string)): ?>
                          <div class="sString reg14"><?= $item->result_string; ?></div>
                        <? endif; ?>
                        <div class="sInfo reg14" style="background:<?= $contentStripColor ?>"><?= $eTitle ?></div>
                    </div>
                  <? if (isset($item->pretty_url)): ?>
                    </a>
                  <? endif; ?>

                </div>

            <?php endforeach; ?>

          </div>

      <?php endif; ?>



  <?php endif; ?>


</div>



<style>


#overview_elements {
  max-width: 1200px;
  width: 100%;
  margin: auto;
  margin-top: 100px;

  background-color: #ECECE9;
}

.subtitleWrapper {
  text-align: left;
  max-width: 1000px;
  width: 100%;
  margin-bottom: 40px;
}

#menu_search_container2 {
  background-color: #ECECE9;
}
#menu_search_container2 input {
  background-color: #ECECE9;
}

#overview_elements .headerSearch {
    display: flex;
    justify-content: flex-start;
    max-width: 1000px;
    width: 100%;
    padding-top: 50px;
    margin: 100px auto 50px;
}


.allSearchElems {
  width: 100%;
  max-width: 1000px;
  margin: auto;
  padding-bottom: 100px;
}

.searchElem {
  padding: 16px 0;
  border-top: 2px solid #aaa;
}

.searchElem:last-child {
  border-bottom: 2px solid #aaa;
}

.sTitle {
  margin-bottom: 5px;
}
.sString {
  margin-bottom: 5px;
}

.searchHighlight {
  color: #ff6900;
}

.sInfo {
  display: inline;
  border-radius: 10px;
  padding: 2px 10px;
}





</style>