<?php
header('Content-Type: application/xml');
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' ?>
<?php foreach ($pages as $page) : ?>

    <?= '<url>' ?>

        <?= '<loc>' . site_url('') . $page . '</loc>' ?>

        <?= '<lastmod>' . date('Y-m-d') . '</lastmod>' ?>

    <?= '</url>' ?>

<?php endforeach; ?>
<?= '</urlset>' ?>