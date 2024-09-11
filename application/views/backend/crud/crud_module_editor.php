<div class="crud_tab" type="module_content">


      <div class="crudInfo">
      Click on these
      <span style="display:inline-flex; cursor: default" class="moduleEdit ui-rounded1">
          <img src="<?= site_url() . '/items/backend/icons/editIcon.svg' ?>" alt="">
        </span>
        on the left side to edit a module
      </div>

      <!-- POPUP TEXT -->

      <div id="popup_module_text" class="popup_edit">
        <div class="header">Edit text module</div>
        <p class="labelInfoCss">Enter the text for this section, format as you wish. If you enter HTML keep in mind that it can break the site</p>

        <div class="popup_edit_container">
          <textarea id="module_text_editor" style="height:600px;"></textarea>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover invertHover popup_save_button">Update in content area</div>
        </div>
      </div>



            <!-- POPUP COLLAPSABLE -->

      <div id="popup_module_collapsable" class="popup_edit">
        <div class="header">Edit collapsable module</div>
        <p class="labelInfoCss">Enter the text for this section, format as you wish. If you enter HTML keep in mind that it can break the site</p>

          <!-- <?
          $colorsArray = $this->bm->get_colors();
          ?>
          <label for="collapsable_color" class="labelCss">Color:</label>
          <select name="collapsable_color" id="collapsable_color" class="ui-rounded1">
            <option value="0">Select a color</option>
            <? foreach($colorsArray as $color) : ?>

            <option value="<?= $color->id?>"><?= $color->name?></option>
            <? endforeach; ?>
          </select>
          <br><br> -->

        <div class="labelCss">Title:</div>
        <div class="popup_edit_container">
          <textarea id="module_colltitle" style="height:300px;"></textarea>
        </div>

         <div class="labelCss">Text:</div>
        <div class="popup_edit_container">
          <textarea id="module_collapsable_editor" style="height:200px;"></textarea>
        </div>

      <div module_type="collapsable" module_id="false" class="popup_upload_button js-repoPopup ui-rounded1 invertHover">Open Repository</div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover invertHover popup_save_button">Update in content area</div>
        </div>
      </div>


      <!-- POPUP QUOTE -->

      <div id="popup_module_quote" class="popup_edit">

        <div class="header">Edit quote module</div>

        <div class="popup_edit_container">
          <div class="labelCss">Quote:</div>
          <div class="labelInfoCss">Enter text that should appear as a quote</div>
          <textarea class="ui-rounded1" id="module_quote_editor"></textarea>

          <div class="labelCss">Author:</div>
          <div class="labelInfoCss">Enter the name of the author. Will be displayed below quote</div>
          <input type="text" id="module_quoteauthor_editor" class="ui-rounded1" name="module_quoteauthor_editor" />

        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP EVENTS -->

      <div id="popup_module_events" class="popup_edit">
        <div class="header">Edit events module</div>
        <div class="popup_edit_container">

          <label for="future_events" style="">Number of items to show(empty or 0 for all)</label>
          <input type="number" id="event_item_number" name="event_item_number" />
          <br /><br />

          <label for="future_events" style="">Show future events?</label>
          <select name="future_events" id="future_events">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>
          <br /><br />

          <label for="future_events" style="">Select tag</label>
          <select class="event_sel" name="event_tag_select" id="event_tag_select" style="">
            <option value="0" selected disabled>Select a tag</option>
            <?
            if(isset($module_event_tags)) {
              foreach ($module_event_tags as $mt) : ?>
              <option value="<?= $mt['id'] ?>"><?= $mt['name']; ?></option>
              <? endforeach;
            }

            ?>
          </select>

        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>
      </div>


      <!-- POPUP HEADLINE -->

      <div id="popup_module_sectiontitle" class="popup_edit">
        <div class="header">Edit headline module</div>

        <div class="popup_edit_container">

          <label for="sectiontitle_size" class="labelCss">Headline type:</label>
          <p class="labelInfoCss">Select the type of headline you would like to use</p>
          <select name="sectiontitle_size" id="sectiontitle_size" class="ui-rounded1">
            <option value="0">Big header</option>
            <option value="1">Sub header</option>
          </select>
          <br><br>

          <label for="" class="labelCss">Text</label>
          <p class="labelInfoCss">Enter the text to be displayed as the headline</p>
          <textarea id="module_sectiontitle_editor" class="ui-rounded1"></textarea>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP DVIDEr -->

      <div id="popup_module_hr" class="popup_edit">
        <div class="header">Edit Divider module</div>

        <div class="popup_edit_container">
          <label for="hr_type" style="">Visible?</label>
          <div class="labelInfoCss">Select if the divider should be a spaceholer (not visible) or an actual line (visible)</div>
          <select name="hr_type" id="hr_display_type" class="ui-rounded1">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>
          <br><br>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP COLUMN START -->

      <div id="popup_module_column_start" class="popup_edit">

        <div class="header">Edit column start module</div>
        <div class="labelInfoCss">Column start indicates the beginning of a column either left or right. All elements between this module and the next „column end“ module will be displayed in the selected column.</div>

        <div class="popup_edit_container">
          <label for="column_type" style="">Layout</label>
          <div class="labelInfoCss">Select the layout type for your column (side left or right, width as percentage)</div>
          <select name="column_type" id="column_start_type" class="ui-rounded1">
            <option selected value="<?= MODULE_COLUMN_LEFT_50 ?>">Left 50%</option>
            <option value="<?= MODULE_COLUMN_RIGHT_50 ?>">Right 50%</option>
          </select>
          <br>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP COLUMN END -->

      <div id="popup_module_column_end" class="popup_edit">
        <div class="header">Nothing to edit here</div>

      </div>


      <!-- POPUP COMMENT -->

      <!-- <div id="popup_module_comment" class="popup_edit">

        <div class="header">Edit comment module</div>
        <br> <br>

        <div class="popup_edit_container">

          <div>author: </div>
          <textarea id="module_commauthor_editor"></textarea>
          <br><br>


          <div>Subtext text: </div>
          <textarea id="module_subtext_editor"></textarea>
          <br> <br>

          <div>Cta text: </div>
          <textarea id="module_cta_editor"></textarea>

          <label for="commLinkInput">Link: </label> <br>
          <input type="text" id="commLinkInput" />
        </div>


        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div> -->


      <!-- POPUP MARQUEE -->

      <div id="popup_module_marquee" class="popup_edit">
        <div class="header">Edit Marquee module</div>

        <div class="popup_edit_container">
          <label for="marquee_type" class="labelCss">Should the marquee be animated?</label>

          <select name="marquee_type" id="marquee_display_type" class="ui-rounded1">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>

          <br><br>

          <div class="labelCss">Marquee text: </div>
          <div class="labelInfoCss">Enter the marquee content. Remember: if it is to short it will repeat.</div>
          <textarea class="ui-rounded1" id="module_marquee_editor"></textarea>
          <br />

          <label class="labelCss" for="marqueeLinkInput">Link: </label>
          <div class="labelInfoCss">Provide a link this marquee should point to. Use absolute urls (incl. https://)</div>
          <input type="text" id="marqueeLinkInput" class="ui-rounded1" />
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP COMMENT -->

      <!-- <div id="popup_module_comment" class="popup_edit">
        <div class="header">Edit Comment module</div>

        <label for="comment_coll_type" style="">Is Collapsable?</label>
        <br> <br>
        <select name="comment_coll_type" id="comment_collapsable_type">
          <option selected value="0">No</option>
          <option value="1">Yes</option>
        </select>
        <br> <br>

        <div>Preview text: </div>
        <div class="popup_edit_container">
          <textarea id="module_comment_previewtext_editor"></textarea>
        </div>
        <br> <br>


        <div>Long text: </div>
        <div class="popup_edit_container">
          <textarea id="module_comment_longtext_editor"></textarea>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div> -->



      <!-- POPUP NEWS -->

      <div id="popup_module_news" class="popup_edit">

        <div class="header">Edit newsletter module</div>

        <div class="popup_edit_container">
          <label for="module_news_editor" class="labelCss">Text</label>
          <textarea id="module_news_editor" class="ui-rounded1"></textarea>

          <label for="newsletterLinkInput">Link: </label>
          <input type="text" class="ui-rounded1" id="newsletterLinkInput" />
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>






      <!-- POPUP DOWNLOAD -->

      <div id="popup_module_download" class="popup_edit">

        <div class="header">Edit Download</div>

        <div class="popup_edit_container">


          <div class="labelCss">Source</div>
          <div class="labelInfoCss">Choose the type of your download link: a single file, a list of files filtered by tags, or a link to an external resource.</div>
          <select name="download_pdf" id="download_source" class="ui-rounded1 js-downloadGroup">
            <option value="0">File</option>
            <option value="1">File tag</option>
            <option value="2">External link</option>
          </select>
          <br><br>


          <div class="downloadGroup" type="0">
            <div class="labelCss">File</div>
            <select name="download_pdf" id="download_pdf" class="ui-rounded1 downloadChange">
            <? foreach($files_array as $p): ?>
              <option value="<?= $p['key'] ?>"><?= $p['value']?></option>
            <? endforeach ?>
            </select>
            <br><br>
          </div>

          <div class="downloadGroup" type="1" >
            <div class="labelCss">File Tag</div>
            <select name="download_tag" id="download_tag" class="ui-rounded1 downloadChange">
            <? foreach($file_tags as $p): ?>
              <option value="<?= $p['key'] ?>"><?= $p['value']?></option>
            <? endforeach ?>
            </select>
            <br><br>
          </div>

          <div class="downloadGroup" type="2">
            <label for="download_path" class="labelCss">External link:</label>
            <div class="labelInfoCss">Use absolute URLS</div>
            <input type="text" name="download_path" id="download_path" value="" class="ui-rounded1 downloadChange" />
            <br> <br>
          </div>

          <!-- <div></div>
          <a href="<?= site_url() . 'entities/Content/files' ?>" target="_blank">
          <div class="browse_button ui-rounded1 invertHover">Browse Files</div>
          </a> -->

          <br />
          <br />



            <!-- <div id="file_upload_button">Upload</div>
            <input id="file_upload_input" type="file" accept="" uploadpath="items/uploads/module_download" />
            <br /> -->
            <!-- <img class="progress" src="<?= site_url('items/backend/img/ajax-loader.gif') ?>" style="display: none;" />
            <br /> -->

          <!-- </div> -->
          <div class="popup_edit_controls">
            <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
          </div>

        </div>
      </div>


      <!-- POPUP NEWSLETTER -->

      <!-- <div id="popup_module_newsletter" class="popup_edit">
        <div class="header">Edit newsletter</div>
        <div class="popup_edit_container"><br />
          <label for="text_wrap">Form title</label>
          <input type="text" name="contact_title" id="newsletter_title" value="" />
          <label for="text_wrap">Firstname label</label>
          <input type="text" name="contact_firstname" id="newsletter_firstname" value="" />
          <label for="text_wrap">Lastname label</label>
          <input type="text" name="contact_lastname" id="newsletter_lastname" value="" />
          <label for="text_wrap">Email label</label>
          <input type="text" name="contact_email" id="newsletter_email" value="" />
          <label for="text_wrap">Button text</label>
          <input type="text" name="contact_button" id="newsletter_button" value="" />

        </div>

        <div class="popup_edit_controls">

          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>

        </div>
      </div> -->



      <!-- POPUP DROPDOWN -->

      <div id="popup_module_dropdown" class="popup_edit">
        <div class="header">Edit dropdown module</div>
        <label for="text_wrap">Title</label>
        <input type="text" name="dropdown_item_text" id="dropdown_title" value="" />
        <br /><br />
        <label for="text_wrap">Sub-title</label>
        <input type="text" name="dropdown_item_text" id="dropdown_sub_title" value="" />
        <br /><br />

        <label for="text_wrap">Content</label><br />
        <div class="popup_edit_container">
          <textarea id="module_dropdown_editor"></textarea>
        </div>
        <div class="popup_edit_controls">
        </div>

      </div>


      <!-- POPUP HEADLINE -->

      <div id="popup_module_headline" class="popup_edit">

        <div class="header">Edit headline module</div>
        <div class="popup_edit_container">
          <textarea id="module_headline_editor"></textarea>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP IMAGE -->

      <div id="popup_module_image" class="popup_edit">

        <div class="header">Edit image module</div>

        <div class="popup_edit_container">
          <label for="text_wrap">Image</label>
          <p class="labelInfoCss">Select an image from the repository that should be displayed here</p>

          <div module_type="image" module_id="false" class="popup_upload_button js-repoPopup ui-rounded1 invertHover">Open Repository</div>

          <br />



          <span for="image_link" class="labelCss">Link</span>
          <p class="labelInfoCss">Add a link this image will point to. If filled out the image will not open in the overlay but redirect to the link provided. Good for sponsor logos. Use absolute urls (incl. https://)</p>
          <input type="text" id="image_link" class="ui-rounded1" name="image_link" />


        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>


      <!-- POPUP GALLERY -->



      <div id="popup_module_gallery" class="popup_edit" >

        <div class="header">Edit Gallery</div>
        <div class="labelInfoCss">Please select images from the repository to add to this module.</div>

        <div class="popup_edit_container">

          <div module_type="gallery" module_id="false" class="popup_upload_button js-repoPopup ui-rounded1 invertHover">Open Repository</div>


          <br>
          <label style="" for="newsletter">Show gallery as a slider?</label>
          <div class="labelInfoCss">Shows gallery as a slider instead of a grid</div>
            <select name="gallery_slider" id="gallery_slider" class="ui-rounded1">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          <br><br>

          <label style="" for="gallery_scale_images">Scale images?</label>
          <div class="labelInfoCss">If yes, images are scaled to fit the frame on the page without cropping. Alternatively images will be cropped</div>
          <select name="gallery_scale_images" id="gallery_scale_images" class="ui-rounded1">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>
          <br>
          <br>
          <br /> <br />
          <div id="popup_edit_gallery_holder"></div>
        </div>


        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>


      </div>

      <!-- POUP RELATED -->

      <div id="popup_module_related" class="popup_edit">

        <div class="header">Edit article list module</div>
        <div class="labelInfoCss">Here you can construct a list of articles that are linked to</div>

        <div class="popup_edit_container">

          <div class="labelCss">Source:</div>
          <div class="labelInfoCss">Select if the source of your list: if Articles are selected you will be able to add singe articles below. If Tags are   selected the system will generate you a list with all the articles tagged with the selected tag
          </div>
          <select name="module_related_type" id="module_related_type" class="ui-rounded1">
            <option value="tag">Tags</option>
            <option value="articles">Articles</option>
          </select>
          <br><br>

          <div class="labelCss">Limit:</div>
          <div class="labelInfoCss">Enter the amount of articles the system should display. If empty it will display all articles found</div>
          <input type="number" id="related_item_number" class="ui-rounded1" name="related_item_number" />
          <br><br>

          <div class="labelCss">Select:</div>
          <div class="tagSelector relSelector">
          <select class="related_sel ui-rounded1" name="related_tag_select" id="related_tag_select" style="display:none" multiple="multiple" data-reorder="1">
            <? foreach ($module_related_general_tags as $mt) : ?>
            <option value="<?= $mt['id'] ?>"><?= $mt['name']; ?></option>
            <? endforeach; ?>
          </select>
          </div>

          <div class="articlesSelector relSelector">
          <select class="related_sel ui-rounded1" name="related_articles_select" id="related_articles_select" style="display:none" multiple="multiple" data-reorder="1">
            <? foreach ($module_related_articles as $ma) : ?>
            <option value="<?= $ma['id'] ?>"><?= $ma['name']; ?></option>
            <? endforeach; ?>
          </select>
          </div>


          <div id="popup_edit_related_holder"></div>

        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>

      </div>

      <!-- POUP START -->

      <div id="popup_module_start" class="popup_edit">
        <div class="header">Edit Start/header module</div>

        <div class="popup_edit_container">

          <label class="labelCss" for="module_start_title">Title</label>
          <input class="ui-rounded1" type="text" id="module_start_title" name="module_start_title" />
          <br /><br />

          <label class="labelCss" for="module_start_title">Image</label>
          <div class="popup_upload_button js-repoContainer ui-rounded1 invertHover">Open Repository</div>

          <img id="pop_start_img" fname="module_image_preview.png" src="" />
          <div class="popup_remove_image_button ui-rounded1 invertHover">Delete Image</div>
          <br /><br />

          <label class="labelCss" for="module_start_title">Image credits</label>
          <textarea class="ui-rounded1" type="text" id="module_start_credits"
            name="module_start_credits"></textarea>
          <br /><br />

          <label class="labelCss" for="module_start_subtitle">Subtitle</label>
          <input class="ui-rounded1" type="text" id="module_start_subtitle" name="module_start_subtitle" />
          <br /><br />

          <label class="labelCss" for="module_start_editor">Introduction text</label>
          <textarea class="ui-rounded1" style="" id="module_start_editor"></textarea>
        </div>

        <div class="popup_edit_controls">
          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>
        </div>


      </div>





      <!-- <div id="popup_module_download" class="popup_edit">
        <div class="header">Edit file</div>
        <div class="popup_edit_container">
          <div id="file_upload_button">Upload</div>
          <input id="file_upload_input" type="file" accept="" uploadpath="items/uploads/module_download" />
          <br />
          <img class="progress" src="<?= site_url('items/backend/img/ajax-loader.gif') ?>" style="display: none;" />
          <br />
          <label for="file_display_name">Text: </label>
          <input type="text" id="file_display_name" name="file_display_name" value=""></input>

        </div>
        <div class="popup_edit_controls">

          <div class="popup_edit_button ui-rounded1 invertHover popup_save_button">Update in content area</div>

        </div>
      </div> -->

      <!-- POPUP VIDEO -->

      <div id="popup_module_video" class="popup_edit">

            <div class="header">Edit video module</div>

            <div class="popup_edit_container">

                <div class="labelCss">Type</div>
                <div class="labelInfoCss">Select the source of your video: Vimeo or YouTube</div>
                <select name="video_type_y" id="video_type_y" class="ui-rounded1">
                  <option selected value="0">Youtube</option>
                  <option value="1">Vimeo</option>
                </select>
                <br><br>

                <label class="labelCss" for="video_url_input">Video URL: </label>
                <div class="labelInfoCss">Insert the code of the video here. If unsure how to get the video, see here.(Here a link to an info page about how to get the codes would be nice)</div>
                <textarea name='video_url_input' id="video_url_input" rows="4" cols="50" class="ui-rounded1"></textarea>
                <br>

                <!-- <div class="vimeo_controls" style="display:none">
                  <div class="labelCss">Controls?: </div>
                  <select name="controls_type" id="video_controls_type" class="ui-rounded1">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                  </select>
                  <br>
                  <br>
                </div> -->

                <div class="labelCss">Autoplay? </div>
                <div class="labelInfoCss">Select if the video should automatically start playing. Videos are muted when autoplayed.</div>
                <select name="autoplay_type" id="video_autoplay_type" class="ui-rounded1">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
                <br><br>

                <label for="video_text_input" class="labelCss">Text: </label>
                <div class="labelInfoCss">Enter a text to be displayed next to the video</div>
                <input type="text" id="video_text_input" class="ui-rounded1"/>

              <br><br>

            </div>

            <div class="popup_edit_controls">
              <div class="popup_edit_button popup_save_button ui-rounded1 invertHover">Update in content area</div>
            </div>

      </div>



      <!-- POPUP HTML -->

      <div id="popup_module_html" class="popup_edit">
        <div class="header">Edit HTML module</div>
        <div class="popup_edit_container">
          <div class="labelCss">Code</div>
          <div class="labelInfoCss">Please enter the code you have been provided with. Please keep in mind, saving wrong syntax HTML can break the page</div>
          <textarea class="ui-rounded1" style="height: 300px;"></textarea>
        </div>
        <div class="popup_edit_controls">
              <div class="popup_edit_button popup_save_button ui-rounded1 invertHover">Update in content area</div>
        </div>
      </div>


      <!-- <div id="detail_img_dialog" title="What do you want to do?">
        <p>Do you want to upload a new image or do you want to delete the current one?
      </div> -->


      <!-- POUP PDF -->

      <div id="popup_module_pdf" class="popup_edit">

        <div class="header">Edit PDF</div>

          <div class="popup_edit_container">

            <div class="labelCss">Select which type of file you want to upload.<br /> You can also add a title text.<br />
              Remember to click "Save" before you leave.</div>

            <!--<label for="pdf_type">Type: </label>  -->
            <select id="pdf_type" name="pdf_type" style="display:none">
              <option value="PDF" selected>PDF</option>
              <option value="ZIP">ZIP</option>
            </select>
            <br /><br />

            <!-- <div id="pdf_upload_button">Upload PDF</div> -->
            <input id="pdf_upload_input" type="file" accept=".pdf,.zip,.jpg,.jpeg,.png"
              uploadpath="items/uploads/module_pdf" />

            <div id="upload_progress"></div>
            <div style="display:none">
              <label>Cover image<br />(This is optional. If you don't select a cover image, an icon will be
                displayed.)</label>
              <div class="popup_upload_button js-repoContainer ui-rounded1 invertHover">Open Repository</div>
              <img id="pdf_image" fname="" src="" />
              <div class="popup_remove_image_button">Delete Image</div>
            </div>
            <br /><br />

          <label for="pdf_display_name">File Title: </label>
          <textarea id="pdf_display_name" name="pdf_display_name" value=""
            style="resize:none;width:300px;height:50px;"></textarea>
          <br /><br />

          <div style="display:none">
            <label for="pdf_display_text">PDF text: </label>
            <textarea id="pdf_display_text" name="pdf_display_text" value=""
              style="resize:none;width:300px;height:100px;"></textarea>
            <br /><br />
            <label for="pdf_button_text">Button text: </label>
            <input type="text" id="pdf_button_text" name="pdf_button_text" value="" style="" value="Herunterladen" />
          </div>

        </div>


        <div class="popup_edit_controls">
          <div class="popup_edit_button popup_save_button">Update in content area</div>
        </div>

      </div>



      <!-- POPUP END -->





</div>