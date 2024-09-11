<div style="margin-top:100px;padding-bottom:10px; border-bottom:1px solid black;margin-bottom:20px;">
	<?= $item->name ?>
</div>

<div id="social_image_holder">

	<?php  if($item->img != NULL && $item->img != ''):?>
		<img class="social_image_item" src="<?= site_url('items/uploads/images/'.$item->img)?>"/>
	<?php endif;?>

	<?php  foreach($images as $image):?>
		<img class="social_image_item" src="<?= site_url('items/uploads/images/'.$image['fname'])?>"/>
	<?php endforeach;?>
</div>

<div id="social_text_holder">
	Templates:<br/>
	<br/>
	<?php foreach($texts as $text):?>
		<div class="social_text_item"><?= $text ?></div>
	<?php endforeach;?>
	
</div>


<div id="social_tags_holder">
	<?php foreach($tags as $tag):?>
		<div class="social_tag_item"><?= $tag ?></div>
	<?php endforeach;?>
</div>