<?php
if (!function_exists("get_relation_val")) {
	function get_relation_val($relation_element, $n_value, $n_value2)
	{
		$total_val = '';

		if ($n_value2 && $n_value2 != "") {
			$val2 = '';
			$vals2 = [];

			$vals = explode(",", $n_value2);
    foreach ($vals as $val1) {
				if (trim($relation_element->$val1) != "") {
					$vals2[] = trim($relation_element->$val1);
				}
			}

			$val2 = count($vals2) != 0 ? " (" . implode(',', $vals2) . ")" : '';
		}
		$total_val = $relation_element->$n_value . $val2;
		return $total_val;
	}
}

?>


<div class="itemField">

  <div <?= ($controlled_by) ? 'controlled_by="' . $controlled_by . '" controlled_id="' . $controlled_id . '"' : ''; ?>
    class="bc_column <?php if (($num_row) % 2 == 0) : ?>erow<?php endif; ?>" col_name="<?= $relation_id ?>">
    <p class="bc_column_header"><?= $display_as ?>:</p>
    <?php if (isset($col_info) && $col_info != "") : ?>
    <p class="bc_column_info">
      <i><?= $col_info ?></i>
    </p>
    <?php endif; ?>
  
    <div class="bc_column_input bc_col_m_n ui-rounded1" m_n_relation_id="<?= $relation_id ?>">
  
      <div id="magicsuggest_<?= $relation_id ?>"></div>
      <div class="bc_m_n_selected  <?php if (($num_row) % 2 == 1) : ?>erow<?php endif; ?>" style="display: none;">
        <?php if ($filter) : ?>
        <div class="bc_m_n_filterbox" parent="sel_<?= $num_row ?>">
          <input type="text">
        </div>
        <?php endif; ?>
  
  
  
        <?php foreach ($selected->result() as $sel) : ?>
  
        <?php if ($show_name) : ?>
        <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_sel_<?= $num_row ?>  bc_m_n_sel"
          n_id="<?= $sel->$table_mn_col_n ?>"><?= $sel->$table_mn_display ?></span>
        <?php else :
  
          ?>
        <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_sel_<?= $num_row ?>  bc_m_n_sel"
          n_id="<?= $sel->$table_mn_col_n ?>"><?= get_relation_val($sel, $table_n_value, $table_n_value2) ?></span>
        <?php endif; ?>
  
        <?php endforeach; ?>
      </div>
      <div class="bc_m_n_avail <?php if (($num_row) % 2 == 1) : ?>erow<?php endif; ?>" style="display: none;">
        <?php if ($filter) : ?>
        <div class="bc_m_n_filterbox" parent="av_<?= $num_row ?>">
          <input type="text">
        </div>
        <?php endif; ?>
        <?php foreach ($avail->result() as $av) : ?>
  
        <?php if ($show_name) : ?>
        <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_av_<?= $num_row ?>  bc_m_n_av"
          n_id="<?= $av->$table_n_pk ?>"><?= $av->$table_mn_display ?></span>
        <?php else :
  
  
          ?>
        <span class="bc_m_n_element bc_m_n_element_edit bc_m_n_av_<?= $num_row ?>  bc_m_n_av"
          n_id="<?= $av->$table_n_pk ?>"><?= get_relation_val($av, $table_n_value, $table_n_value2) ?></span>
        <?php endif; ?>
  
        <?php endforeach; ?>
      </div>
    </div>
    <div class="bc_error_text"></div>
  </div>


</div>



<script>
var available_<?= $relation_id ?> = [];
var selected_<?= $relation_id ?> = [];
<?php foreach ($avail->result() as $av) :


	?>

var item = {
  id: "<?= $av->$table_n_pk; ?>",
  name: "<?= htmlentities(get_relation_val($av, $table_n_value, $table_n_value2), ENT_QUOTES); ?>"
};
available_<?= $relation_id ?>.push(item);
<?php endforeach; ?>

<?php foreach ($selected->result() as $sel) :

	?>
var item = {
  id: "<?= $sel->$table_n_pk; ?>",
  name: "<?= htmlentities(get_relation_val($sel, $table_n_value, $table_n_value2), ENT_QUOTES); ?>"
};
selected_<?= $relation_id ?>.push(item);
<?php endforeach; ?>


$(document).ready(function() {
  var this_magic_<?= $relation_id ?> = $('#magicsuggest_<?= $relation_id ?>').magicSuggest({
    allowFreeEntries: false,
    data: available_<?= $relation_id ?>,
    expandOnFocus: true
  });

  this_magic_<?= $relation_id ?>.addToSelection(selected_<?= $relation_id ?>);

  $(this_magic_<?= $relation_id ?>).on('selectionchange', function(e, m) {

    var parent = $('.bc_col_m_n[m_n_relation_id="<?= $relation_id ?>"]');

    parent.find('.bc_m_n_sel').each(function(i, item) {

      $(item).click();
    })


    var values = this.getValue();

    $.each(values, function(x, val) {
      parent.find('.bc_m_n_av[n_id="' + val + '"]').click();
    });

  });


});
</script>