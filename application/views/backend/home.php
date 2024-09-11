   <div id="content1">
        <div class="home_welcome bold">

          Welcome back to your dashboard
          <?php if ($userdata->is_admin == 1): ?>
          <!--
                 <div id="widget_btn" class='regular'>
                <div class="plus_circle">
                  <hr class="hr1">
                  <hr class="hr2">
                </div>
                Add Widget
              </div>
             -->
          <?php endif; ?>
        </div>



        <div class="con_box">

            <div class="conboxInfo">
              <div class="plainBold">Info</div>
              Tell me what to write here
              Tell me what to write here
              Tell me what to write here
              Tell me what to write here
              Tell me what to write here
            </div>
            
            <div class="conboxRight">
              <div class="plainBold">Recently added</div>

              <div class="conboxElems">

                <? foreach  ($recent_entities as $recentElem) : 

                    $tempLink = site_url() . 'entities/Content/items/edit/' . $recentElem->main_article->id;
                    $tempTeaserLink = site_url() . 'entities/Content/teaser_selector/1/' . $recentElem->id;
                    $tempImg = $recentElem->teaser_images[0]->img_path ?? "";
                  
                  ?>



                  <div class="conboxElem">
                    <div class="conboxElemImg">
                      <img src="<?= $tempImg ?>" alt="">
                    </div>
                    <div class="shader"></div>
                    <div class="conboxTitle">
                      <?= $recentElem->name?>
                    </div>

                    <div class="conboxButtons">
                      <a href="<?= $tempLink?>">
                        <div class="conboxButton conboxDots ui-rounded1 invertHover">
                          ...
                        </div>
                      </a>
                      <a href="<?= $tempTeaserLink?>">
                        <div class="conboxButton ui-rounded1 invertHover">
                          <img src="<?= site_url('items/backend/icons/editIcon.svg') ?>" alt="">
                        </div>
                      </a>
                    </div>
                    
                  </div>
                <? endforeach; ?>

              </div>

              <div class="quickLinks">
                <a href="<?= site_url('entities/Content/normals')?>">
                  <div class="quickLink ui-rounded1 invertHover">
                    Go to Articles
                  </div>
                </a>
                <a href="<?= site_url('entities/Content/repository_overview')?>">
                  <div class="quickLink ui-rounded1 invertHover">
                    Go to Images
                  </div>
                </a>
              </div>

            </div>




          <!-- <? $widgets; ?> -->
        </div>

        <!--     <div id="widget_btn"><img style=" width: 20px; top: 3px; position: relative;"src="<?= site_url('items/backend/img/add.png') ?>"> Add Widget</div>  -->
      </div>