<div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
  class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $relation_id ?>">
  <p class="bc_column_header"><?= $display_as ?>:</p>
  <?php if (isset($col_info) && $col_info != "") : ?>
  <p class="bc_column_info">
    <i><?= $col_info ?></i>
  </p>
  <?php endif; ?>
  <div class="bc_column_input bc_col_m_n" m_n_relation_id="<?= $relation_id ?>">
    <div class="bc_m_n_selected <?php if (($num_row) % 2 == 1) : ?>erow<?php endif; ?>"
      style="<?php if (isset($box_width)) : ?>width: <?= $box_width ?>px;<?php endif; ?><?php if (isset($box_height)) : ?>height: <?= $box_height ?>px;<?php endif; ?>">
      <?php if ($filter) : ?>
      <div class="bc_m_n_filterbox" parent="sel">
        <input type="text">
      </div>
      <?php endif; ?>
      <?php foreach ($selected->result() as $sel) : ?>

      <?php if ($show_name) : ?>
      <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_sel"
        n_id="<?= $sel->$table_mn_col_n ?>"><?= $sel->$table_mn_display ?></span>
      <?php else : ?>
      <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_sel"
        n_id="<?= $sel->$table_mn_col_n ?>"><?= $sel->$table_n_value ?></span>
      <?php endif; ?>

      <?php endforeach; ?>
    </div>
    <div class="bc_m_n_avail <?php if (($num_row) % 2 == 1) : ?>erow<?php endif; ?>"
      style="<?php if (isset($box_width)) : ?>width: <?= $box_width ?>px;<?php endif; ?><?php if (isset($box_height)) : ?>height: <?= $box_height ?>px;<?php endif; ?>">
      <?php if ($filter) : ?>
      <div class="bc_m_n_filterbox" parent="av">
        <input type="text">
      </div>
      <?php endif; ?>
      <?php foreach ($avail->result() as $av) : ?>

      <?php if ($show_name) : ?>
      <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_av"
        n_id="<?= $av->$table_n_pk ?>"><?= $av->$table_mn_display ?></span>
      <?php else : ?>
      <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_av"
        n_id="<?= $av->$table_n_pk ?>"><?= $av->$table_n_value ?></span>
      <?php endif; ?>

      <?php endforeach; ?>
    </div>
  </div>
  <div class="bc_error_text"></div>
</div>