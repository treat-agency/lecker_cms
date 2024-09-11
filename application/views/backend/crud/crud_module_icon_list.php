

      <style>


        #content {
            padding: 0 !important;
            margin-top: 60px;
            height: calc(100vh - 150px);
        }

        .bothEditors {
            position: relative;
        }

        #edit_title_text {
            font-size: 24px;
        }

        #module_editor {
            width: 100%;
            min-height: 100vh;
        }





      </style>




      <div id="control_container" class="controlContainer">
        <div class="bold">MODULES</div>

        <div id="module_container">
          <!-- moduleset -->
          <!-- add moddule icon -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Headline" type="headline"><img class="module_icon" src="<?= site_url('items/backend/icons/mSectionIcon.svg') ?>" /><span>Headline</span></div> -->

            <div class="unselectable basicButton moduleMaker" title="Section title" type="sectiontitle"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mSectionIcon.svg') ?>" /><span>Headline</span></div>

            <div class="unselectable basicButton moduleMaker" title="Text" type="text"><img class="module_icon"
              src="<?= site_url('items/backend/icons/mTextIcon.svg') ?>" /><span>Text</span></div>
              
            <div class="unselectable basicButton moduleMaker" title="Collapsable" type="collapsable"><img class="module_icon"
              src="<?= site_url('items/backend/icons/mTextIcon.svg') ?>" /><span>Collapsable</span></div>

            <div class="unselectable basicButton moduleMaker" title="Image" type="image"><img class="module_icon"
              src="<?= site_url('items/backend/icons/mImageIcon.svg') ?>" /><span>Image</span></div>

            <!-- <div class="unselectable basicButton moduleMaker moduleMaker" title="Start" type="start"><img class="module_icon"
              src="<?= site_url('items/backend/icons/mStartIcon.svg') ?>" /><span>Start</span></div> -->

            <div class="unselectable basicButton moduleMaker" title="Marquee" type="marquee"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mMarqueeIcon.svg') ?>" /><span>Marquee</span></div>

            <!-- <div class="unselectable basicButton moduleMaker" title="News" type="news"><img class="module_icon newIcon"
                  src="<?= site_url('items/backend/icons/mNewsIcon.svg') ?>" /><span>News</span></div> -->

            <div class="unselectable basicButton moduleMaker" title="Gallery" type="gallery"><img class="module_icon"
                  src="<?= site_url('items/backend/icons/mGalleryIcon.svg') ?>" /><span>Gallery</span></div>

            <div class="unselectable basicButton moduleMaker" title="Quote" type="quote"><img class="module_icon newIcon"
                      src="<?= site_url('items/backend/icons/mQuoteIcon.svg') ?>" /><span>Quote</span></div>

            <div class="unselectable basicButton moduleMaker" title="Vimeo Video" type="video"><img class="module_icon"
                src="<?= site_url('items/backend/icons/mVideoIcon.svg') ?>" /><span>Vimeo Video</span></div>

            <div class="unselectable basicButton moduleMaker" title="HTML" type="html"><img class="module_icon"
                src="<?= site_url('items/backend/icons/mHtmlIcon.svg') ?>" /><span>HTML</span></div>

            <div class="unselectable basicButton moduleMaker" title="Horizontal line" type="hr"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mHRIcon.svg') ?>" /><span>Divider</span></div>

            <div class="unselectable basicButton moduleMaker" title="Related list" type="related"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mRelListIcon.svg') ?>" /><span>Article list</span></div>

            <div class="unselectable basicButton moduleMaker" title="Column START" type="column_start"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mColStartIcon.svg') ?>" /><span>Column START</span></div>

            <div class="unselectable basicButton moduleMaker" title="Column END" type="column_end"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/mColEndIcon.svg') ?>" /><span>Column END</span></div>

            <div class="unselectable basicButton moduleMaker" title="Download" type="download"><img class="module_icon"
              src="<?= site_url('items/backend/icons/tableIcons/tableIcon-download.svg') ?>" /><span>Download</span></div>

            <!-- <div class="unselectable basicButton moduleMaker" title="Comment" type="comment"><img class="module_icon newIcon" src="<?= site_url('items/backend/icons/') ?>" /><span>Start</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Events" type="event"><img class="module_icon newIcon"
              src="<?= site_url('items/backend/icons/') ?>" /><span>Events</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Bubble" type="bubble"><img class="module_icon newIcon" src="<?= site_url('items/backend/icons/') ?>" /><span>Start</span></div>

		    <div class="unselectable basicButton moduleMaker" title="Box" type="box"><img class="module_icon" src="<?= site_url('items/backend/icons/ns-box.png') ?>" /><span>Start</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Ticket" type="ticket"><img class="module_icon"
              style="border: 1px solid black" src="<?= site_url('items/backend/icons/ket-100.png') ?>" /><span>Ticket</span></div> -->

            <!--<div class="unselectable basicButton moduleMaker" title="Dropdown" type="dropdown"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Dropdown</span></div>

		    <div class="unselectable basicButton moduleMaker" title="Contact" type="contact"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Contact</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Newsletter" type="newsletter"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Newsletter</span></div> -->

            <!--   <div class="unselectable basicButton moduleMaker" title="Event" type="tour"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Event</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Download" type="download"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Download</span></div> -->

            <!-- <div class="unselectable basicButton moduleMaker" title="Two Columns" type="2column"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Two Columns</span></div> -->

            <!-- 	<div class="unselectable basicButton moduleMaker" title="Artwork" type="artwork"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Artwork</span></div>

		    <div class="unselectable basicButton moduleMaker" title="Quote" type="quote"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Quote</span></div>

            <div class="unselectable basicButton moduleMaker" title="Shop" type="shop"><img class="module_icon" src="<?= site_url('items/backend/icons/') ?>" /><span>Shop</span></div>
					-->



            <div id="button_container">
                <div class="unselectable basicButton item_preview" title="Preview" type="html"><img class="module_icon"
                src="<?= site_url('items/backend/icons/mPreview.svg') ?>" /><span>Preview</span></div>
            </div>

        </div>

      </div>