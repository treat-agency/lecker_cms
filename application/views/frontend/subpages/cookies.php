
<div id="cookie_overview" style="background:gainsboro" >
      <div class="cookie95p">
        <div class="cookie1000">
          <div class="cookieLeft">
            <div class="cookieHeader"><?= $this->lang->line('cookie_title') ?></div>
            <div class="cookie_warning_text">
              <?= $this->lang->line('cookie_text') ?>
            </div>
            <!-- <button class="ok" id="cookie_consent">
                <?= $this->lang->line('cookie_btn') ?>
            </button> -->
            <div class="cookieButtonHolder">
              <div class="cookieSelect cookieButtonRelHolder">
                <input id="cookie_nec_check" class="necButton roundButton" type="checkbox" name="cookie_nec" <?= $cookie_warning === "true" ? 'checked' : '' ?>
                  >
                <label class="necText" for="cookie_nec"><?= $this->lang->line('cookie_nec') ?></label>
              </div>
              <div class="cookieSelect cookieButtonMarkHolder">
                <input id="cookie_mark_check" <?= $cookie_mark === 'true' ? 'checked' : '' ?> class="markButton roundButton" type="checkbox" name="cookie_mark">
                <label class="markText" for="cookie_mark"><?= $this->lang->line('cookie_mark') ?></label>
              </div>
            </div>



          </div>
          <div class="cookieRight">
            <button class="cookieHover cookieSave"><?= $this->lang->line('cookie_save') ?></button>
            <button class="cookieHover cookieAcceptAll"><?= $this->lang->line('cookie_acc_all') ?></button>
          </div>
        </div>
      </div>
    </div>
