<div id="repo_upload_overlay" style="opacity: 0.6;">

  </div>
  <div id="repo_upload_holder" class="repoUploadPopup ui-rounded1">
    <div id="upload_details">
      <div class="" style="text-align:center;font-size:22px;">Upload new file/s</div>
      <img id="close_repo_upload" src="<?= site_url('items/backend/img/x.svg') ?>" />

      <div class="repoUploadOuterWrapper">

        <div id="repo_upload_image_holder">
          <!-- <img style="display:none;" /> -->
        </div>
        <span class="noFilesSpan">no file/s selected</span>
        <div id="repo_select_file" class="ui-rounded1 invertHover">choose file/s</div>

      </div>

      <div id="repo_selected_file"></div>


      <form id="repo_image_form" method="post">

        <input id="repo_image_input" multiple name="repo_image_input" style="" type="file"
          accept=".png,.jpg,.jpeg,.svg,.gif,.pdf" /><br />

        <label for="image_title" class="labelCss">Title German</label>
        <input type="text" class="ui-rounded1" id="image_title" name="image_title" placeholder="Title" /> <br />

        <label for="image_title" class="labelCss">Title English</label>
        <input type="text" class="ui-rounded1" id="image_title_en" name="image_title_en" placeholder="Title EN" /> <br />


        <label for="image_alt_text" class="labelCss">Credits German</label>
        <input type="text" class="repo_input ui-rounded1" name="image_credits_text" id="image_credits_text" placeholder="Image credits en" />

        <label for="image_alt_text_en" class="labelCss">Credits English</label>
        <input type="text" class="repo_input ui-rounded1" name="image_credits_text_en" id="image_credits_text_en" placeholder="Image credits de" />
        <input type="hidden" id="repo_fname" name="repo_fname" />
          <!-- <input type="hidden" id="item_id" name="item_id" value="edit_item" /> -->

        <label for="image_category" class="labelCss">Category</label>
        <select name="image_category" id="image_category" class="ui-rounded1" placeholder="">
          <option value="">All categories</option>
          <?php foreach ($repo_categories as $cat): ?>
              <option value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
          <?php endforeach; ?>
        </select>

        <label for="image_tag" class="labelCss">Tag:</label>
        <select name="image_tag" id="image_tag" class="ui-rounded1  " placeholder="">
          <option value="">All tags</option>
          <?php foreach ($repo_tags as $tag): ?>
              <option value="<?= $tag->id; ?>"><?= $tag->name; ?></option>
          <?php endforeach; ?>
        </select>

        <label for="image_alt_text" class="labelCss">Alt text German</label>
        <input type="text" class="repo_input ui-rounded1" name="image_alt_text" id="image_alt_text" placeholder="Alt text" />

        <label for="image_alt_text_en" class="labelCss">Alt text English</label>
        <input type="text" class="repo_input ui-rounded1" name="image_alt_text_en" id="image_alt_text_en"
          placeholder="Alt text en" />

        <br />

        <label for="image_public" class="labelCss">Public</label>
        <input type="checkbox" name="image_public" id="image_public" value="1" checked>

        <!-- <div id="repo_upload_image" class="ui-rounded1 invertHover" style="">Upload</div> -->
        <div id="repo_upload_image_progressive" class="ui-rounded1 invertHover">Upload</div>
      </form>
    </div>
  </div>

  <div class="barHolder"></div>