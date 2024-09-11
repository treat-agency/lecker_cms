
<script>  </script>


<div class="bc_filter basicButton" col_name="<?= $db_name ?>" type="<?= $type ?>">
      <select name="<?= $db_name ?>">
      <? foreach($values as $value) : ?>
            <? if ($value == "") : ?>
            <option value="" <?php if ($filter_value == $value) : ?>selected<?php endif; ?>>All <?= $pretty_name_plural ?></option>
           <? else: ?>
            <option value="<?= $value ?>" <?php if ($filter_value == $value) : ?>selected<?php endif; ?>><?= $value ?></option>
            <? endif; ?>
      <? endforeach; ?>
     </select>
      <!-- <p class="bc_filter_header"><?= $display_as ?>:</p> -->
      <!-- <input placeholder="<?= $display_as ?>" type="text" name="<?= $db_name ?>" value="<?php if ($filter_value != '') : ?><?= $filter_value ?><?php endif; ?>"> -->
</div>
