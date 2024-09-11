<td class="bc_td_image">
  <?php if($filename != "" && $filename !== null): ?>
  <a href="<?= $uploadpath  . '/' . $filename ;?>" data-lightbox="<?= $filename?>">
    <img class="table_image_preview <?= $public != 1 ? 'unPublicImage' : '' ?>" src="<?= $uploadpath  . '/' .  'thumbs/' . $filename ?>" />
  </a>
  <!-- if the size is false than no size -->
  <div style="text-align:center;">
    <? $sizes = getimagesize($uploadpath  . '/' . rawurlencode($filename));  echo ($sizes!=false)?  $sizes[0]."x".$sizes[1] : '';?>
  </div>
  <?php endif; ?>
</td>