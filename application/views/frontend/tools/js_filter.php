
<script type="text/javascript" src="<?= site_url("items/frontend/js/_filter.js?ver=") . time(); ?>"></script>


<div id="webinarContainer">

    <a href="<?= site_url()?>">
      <div class="backArrowHolder">
          <div class="backArrow">←</div>
          Back to main page
      </div>
  </a>

    <div class="boldHeader">Webinars</div>

    <div class="introText">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quam asperiores incidunt aliquid natus ad reiciendis non molestiae vel, eaque corrupti laudantium ab sint sapiente odio ullam, et cupiditate aspernatur.
        Repellat iure veniam nam natus molestiae deserunt enim quidem! Deserunt quisquam veniam velit tenetur explicabo mollitia voluptatem nam incidunt architecto labore cum quia, pariatur unde vitae ratione optio numquam similique?
        <br>
        Filter our list by clicking heree or explore below:

    </div>



    <div class="flexer tgHolder">
        <div class="mediumRegText">target groups</div>

        <? foreach($target_groups as $tg) : ?>

          <div tgid="<?= $tg['key'] ?>" class="filterElem filterHolder chooseElem js-filterNow">
              <div class=""><?= $tg['value'] ?></div>
              <div class="roundArrow">→ </div>
          </div>

        <? endforeach; ?>

    </div>


    <div class="fullLine"></div>


    <div class="flexer topicHolder">
        <div class="mediumRegText">topics</div>

        <? foreach($topics as $topic) : ?>

          <div topid="<?= $topic['key'] ?>" class="filterElem filterHolder chooseElem js-filterNow">
              <div class=""><?= $topic['value'] ?></div>
              <div class="roundArrow">→ </div>
          </div>

        <? endforeach; ?>

    </div>



    <div class="fullLine"></div>



  <?  foreach($months as $m): ?>

    <div class="monthHolder">

      <div class="boldHeader"><?= $m ?></div>

      <div class="webinarHolder">

        <? foreach($webinars as $w): ?>

         <?
          $e = $w->entity;
          $name = $e->name_external;
          $prettyUrl = $w->pretty_url;
          $dateInfo = date('F jS g A', strtotime($e->date)) . ", " . $e->location;
          $image = site_url() . "items/uploads/images/" . $e->image;

          $first = true;
          $topic = "";
          foreach($e->topics as $t) {

            if($first) {
                $topic .= $t->id;
                $first = false;
            } else {
                $topic .=  " " . $t->id;
            }
          }

          $first = true;
          $tg = "";
          foreach($e->target_groups as $t) {

            if($first) {
                $tg .= $t->id;
                $first = false;
            } else {
                $tg .=  " " . $t->id;
            }
          }

         ?>

          <? if($e->Month == $m): ?>


            <div class="filteredUnit" topic="<?= $topic ?>" tg="<?= $tg ?>">

                <a href="<?= $prettyUrl?>">

                  <div class="webinarElem">

                      <div class="webinarTop imgCover">
                          <img src="<?= $image ?>" alt="">
                          <div class="webinarTags">
                              <? foreach ($e->topics as $topic) : ?>
                                <div class="webinarTag topic"><?= $topic->display_name ?></div>
                              <? endforeach; ?>
                              <? foreach ($e->target_groups as $targetGroup) : ?>
                                <div class="webinarTag targetGroup"><?= $targetGroup->display_name ?></div>
                              <? endforeach; ?>
                          </div>
                      </div>

                      <div class="webinarBottom">

                          <div class="webinarOuterText">
                              <div class="webinarText"><?= $name ?></div>
                              <div class="webinarDate"><?= $dateInfo?></div>
                          </div>

                          <div class="webinarStripe">
                              <div class="webinarStripText">Learn more & subscribe</div>
                              <div class="roundArrow">→</div>
                          </div>
                       </div>

                  </div>
                </a>


            </div>


          <? endif; ?>

        <? endforeach; ?>

        </div>


    </div>

    <? endforeach; ?>




</div>



<style>

  .filterHolder {

    display: flex;
    border: 1px solid black;
    border-radius: 5px;
    padding: 3px 8px;
    margin-right: 5px;
    font-size: 14px;
    cursor: pointer;
  }

  .filterHolder.active {
    background-color: black;
    color: white;
  }

  .filterHolder.active .roundArrow {
    filter: invert(1);
  }









.imgCover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.imgContain img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}




    #webinarContainer {
        margin: 100px auto;
    }

    .backArrowHolder {
        display: flex;
        margin-bottom: 50px;
    }

    .backArrow {
        margin-right: 10px;
    }

    .boldHeader {
        font-weight: bold;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .flexer {
        display: flex;
        align-items: center;
    }

    .mediumRegText {
        font-size: 24px;
        margin-right: 20px;
    }

    .targetGroupFilter, .topicFilter {
        margin-right: 20px;
    }

    .introText {
        margin-bottom: 20px;
    }

    .selectElem {
        outline: none;
        border: none;
    }





    select {
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .roundArrow {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: black;
        margin-left: 5px;
        color: white;
        font-size:12px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .filterHolder .roundArrow {
        rotate: 45deg;
    }

    /* .webinarStripe .roundArrow {

    } */




    .fullLine {
        width: 100%;
        height: 1px;
        margin: 20px 0 ;
        background-color: black;
    }

    .webinarHolder {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        grid-gap: 20px;

        margin-bottom: 50px;
    }


    .webinarElem {
        display: flex;
        flex-direction: column;

        border-radius: 8px;

        overflow: hidden;

    }

    .webinarTop {
        position: relative;
        /* flex: 1 0 100px; */
        flex-basis: 100px;
        background-color: lightblue;

        height: 150px;

    }

    .webinarTop img {
        background-color: black;
        width: 100%;
        height: 100%;
        object-fit: cover;

    }

    .webinarTags {
        position: absolute;
        bottom: 5px;
        left: 10px;
        display: flex;
        flex-wrap: wrap;
        font-size: 10px;
    }



    .webinarTag {
        background-color: yellow;
        padding: 2px 5px;
        border-radius: 10px;
        margin: 0 5px 5px 0;
    }

    .webinarBottom {
        /* flex: 1 0 200px; */
    }

    .webinarStripe {
        font-size: 14px;
        background-color: #FD8A8A;
        display: flex;
        padding: 5px;
    }

    .webinarOuterText {
        padding: 8px;
    }

    .webinarText {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .webinarDate {
        font-size: 14px;
        font-weight: bold;
    }

    .topic {
      background-color: #FD8A8A;
    }

    .targetGroup {
      background-color: #E5BF83;
    }




</style>
