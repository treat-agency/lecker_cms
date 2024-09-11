<style>
  .crudInfo {
    display: none;
  }
</style>

<?


$public = 1;
if(isset($image) && $image){
  $public = $image->public;
} elseif(isset($value) && $value){
  $image = (object) array('fname' => $value);
}
?>

<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $db_name ?>">
  <p class="bc_column_header"><?= $display_as ?>:</p>

  <?php if (isset($col_info) && $col_info != "") : ?>
    <p class="bc_column_info">
      <i><?= $col_info ?></i>
    </p>
  <?php endif; ?>

  <div class="bc_column_input bc_col_image" <?php if ($js_callback_after_upload != "") : ?>
    callback_after_upload="<?= $js_callback_after_upload ?>" <?php endif; ?>>

    <?php if (!isset($value) || $value == "") : ?>
      <input type="hidden" name="col_<?= $db_name ?>" class="bc_col_fname" value="" />
      <input type="file" name="col_<?= $db_name ?>_file" class="<? if (strpos($accept, 'pdf') !== false) {
																			echo " bc_col_file_file"; } else { echo "bc_col_image_file" ; } ?>" id="col_<?= $db_name ?>_file"
    <?php if (isset($accept)) : ?> accept="<?= $accept ?>" <?php endif; ?> uploadpath="<?= $uploadpath ?>" />
      <input type="button" class="bc_col_image_upload_btn ui-rounded1" value="Upload" />
      <a href="" data-lightbox="<?= $db_name ?>">
        <img class="bc_col_image_preview <?= $public != 1 ? 'unPublicImage' : '' ?>" src="" />
      </a>
      <span class="bc_col_image_delete ui-rounded1">Delete</span>
      <div class="bc_col_image_size"></div>

    <?php else : ?>
      <input type="hidden" name="col_<?= $db_name ?>" class="bc_col_fname" value="<?= $value ?>" />
      <input type="file" name="col_<?= $db_name ?>_file" class="<?= strpos($accept, 'pdf') !== false ? "bc_col_file_file" : "bc_col_image_file"; ?>"
      id="col_<?= $db_name ?>_file" <?php if (isset($accept)) : ?> accept="<?= $accept ?>" <?php endif; ?>
      uploadpath="<?= $uploadpath ?>" />
      <input type="button" class="bc_col_image_upload_btn" value="Upload" style="display: none;" />
      <a href="<?= $hostUrl . $uploadpath . $value; ?>" data-lightbox="<?= $db_name ?>">
        <? if (strpos($accept, 'pdf') !== false) : ?>
          <div class="bc_col_image_preview <?= $public != 1 ? 'unPublicImage' : '' ?>" style="display: inline;" src="<?= site_url($uploadpath . $value) ?>">
            <?= site_url($uploadpath . $value) ?>
          </div>
        <? else : ?>
          <img class="bc_col_image_preview <?= $public != 1 ? 'unPublicImage' : '' ?>" style="display: inline;" src="<?= $hostUrl . $uploadpath . 'thumbs/' . $image->fname; ?>" />
        <? endif; ?>
      </a>

      <span class="bc_col_image_delete" style="display: block;">Delete</span>
      <div class="bc_col_image_size">Size:
        <? $sizes = getimagesize($hostUrl . $uploadpath . $value);  echo ($sizes!=false)? $sizes[0]."x".$sizes[1] : '';?>
      </div>

    <?php endif; ?>

  </div>

  <div class="bc_error_text"></div>
</div>