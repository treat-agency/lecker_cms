<!--  **************   HEAD *****************     -->

<?php
$p = $_SERVER['REQUEST_URI'];
?>
<!-- CSS -->

<link rel="stylesheet" type="text/css" href="<?= site_url("items/frontend/css/detail.css?ver=" . time()); ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url("items/frontend/css/_detail.css?ver=" . time()); ?>">

<!-- JS -->



<!-- SCRIPTS DETAIL -->



<!-- PROCESSING DATA -->

<?

// product info
if (isset($product) && $product) {


	$name = $this->language == SECOND_LANGUAGE ? $product->name_en : $product->name;
	$price_net = $product->price_net;
	$description = $this->language == SECOND_LANGUAGE ? $product->description_en : $product->description;
	$amount = $product->amount;
	$sizes = array();
	$colors = array();

	foreach ($product->versions as $v) {
		if ($v->size) {
			$sizes[] = $v->size;
		} elseif ($v->color) {
			$colors[] = $v->color;
		}
	}

	$teaser_images = array();

	foreach ($product->teaser_images as $ti) {
		$teaser_images[] = $ti->img_path;
	}


}


?>


<div class="detContainer genPadding smallContainerWidth">
	
	<!-- WHATEVER COMES BEFORE MODULES -->
	
	<div class="detTitle h1">
		<?= $item->entity->name ?>
	</div>
	
	
	<!-- MODULES -->
	
	<? include(APPPATH . 'views/frontend/tools/modules.php') ?>
	
	<!-- WHATEVER COMES AFTER MODULES -->


</div>