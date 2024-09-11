


<div class="container1200">

  <div class="topInfoHolder df">

    <div class="topInfoLeft">




    </div>


    <div class="topInfoRight">

      <select id="entitySearch">


      <option value="" disabled selected hidden>Ich suche...</option>
      <? foreach($artwork_names as $a): ?>
          <option value="<?= $a['key'] ?>"><?= $a['value']?> </option>
        <? endforeach ?>
      </select>


    </div>


  </div>









<div class="filterBigHolder">

  <div class="filterSmallHolder df">
    <div class="filterTab filterTabLeft js-filterTab" id="chooseDate">
      Filter
    <div>

    <!-- <input type="text" id="datepicker" class="datepicker" placeholder="<?= $lang == MAIN_LANGUAGE ? "Datum wählen": "Choose date" ; ?>">
  </div> -->
    <!-- <input data-toggle="datepicker" id="chooseDate"> -->



    <div class="filterTab filterTabRight js-filterTab"><?= count($artwork_articles) ?> Filter results</div>
  </div>

</div>

<div class="eventFilterOuterContainer">

  <div class="eventFilterContainer">

      <div class="eventFilterElem">

      <? if(count($eras)) : ?>

      <div class="filterColTitle"><?= $this->lang->line('era')?></div>

      <div class="filter filterCol">
      <? foreach($eras as $e):
        $id = $e->id;
        $name = $e->Name;
        $count = $e->Count;
        ?>
        <div class="filterElem js-filterElem" sel_era="<?= $id?>">
              <div class="filterCheck <?= in_array($id, $sel_era) ? 'active' : "" ?>"></div>
              <div class="filterName"><?= $name?><sup><?= $count ?></sup></div>
        </div>
      <? endforeach ?>
      </div>
      <? endif ?>

    </div>

     <div class="eventFilterElem">

      <? if(count($artists)) : ?>
      <div class="filterColTitle"><?= $this->lang->line('artists')?></div>

      <div class="filter filterCol">
      <? foreach($artists as $a):
        $id = $a->id;
        $count = $a->Count;
        $name = $a->Name;
        ?>
        <div class="filterElem js-filterElem" sel_artist="<?= $id?>">
              <div class="filterCheck <?= in_array($id, $sel_artist) ? 'active' : "" ?>"></div>
              <div class="filterName"><?= $name?><sup><?= $count ?></sup></div>
        </div>
      <? endforeach ?>
      </div>
      <? endif ?>

    </div>

    <div class="eventFilterElem">

      <? if(count($mediums)) : ?>

      <div class="filterColTitle"><?= $this->lang->line('medium')?></div>
      <div class="filter filterCol">
      <? foreach($mediums as $m):
        $id = $m->id;
        $count = $m->Count;
        $name = $m->Name;
        ?>
        <div class="filterElem js-filterElem" sel_medium="<?= $id?>">
              <div class="filterCheck <?= in_array($id, $sel_medium) ? 'active' : "" ?>"></div>
              <div class="filterName"><?= $name?><?= $count ?></div>
        </div>
      <? endforeach ?>
      </div>
      <? endif ?>

    </div>

        <div class="eventFilterElem">

      <? if(count($availabilities)) : ?>

      <div class="filterColTitle"><?= $this->lang->line('availability')?></div>

      <div class="filter filterCol">
      <? foreach($availabilities as $a):
        $id = $a->id;
        $name = $a->Name;
        $count = $a->Count;
        $image = $a->Image;
        ?>
        <div class="filterElem js-filterElem" sel_availability="<?= $id?>">
              <div class="filterCheck <?= in_array($id, $sel_availability) ? 'active' : "" ?>"></div>
              <img src="<?= $image ?>" alt="">
              <div class="filterName"><?= $name?><sup><?= $count ?></sup></div>
        </div>
      <? endforeach ?>
      </div>
      <? endif ?>

    </div>



  </div>

  <div class="eventFilterButtons">

    <div class="filterColTitle"><?= $this->lang->line('price')?></div>

    <div class="eventFilterElem">

      <? if(count($prices)) :
        $maximum = max($prices);
        $minimum = min($prices);
        $selected_minimum = $minimum;
        $selected_maximum = $maximum;

        if(count($sel_price) == 2){
        $selected_minimum = $sel_price[0];
        $selected_maximum = $sel_price[1];
        }

        ?>


      <? foreach($prices as $p): ?>

      <? endforeach ?>


      <? endif ?>

    </div>


    <div class="filterClear">Reset</div>

    <div class="filterStart js-filterStart button"><?= $this->lang->line('apply')?></div>

  </div>

    <div class="eventFilterButtons">

    <div class="filter_button"><?= $this->lang->line('filter')?></div>



</div>





<div class="eventsSlider">

    <div class="eventsComment">
      <? if(count($artwork_articles) == 0) : ?>
        No Artworks Available
      <? else:
      // count of articles
        $count = count($artwork_articles)

        ?>



    </div>


        <? foreach($artwork_articles as $a):
          $pretty_url = $a->pretty_url;

          $e = $a->entity;
          $image = $a->first_teaser;
          $name = $e->Name;
          $id = $e->id;
          $availability_name = $e->availability->Name;
          $availability_img = $e->availability->Image;

          // filter thingys
          $availability = $e->availability->id;
          $mediums = $e->related_medium_ids;
          $eras = $e->related_era_ids;
          $artist = $e->artist;
          $price = $e->price;


          ?>

            <div class="artworkElem Elem df" price="<?= $price ?>" entity_id="<?= $id ?>" availability="<?= $availability ?>" mediums="<?= $mediums ?>" eras="<?= $eras ?>" artist="<?= $artist ?>" ><?= $name ?>
        </div>




<? endforeach;
endif; ?>


  <style>

  .topInfoHolder {
    background-color: #9560A4;
  }

  .topInfoHeader {
    margin-bottom: 20px;
  }

  .topInfoInfo {
    margin-bottom: 0;
  }

  .topInfoRight {
    align-self: flex-end;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    background-color: #9560A4;
  }

  .select2-container--default .select2-selection--single {
    border: unset;
    border-radius: 0px;
    border-bottom: 1px solid black !important;
  }

  .select2-container {
    width: 100% !important;
}






</style>
