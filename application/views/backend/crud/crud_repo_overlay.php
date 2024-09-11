 <div id="repo_overlay">
      <div id="current" style="top:0px;left:0px;">
        <div class="content_h1" style="border:0px;">Image repository</div>
        <!-- <img id="close_repo" src="<?= site_url('items/backend/img/x.svg') ?>" /> -->
        <div id="close_repo">Done</div>
        <div style="position: relative;width:90%;height:40px;">
          <div id="repo_filters_toggle">Filters</div>
          <div id="show_upload">Add new image</div>
        </div>
        <div id="repo_filters">
          <div id="name_search">
            <input type="text" name="repo_name_search" id="repo_name_search" placeholder="Search title..." />
            <svg id="search_icon_module" class="" data-name="Ebene 1" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 19.85 19.85">
              <defs>
                <style>
                .cls-1 {
                  fill: #001a00;
                }

                .cls-2 {
                  fill: none;
                  stroke: #001a00;
                  stroke-miterlimit: 10;
                }
                </style>
              </defs>
              <title>Search</title>
              <path class="cls-1" d="M8,1A7,7,0,1,1,1,8,7,7,0,0,1,8,1M8,0a8,8,0,1,0,8,8A8,8,0,0,0,8,0Z"></path>
              <line class="cls-2" x1="13.5" y1="13.5" x2="19.5" y2="19.5"></line>
            </svg>
          </div>
          <br />


          <div style="overflow:hidden;width:100%;">
            <select name="repo_category" id="repo_category_module">
              <option value="0">All categories</option>
              <?php foreach ($repo_categories as $cat) : ?>
              <option value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
              <?php endforeach; ?>
            </select>

          <select name="repo_tag_module" id="repo_tag_module">
              <option value="0">All tags</option>
              <?php foreach ($repo_tags as $t): ?>
                    <option value="<?= $t->id; ?>"><?= $t->name; ?></option>
                <?php endforeach; ?>
              </select>




            <div id="sort_select">
              <span for="repo_sort">Sort by:</span>
              <select name="repo_sort" id="repo_sort_module">
                <option value="id">Upload date</option>
                <option value="title">Title</option>
              </select>

              <select name="repo_sort_type_module" id="repo_sort_type_module">
                <option value="desc">Descending</option>
                <option value="asc">Ascending</option>

              </select>
            </div>
          </div>
        </div>

      </div>



      <div id="repo_content">
        <div id="repo_container" style="">
          <?php foreach ($repository_images as $img) : ?>
                    <?
                      $tags = '';
                      foreach ($img->tags as $t) {
                        $tags .= $t->id . ' ';
                      } ?>


          <div class="repo_item" data-filename="<?= $img->fname; ?>" data-id="<?= $img->id; ?>" repo_tags="<?= $tags ?>" last="<?= $img->last_edited; ?>"
            data-title="<?= htmlentities($img->title ?? ''). " " . htmlentities($img->title_en ?? '')." " . htmlentities($img->credits ?? '')." ". htmlentities($img->credits_en ?? ''); ?>"
            inr="<?= $img->inventoryNR; ?>" cid="<?= $img->category; ?>">
            <div class="repo_img_holder">
              <span class="image_helper"></span>
              <img class="repo_img lazy" loading="lazy" src="<?= site_url('items/uploads/images/thumbs/' . $img->fname) ?>" />
            </div>
            <div class="repo_item_title"><?= htmlentities($img->title ?? ''); ?></div>
            <div class="repo_item_title"><?= $img->inventoryNR; ?></div>
            <div class="repo_item_title"><?= $img->category_name; ?></div>
            <div class="repo_item_select" iid="<?= $img->id; ?>" alt="<?= htmlentities($img->alt_text ?? ''); ?>"
              fname="<?= $img->fname; ?>">Select</div>
          </div>

          <?php endforeach; ?>
        </div>
      </div>
      </div>


<!--

    <div id="newRepoContainer">

      <div class="newRepoRealHolder ui-rounded1">

        <div class="newRepoClose js-newRepoClose">
          <div class="newRepoCloseLine newRepoClose1"></div>
          <div class="newRepoCloseLine newRepoClose2"></div>
        </div>

        <div class="newRepoTitle">IMAGE REPOSITORY</div>
        <br>

        <div class="newRepoControlHolder">

          <div class="select2CustomHolder js-newRepoSelectAll">

            <img class="iconRepo" src="<?= site_url('items/backend/icons/gridIcon.svg') ?>">
            <div class="newRepoAllText">Select all</div>

          </div>

          <div class="select2CustomHolder">

            <img class="iconRepo" src="<?= site_url('items/backend/icons/tagIcon.svg') ?>">
            <div class="js-newRepoAll">Tag</div>

          </div>

          <div class="select2CustomHolder">

            <img class="iconRepo" src="<?= site_url('items/backend/icons/tableIcons/tableIcon-download.svg') ?>">
            <div class="js-newRepoAll">Download</div>

          </div>

        </div>

        <div class="newRepoControl2Holder">

          <div class="newRepoSearch ui-rounded1">
            <input type="text" name="" id="" placeholder="Search">
          </div>

          <div class="newRepoUpload js-newRepoUpload ui-rounded1">
            <img class="iconRepo" src="<?= site_url('items/backend/icons/uploadIcon.svg') ?>">
            <div>Upload</div>
          </div>

          <div class="newRepoUpload ui-rounded1">
            <div>Reset filter</div>
          </div>

        </div>

        <div class="newRepoElems">

          <? foreach($repository_images as $image) : ?>

            <div class="newRepoElem js-newRepoSelect">

              <div class="newRepoImg" fname="<?=$image->fname ?>" iid="<?= $image->id ?>"><img src="<?= site_url('items/uploads/images/thumbs') . $image->fname ?>"></div>
              <div class="newRepoImgTitle"><?= $image->title ?></div>

            </div>

          <? endforeach; ?>

        </div>




      </div>



    </div> -->