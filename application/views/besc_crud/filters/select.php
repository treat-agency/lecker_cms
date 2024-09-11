<div class="bc_filter basicButton" col_name="<?= $db_name ?>" type="<?= $type ?>">

    <select placeholder="" name="<?= $db_name ?>"> <?= $filter_value ?>

        <?php foreach ($options as $option) : ?>
            <option value="<?= $option['key'] ?>" <?php if ($filter_value == $option['key'] && $filter_value != '') echo "SELECTED"; ?>>
                <?= $option['value'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>