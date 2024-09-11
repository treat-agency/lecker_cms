  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/fonts.css"); ?>">

<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/lightbox.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.theme.css"); ?>">


<script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-1.11.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-ui.min.js"); ?>"></script>

<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud.js?ver=" . VERSION); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/besc_crud/js/besc_crud_ordering.js"); ?>"></script>

<script>
    <?php foreach ($bc_urls as $key => $value) : ?>
        var <?= $key ?> = "<?= $value ?>";
    <?php endforeach; ?>
</script>

<div class="bc_message_container"></div>

<div class="bc_title"><?= $title ?> sorting</div>

<div class="bc_ordering_info">Drag & Drop the elements in the desired order.</div>

<?php if (count($items) > 0) : ?>
    <ul class="bc_ordering_container">
        <?php foreach ($items as $item) : ?>
            <li class="bc_ordering_item" item_id="<?= $item['id'] ?>"><?= $item['value'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <div class="bc_ordering_noitems">Nothing to sort.</div>
<?php endif; ?>

<div class="bc_column_actions">
    <ul>
        <?php if (count($items) > 0) : ?>
            <li class="bc_ordering_save">Save</li>
        <?php endif; ?>
        <li class="bc_ordering_cancel">Back to list</li>
    </ul>
</div>