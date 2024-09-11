
<script>
var item_parent_type = <?= (isset($parent)) ? $parent : 0; ?>;
  var module_names = <?= json_encode($module_names) ?>;
</script>


<link rel="stylesheet" type="text/css" href="<?= site_url("items/besc_crud/css/crud_edit.css?ver=" . VERSION); ?>">

<link rel="stylesheet" type="text/css" href="<?= site_url("items/besc_crud/css/_bescCrud.css?ver=" . time()); ?>">

<script type="text/javascript" src="<?= site_url("items/backend/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/backend/ckeditor/adapters/jquery.js"); ?>"></script>

<!-- <script type="text/javascript" src="<?= site_url("items/backend/js/_backend.js?ver=" .time()); ?>"></script> -->

<script type="text/javascript" src="<?= site_url("items/backend/js/edit.js?ver=" . VERSION); ?>"></script>
<script type="text/javascript" src="<?= site_url("items/backend/js/repo.js?ver=" . VERSION); ?>"></script>





<div id="content">

  <div class="bc_message_container modulesEditMessage"></div>


  <?php if ($show_mods): ?>

    <style>

      #content {
        top: 0;
        overflow: hidden;
      }

      .bc_edit_table {
        padding: 0 !important;
        max-height: calc(100vh - 160px);
        overflow-y: scroll;
      }



    </style>



  <?php endif; ?>

  <? include (APPPATH . 'views/backend/' . "repo_upload.php"); ?>
