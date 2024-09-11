<td>
        <?php foreach ($n_values->result() as $n_value) : ?>
                <span class="bc_m_n_element"><?= $n_value->$table_n_value?>
                <?= isset($n_value->$table_n_value2) ? " (" . $n_value->$table_n_value2 . ")" : ""; ?></span>
        <?php endforeach; ?>
</td>