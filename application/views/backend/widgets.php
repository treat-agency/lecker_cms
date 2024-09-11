<?php if($shop_widgets) : ?>

<?php endif ?>


<?php foreach ($default_widgets as $widget) : ?>

		<!-- the box black frame -->
		<div class="boxin">

			<!-- color flag if exists -->
			<!-- <div class="box_flag">
				<div class="color_flag" style="background-color: <?= $widget->color ?>"></div>
			</div> -->
			<!-- <div class="box_title"><?= $widget->title ?></div> -->


			<div class="box_content">
				<div class="boxAmount">
					<?= $widget->count ?>
				</div>
				<div class="box_content_text ">
					<?= $widget->text ?>
				</div>

			</div>


			<div class="widgetButtons">
				<a href="<?= $widget->url ?>" target="_blank">
					<div class="basicButton invertHover edit_button ">
						Edit
					</div>
				</a>

				<? if(isset($widget->url_categories)): ?>
				<a href="<?= $widget->url_categories ?>" target="_blank">
					<div class="basicButton invertHover edit_button ">
						Categories
					</div>
				</a>
				<? endif ?>

				<? if(isset($widget->url_tags)): ?>
				<a href="<?= $widget->url_tags ?>" target="_blank">
					<div class="basicButton invertHover edit_button">
						Tags
					</div>
				</a>
				<? endif ?>
			</div>


		</div>
<?php endforeach; ?>



<? foreach ($widgets as $widget) : ?>
		<!-- <center class="box_icon"><img src="<?= site_url('items/backend/img/' . $widget->img) ?>"></center> -->


		<!-- the box black frame -->
		<div class="boxin">


			<!-- color frame if exists -->
			<?php if ($widget->color != '') : ?>
				<!-- <div class="box_flag">
					<div class="color_flag" style="background-color:<?= $widget->color ?>"></div>
				</div> -->
			<?php endif; ?>




			<!-- <div wid="<?= $widget->id; ?>" class="widget_remove">
			<img src="<?= site_url('items/backend/img/x.svg') ?>">
		</div> -->


			<!-- <section> -->
			<!-- <div class="box_title"><?= $widget->category ?></div> -->
			<? if ($widget->subpage == 'image_overwatch' &&  $widget->category != 'Ansichtskarte') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Images waiting approval: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center">
						<? if ($widget->category == 'Bildlandschaften') {
							echo $pending_images;
						} else if ($widget->category == 'Heldenplatz') {
							echo $pending_images_heldenplatz;
						} else {
							echo $pending_images_multi;
						} ?>
					</div>
				</div>


			<? elseif ($widget->subpage == 'contact_forms') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Open contacts: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_contacts; ?></div>
				</div>


			<? elseif ($widget->subpage == 'overview_guides' || $widget->subpage == 'tours') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Open tours: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_tours; ?></div>
				</div>


			<? elseif ($widget->subpage == 'pendingVideos') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Videos waiting approval: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_videos; ?></div>
				</div>


			<? else : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize"><?= $widget->subpage; ?></h2>
					<div style="margin-top:20px;font-style:italic"><?= $widget->short_text; ?></div>
				</div>


			<? endif; ?>


			<div class="widgetButtons">
				<a href="<?= site_url('entities/' . $widget->category . '/' . $widget->subpage) ?>">
					<div class="edit_button ui button">
						Edit
					</div>
				</a>
			</div>
			<!-- </section> -->
		</div>
<? endforeach; ?>

<?php foreach ($new_widgets as $widget) : ?>

		<!-- the box black frame -->
		<div class="boxin">

			<!-- color flag if exists -->
			<!-- <div class="box_flag">
				<div class="color_flag" style="background-color: <?= $widget->color ?>"></div>
			</div> -->
			<!-- <div class="box_title"><?= $widget->title ?></div> -->


			<div class="box_content">
				<div class="boxAmount">
					<?= $widget->count ?>
				</div>
				<div class="box_content_text  ">
					<?= $widget->text ?>
				</div>

			</div>



			<div class="widgetButtons">
				<a href="<?= $widget->url ?>" target="_blank">
					<div class="basicButton invertHover edit_button">
						Edit
					</div>
				</a>

				<? if(isset($widget->url_categories) && $widget->url_categories != ''): ?>
				<a href="<?= $widget->url_categories ?>">
					<div class="basicButton invertHover edit_button">
						Categories
					</div>
				</a>
				<? endif ?>

				<? if(isset($widget->url_tags) && $widget->url_tags != ''): ?>
				<a href="<?= $widget->url_tags ?>" target="_blank">
					<div class="basicButton invertHover edit_button">
						Tags
					</div>
				</a>
				<? endif ?>
			</div>



		</div>
<?php endforeach; ?>



<? foreach ($widgets as $widget) : ?>
		<!-- <center class="box_icon"><img src="<?= site_url('items/backend/img/' . $widget->img) ?>"></center> -->


		<!-- the box black frame -->
		<div class="boxin">


			<!-- color frame if exists -->
			<?php if ($widget->color != '') : ?>
				<!-- <div class="box_flag">
					<div class="color_flag" style="background-color:<?= $widget->color ?>"></div>
				</div> -->
			<?php endif; ?>




			<!-- <div wid="<?= $widget->id; ?>" class="widget_remove">
			<img src="<?= site_url('items/backend/img/x.svg') ?>">
		</div> -->


			<!-- <section> -->
			<div class="box_title"><?= $widget->category ?></div>
			<? if ($widget->subpage == 'image_overwatch' &&  $widget->category != 'Ansichtskarte') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Images waiting approval: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center">
						<? if ($widget->category == 'Bildlandschaften') {
							echo $pending_images;
						} else if ($widget->category == 'Heldenplatz') {
							echo $pending_images_heldenplatz;
						} else {
							echo $pending_images_multi;
						} ?>
					</div>
				</div>


			<? elseif ($widget->subpage == 'contact_forms') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Open contacts: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_contacts; ?></div>
				</div>


			<? elseif ($widget->subpage == 'overview_guides' || $widget->subpage == 'tours') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Open tours: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_tours; ?></div>
				</div>


			<? elseif ($widget->subpage == 'pendingVideos') : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize">Videos waiting approval: </h2>
					<div style="margin-top:50px;font-size:75px;text-align:center"><?= $pending_videos; ?></div>
				</div>


			<? else : ?>

				<div class="box_content">
					<h2 style="text-transform:capitalize"><?= $widget->subpage; ?></h2>
					<div style="margin-top:20px;font-style:italic"><?= $widget->short_text; ?></div>
				</div>


			<? endif; ?>


			<div class="widgetButtons">
				<a href="<?= site_url('entities/' . $widget->category . '/' . $widget->subpage) ?>">
					<div class="edit_button ui button">
						Edit
					</div>
				</a>

			<? if(isset($widget->url_categories) && $widget->url_categories != ''): ?>
				<a href="<?= $widget->url_categories ?>">
					<div class="edit_button ui button">
						Categories
					</div>
				</a>
				<? endif ?>

				<? if(isset($widget->url_tags) && $widget->url_tags != ''): ?>
				<a href="<?= $widget->url_tags ?>">
					<div class="edit_button ui button">
						Tags
					</div>
				</a>
				<? endif ?>
			</div>

			<!-- </section> -->
		</div>
<? endforeach; ?>