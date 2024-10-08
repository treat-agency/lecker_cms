<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow <?php endif; ?>" col_name="<?= $db_name ?>">
  <p class="bc_column_header"><?= $display_as ?>:</p>
  <?php if (isset($col_info) && $col_info != "") : ?>
  <p class="bc_column_info">
    <i><?= $col_info ?></i>
  </p>
  <?php endif; ?>
  <div class="bc_column_input bc_col_multiline">
    <?php if (count($formatting) > 0) : ?>
    <div class="bc_col_multiline_formatting">
      <?php foreach ($formatting as $button) : ?>
      <div class="bc_col_multiline_formatting_button" tag="<?= $button ?>">
        <?= strtoupper($button) ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <textarea name="col_<?= $db_name ?>"
      style="<?php if (isset($height)) echo 'height: ' . $height . 'px;'; ?> <?php if (isset($width)) echo 'width: ' . $width . 'px;'; ?>"><?php if (isset($value)) echo $value; ?></textarea>
  </div>
  <div class="bc_error_text"></div>
</div>