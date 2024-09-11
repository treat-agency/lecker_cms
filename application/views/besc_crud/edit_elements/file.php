<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $db_name ?>">
  <p class="bc_column_header"><?= $display_as ?>:</p>
  <?php if (isset($col_info) && $col_info != "") : ?>
  <p class="bc_column_info">
    <i><?= $col_info ?></i>
  </p>
  <?php endif; ?>
  <div class="bc_column_input bc_col_file" <?php if ($js_callback_after_upload != "") : ?>
    callback_after_upload="<?= $js_callback_after_upload ?>" <?php endif; ?>>
    <?php if (!isset($value) || $value == "") : ?>
    <input type="hidden" name="col_<?= $db_name ?>" class="bc_col_fname" value="" />
    <input type="file" name="col_<?= $db_name ?>_file" class="bc_col_file_file" id="col_<?= $db_name ?>_file"
      <?php if (isset($accept)) : ?> accept="<?= $accept ?>" <?php endif; ?> uploadpath="<?= $uploadpath ?>" />
    <input type="button" class="bc_col_file_upload_btn ui-rounded1" value="Upload" />
    <a target="_blank" href="">
      <div class="bc_col_file_preview" style="display: inline;">

      </div>
    </a>
    <span class="bc_col_file_delete ui-rounded1">Delete</span>
    <?php else : ?>
    <input type="hidden" name="col_<?= $db_name ?>" class="bc_col_fname" value="<?= $value ?>" /> <input type="file"
      name="col_<?= $db_name ?>_file" class="bc_col_file_file" id="col_<?= $db_name ?>_file"
      <?php if (isset($accept)) : ?> accept="<?= $accept ?>" <?php endif; ?> uploadpath="<?= $uploadpath ?>" />
    <input type="button" class="bc_col_file_upload_btn ui-rounded1" value="Upload" style="display: none;" />
    <a target="_blank" href="<?= site_url($uploadpath . $value) ?>" title="<?= $db_name ?>">
      <div class="bc_col_file_preview" style="display: inline;" src="<?= site_url($uploadpath . $value) ?>">
        <?= $value ?>
      </div>
    </a>
    <span class="bc_col_file_delete" style="display: block;">Delete</span>
    <?php endif; ?>
  </div>
  <div class="bc_error_text"></div>
</div>