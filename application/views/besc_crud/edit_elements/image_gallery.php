<td <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_td_image_gallery">
  <div class="bc_image_gallery_container">
    <?php foreach ($items->result() as $item) : ?>
    <a href="<?= site_url($uploadpath  . '/' . $item->$fname) ?>" data-lightbox="gallery_<?= $item->gallery_id ?>">
      <img class="bc_table_image_gallery_preview" src="<?= site_url($uploadpath  . '/' . $item->$fname) ?>" />
    </a>
    <?php endforeach; ?>
  </div>
</td>