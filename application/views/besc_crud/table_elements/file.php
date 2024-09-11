<td>
    <? if ($filename != '') : ?>
        <a href="<?= $uploadpath  . '/' . $filename; ?>">
            <?= $filename ?>
        </a>
        <br>
        <!-- <iframe class='table_file_preview' src="<?= $uploadpath  . '/' . $filename; ?>" allowfullscreen="true" loading='lazy'></iframe> -->
    <? endif ?>
</td>