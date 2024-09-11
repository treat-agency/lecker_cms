

   <style>

	#content {
		height: calc(100vh - 60px);
	}

	.bc_edit_table {
		display: none;
	}

	.crud_tab {
		max-height: calc(100vh - 200px);
	}


   </style>


 <div id="item_container" article_type="<?= $article_type ?>" class="unselectable" item_id="<?= $item->id ?>" style="margin-top:0px;padding:0px">

	<div id="col_container" style="width:100%;">
					<?php $module_counter = 0; ?>

          <div id="col_left" class="col has_placeholder" data-text="Drop modules here" style="">


<?php
$i = 0;
$imgUpUrl = site_url() . 'items/backend/icons/iconArrowUp.svg';
$imgDownUrl = site_url() . 'items/backend/icons/iconArrowDown.svg';
$imgEditIcon = site_url() . 'items/backend/icons/editIcon.svg';
$imgBinIcon = site_url() . 'items/backend/icons/binIcon.svg';

foreach ($modules as $module) :

	?>
<?php

switch ($module['mod']) {

	case 'text':

		$id = $module['id'];
		$coll = $module['collapsable'];
		$layout = $module['layout'];
		$top = $module['top'];
		$content = $module['content'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' collapsable='$coll' layout='$layout' top='$top' class='newModuleParent' data-text='Text module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Text</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_text has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


	case 'collapsable':

		$id = $module['id'];
		$top = $module['top'];
		// $layout = $module['layout'];
		$title = $module['title'];
		$content = $module['content'];
		$color = $module['color'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' color='$color' title='$title' top='$top' class='newModuleParent' data-text='Collapsable module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Collapsable</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_collapsable has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


		case 'marquee':

		$id = $module['id'];
		$top = $module['top'];
		$marquee = $module['marquee'];
		$link = $module['link'];
		$content = $module['content'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' marquee='$marquee' link='$link' top='$top' class='newModuleParent' data-text='Marquee module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Marquee</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_marquee has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


	// case 'comment':
	// 	echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_comment has_placeholder" prev_text="' . $module['prev_text'] . '" long_text="' . $module['long_text'] . '" collapsable="' . $module['collapsable'] . '" top="' . $module['top'] . '" data-text="Comment module" style="">' . $module['content'] . '</div>';
	// 	break;


	case 'events':
		echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_events has_placeholder"  top="' . $module['top'] . '" data-text="Events module" style="">' . $module['content'] . '</div>';
		break;


	case 'quote':


		$id = $module['id'];
		$author = $module['author'];

		$top = $module['top'];
		$content = $module['content'];


		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' author='$author'  top='$top' class='newModuleParent' data-text='Quote module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Quote</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_quote has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


	case 'sectiontitle':

		$id = $module['id'];
		$top = $module['top'];
		$size = $module['size'];
		$content = $module['content'];


		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' top='$top' size='$size' class='newModuleParent' data-text='Section title module'>

			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Headline</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>

			<div  class='module module_sectiontitle has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


		// echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_sectiontitle has_placeholder" size="' . $module['size'] . '" top="' . $module['top'] . '" data-text="Section title module" style="">' . $module['content'] . '</div>';
		// break;


	case 'hr':

		$id = $module['id'];
		$top = $module['top'];
		$visible = $module['visible'];
		$content = $module['content'];


		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' top='$top' visible='$visible' class='newModuleParent' data-text='Horizontal line module'>

			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Divider</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>

			<div  class='module module_hr has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;




	case 'news':

		$id = $module['id'];
		$top = $module['top'];
		$link = $module['link'];
		$content = $module['content'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' top='$top' link='$link' class='newModuleParent' data-text='News module'>

			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">News</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>

			<div  class='module module_news has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;




	case 'download':


		$id = $module['id'];
		$top = $module['top'];
		$path = $module['path'];
		$fileTag = $module['file_tag'];
		$pdf = $module['pdf'];

		$sliderFor = '';
		$sliderTitle = '';

		$content = "";


		if ($module['file_tag']){

			foreach($file_tags as $ft){
				if($ft['key'] == $module['file_tag']) {
					$sliderFor = $ft['value'];
					$sliderTitle = "Download module for file tag:";
				}
			}

		} elseif ($module['pdf']) {

			foreach($files_array as $f){
				if($f['key'] == $module['pdf']) {
					$sliderFor = $f['value'];
					$sliderTitle = "Download module for file:";
				}
			}

		} elseif ($module['path']) {
			$sliderFor = $module['path'];
			$sliderTitle = "Download module for path:";

		}




			$content .= "<div>
							<div class='downloadTitle'>{$sliderTitle}</div>
						  	<div class='downloadSubTitle'>{$sliderFor}</div>
						</div>";




		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i'  top='$top' path='$path' pdf='$pdf' file_tag='$fileTag'
				class='newModuleParent' data-text='Download module' >
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Download</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_download has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;


		break;



	case 'dropdown':
		echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_dropdown has_placeholder" title="' . $module['title'] . '" sub_title="' . $module['sub_title'] . '" top="' . $module['top'] . '" data-text="Enter text here" style=""><div class="dropdown_module_title has_placeholder bold" data-text="Doubleclick here">' . $module['title'] . '</div><div class="dropdown_module_sub_title"> ' . $module['sub_title'] . '</div><div class="dropdown_module_content">' . $module['content'] . '</div></div>';
		break;



			case 'image':

				$id = $module['id'];
				$top = $module['top'];
				$repoId = $module['repo_id'];
				$layout = $module['layout'];
				$displayType = $module['display_type'];
				$textWrap = $module['text_wrap'];
				$fName = $module['fname'];
				$description = $module['description'];
				$link = $module['link'];

				$hostUrl = site_url();

				$images_html = '';
				foreach ($module['images'] as $image):
					$images_html .= "<div class='moduleImageElem'>
				<img class='$image->publicClass' src='$image->img_path'/>
			</div>";
				endforeach;

				$stream =
					<<<HTML
		<div dbid='$id' module_id='$i' link='$link' top='$top' repo_id='$repoId' layout='$layout' description='$description'  display_type='$displayType' text_wrap='text_wrap' class='newModuleParent' data-text='Image module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Image</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_image has_placeholder'>

				<!-- <input type='file'  id='module_img_upload_$i' accept='.png,.jpg,.jpeg,.gif' uploadpath='items/uploads/images'> -->
				<!-- <div class='item_description'>$description</div> -->
				<div class="moduleImageHolder">
					$images_html
				</div>

			</div>
		</div>
HTML;

				echo $stream;
				$i++;

				break;


		// echo '<div dbid="' . $module['id'] . '" repo_id="' . $module['repo_id'] . '" layout="' . $module['layout'] . '" display_type="' . $module['display_type'] . '"  text_wrap="' . $module['text_wrap'] . '" description="' . $module['description'] . '" link="' . $module['link'] . '" module_id=' . $i++ . ' class="module display_type_' . $module['display_type'] . ' module_image has_placeholder" top="' . $module['top'] . '" data-text="Enter text here" ' . $style . '>
		// 	<img repo_id="' . $module['repo_id'] . '" src="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['fname'] . '" fname="' . $module['fname'] . '"/>
		// 	<input type="file"  id="module_img_upload_' . $i++ . '" accept=".png,.jpg,.jpeg,.gif" uploadpath="items/uploads/images">
		// 	<div class="item_description">' . nl2br($module['description'] ?? '') . '</div>
		// </div>';
		// break;


	case 'headline':

		$id = $module['id'];
		$top = $module['top'];
		$content = $module['content'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i'  top='$top' class='newModuleParent' data-text='Headline module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Headline</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_headline has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;



		echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_headline has_placeholder" top="' . $module['top'] . '" data-text="Headline module" style="">' . $module['content'] . '</div>';
		break;


	case 'video':


		$id = $module['id'];
		$top = $module['top'];

		$url = $module['url'];
		$autoplay = $module['autoplay'];
		$display_type = $module['display_type'];
		$text = $module['text'];

		// $videoType= strpos($url, 'vimeo') != false ? '1' : '0';
		// $layout = $module['layout'];
		// $controls = $module['controls'];

		// $videoElem = "<div class='modVideoHolder'>";

		// if (strpos($module['url'], 'vimeo') !== false) {

		// 	$videoElem .= "<video class='vimeo_video current_video' style='
		// 		data-hls='{$url}' data-starts-paused=' data-trackable-id=' data-type='video'
		// 		loop='  muted=' playsinline=' preload=' src='{$url}'>
		// 		<source src='{$url}' type='application/x-mpegURL'>
		// 		</video>";

		// } elseif($module['url'] !== '') {

		// 	$videoElem .= '<iframe width="600" height="300" src="https://www.youtube.com/embed/' . $module['url'] . '" title="YouTube video player" frameborder="0"  allow="accelerometer;; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';

		// } else {

		// 	$videoElem .= '<div class="embed_holder"><video class="vimeo_video current_video" style="width: 100%;height:100%"  data-hls="" data-starts-paused="" data-trackable-id="" data-type="video" loop="" muted="" playsinline="" preload="" src=""><source src="" type="application/x-mpegURL"></video></div><div class="video_buttons_holder"><img class="video_play" style="display:none;" src="https://test.treat.agency/kunstraum_archiv/items/frontend/img/play.svg"><img class="video_pause" src="https://test.treat.agency/kunstraum_archiv/items/frontend/img/pause.svg"><img class="video_unmute" src="https://test.treat.agency/kunstraum_archiv/items/frontend/img/speaker.svg"><img class="video_mute" style="display:none;" src="https://test.treat.agency/kunstraum_archiv/items/frontend/img/mute-2.svg">';
		// 	$videoElem .= "</div>";

		// }

		// $videoElem .= "</div>";


		$stream =
		<<<HTML
		<div dbid='$id' draggable="true" module_id='$i' url='$url' playauto='$autoplay' display_type='$display_type' text='$text' top='$top' class='newModuleParent' data-text='Video module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Video</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_video has_placeholder'>
				<div class="moduleImageHolder">
					<video autoplay muted src="$url"></video>
				</div>
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;




	case 'html':

		$id = $module['id'];
		$top = $module['top'];
		$html = $module['html'];

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i'  top='$top' class='newModuleParent' data-text='Html module'>

			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Html</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div class='module module_html' data-text='HTML module'>
				$html
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;



	case 'pdf':

		$img = '<img  class="list_item_img" src="' . $hostUrl . 'items/frontend/img/pdf_icon.svg" fname=""/>';

		if ($module['type'] != 'LINK') :

			if ($module['image'] != NULL && $module['image'] != "") {

				echo '<div dbid="' . $module['id'] . '" link="' . $module['link'] . '" image="' . $module['image'] . '" button_text="' . $module['button_text'] . '" repo_id="' . $module['repo_id'] . '" dl_type="' . $module['type'] .  '" text="' . htmlentities($module['text'] ?? '') . '" title="' . htmlentities($module['title'] ?? '') . '" filename="' . $module['fname'] . '" module_id=' . $i++ . ' class="module module_pdf has_placeholder" top="' . $module['top'] . '" data-text="Enter text here" style=""><img class="list_item_img" src="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['image'] . '" fname="' . $module['image'] . '"/>
										<div class="list_item_text_container">
											<div class="list_item_title semibold">' . nl2br($module['title'] ?? '') . '</div>
											<div class="list_item_teaser regular">' . nl2br($module['text'] ?? '') . '</div>
											<div class="list_item_more semibold">' . $module['button_text'] . '</div>
										</div>
									</div>';
			} else {
				echo '<div dbid="' . $module['id'] . '" link="' . $module['link'] . '" image="' . $module['image'] . '" button_text="' . $module['button_text'] . '" repo_id="' . $module['repo_id'] . '" dl_type="' . $module['type'] .  '" text="' . htmlentities($module['text'] ?? '') . '" title="' . htmlentities($module['title'] ?? '') . '" filename="' . $module['fname'] . '" module_id=' . $i++ . ' class="module module_pdf has_placeholder" top="' . $module['top'] . '" data-text="Enter text here" style=""><img style="height:60px;width:auto;" class="list_item_img" src="' . $hostUrl . 'items/frontend/img/pdf_icon.svg" fname=""/>
									<div class="list_item_text_container" style="height:auto;">
										<div class="list_item_title semibold">' . nl2br($module['title'] ?? '') . '</div>
										<div class="list_item_teaser regular">' . nl2br($module['text'] ?? '') . '</div>
										<div class="list_item_more semibold">' . $module['button_text'] . '</div>
									</div>
								</div>';
			}
		/*  echo '<div image="' . $module['image'] . '" btn="' . $module['button_text'] . '" repo_id="' . $module['repo_id'] . '" dl_type="' . $module['type'] .  '" text="' . htmlentities($module['text']) . '" title="' . htmlentities($module['title']) . '" filename="' . $module['fname'] . '" module_id=' . $i++ . ' class="module module_pdf has_placeholder" top="'.$module['top'].'" data-text="Enter text here" style="">'.$img.'<div class="enum_body"><span>' . nl2br($module['text']) . '</span></div><a target="_blank" href="'. $hostUrl . 'items/uploads/module_pdf/'.$module['fname'].'"><div class="enum_dl">'. $this->lang->line('download').'</div></a></div>';*/
		else :

		echo '<div dbid="' . $module['id'] . '" link="' . $module['link'] . '" image="' . $module['image'] . '" button_text="' . $module['button_text'] . '" repo_id="' . $module['repo_id'] . '" dl_type="' . $module['type'] .  '" text="' . htmlentities($module['text'] ?? '') . '" title="' . htmlentities($module['title'] ?? '') . '" filename="' . $module['fname'] . '" module_id=' . $i++ . ' class="module module_pdf has_placeholder" top="' . $module['top'] . '" data-text="Enter text here" style=""><img class="list_item_img" src="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['image'] . '" fname="' . $module['image'] . '"/>
										<div class="list_item_text_container" style="">
											<div class="list_item_title semibold">' . nl2br($module['title'] ?? '') . '</div>
											<div class="list_item_teaser regular" style="">' . nl2br($module['text'] ?? '') . '</div>
											<div class="list_item_more semibold">' . $this->lang->line('download') . '</div>
										</div>
									</div>';

		endif;

		break;

	case 'start':


		$id = $module['id'];
		$top = $module['top'];
		$repoId = $module['repo_id'];
		$imgCredits = $module['img_credits'];
		$title = $module['title'];
		$subTitle = $module['sub_title'];
		$content = "<p>" .  htmlentities($module['content'] ?? '') . "</p>";

		$hostUrl = site_url();
		$headerImg = $module['header_img'];
		$imgPath = $hostUrl . 'items/uploads/images/thumbs/' . $headerImg;

		$img = "<img src='' style='display:none'>";

		if ($module['header_img'] != NULL && $module['header_img'] != "") {
			$img = "<img src='$imgPath' fname='$headerImg'/>";
		}

		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i' collapsable='$coll' repo_id='$repoId' top='$top' description='$content' img_credits='$imgCredits' title='$title' subtitle='$subTitle' filename='$headerImg' class='newModuleParent' data-text='Start/header module'>
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Start/Header module</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_start has_placeholder'>
				$img
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;


		$img = '<img src="" style="display:none">';

		if ($module['header_img'] != NULL && $module['header_img'] != "") {
			$img = '<img src="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['header_img'] . '" fname="' . $module['header_img'] . '"/>';
		}


		echo '<div dbid="' . $module['id'] . '" repo_id="' . $module['repo_id'] . '" description="' . htmlentities($module['content'] ?? '') . '" filename="' . $module['header_img'] . '" img_credits="' . $module['img_credits'] . '" title="' . $module['title'] . '" subtitle="' . $module['sub_title'] . '" filename="' . $module['header_img'] . '" module_id=' . $i++ . ' class="module module_start has_placeholder" top="' . $module['top'] . '" data-text="Start/header module" style=""><div class="start_title has_placeholder" data-text="Start/header module">' . $module['title'] . '</div>' . $img . '<div class="start_credits">' . $module['img_credits'] . '</div><div class="start_subtitle">' . $module['sub_title'] . '</div><div class="start_intro"></div></div>';
		break;




	case 'newsletter':

		$id = $module['id'];
		$top = $module['top'];
		$success_message = $module['success_message'];
		$list_type = $module['list_type'];
		$button_text = $module['button_text'];
		$firstname = $module['firstname'];
		$lastname = $module['lastname'];
		$email = $module['email'];
		$title = $module['title'];


		$stream =
		<<<HTML
		<div dbid="$id" success_message="success_message" list_type="$list_type" module_id="$i" class="module module_newsletter" top="$top" contact_firstname="$firstname" contact_lastname="$lastname" contact_email="$email"  contact_title="$title" contact_button="$button_text">

			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Newsletter</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>

			<div class='module module_newsletter has_placeholder'>
				<div class="contact_title">$title</div>

				<form class="module_form" method="post">
					<label class="module_contact_label">$firstname</label>
					<input class="module_contact_input" type="text" name="firstname" placeholder="$firstname"/>
					<label class="module_contact_label">$lastname</label>
					<input class="module_contact_input" type="text" name="lastname" placeholder="$lastname"/>
					<label class="module_contact_label">$email</label>
					<input class="module_contact_input" type="text" name="email" placeholder="$email"/>
				</form>

				<div class="module_newsletter_send">$button_text</div>
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;

		break;






			case 'gallery':

				$id = $module['id'];
				$top = $module['top'];
				$slider = $module['slider'];
				$scale_images = $module['scale_images'];

				echo
					"<div dbid='{$id}' module_id='{$i}' slider='{$slider}' scale_images='{$scale_images}' top='{$top}' class='newModuleParent' data-text='Gallery module'>

			<div class='moduleNamingAndControls'>

				<div class='moduleNaming'>Gallery</div>
				<div class='moduleControls'>
					<div class='moduleDeleteEdit'>
						<div class='moduleDelete ui-rounded1 js-moduleDelete'>
							<img src='$imgBinIcon' alt=''>
						</div>
						<div class='moduleEdit ui-rounded1 js-moduleEdit'>
							<img src='$imgEditIcon' alt=''>
						</div>
					</div>
					<div class='moduleUpDown'>
						<div class='moduleUp ui-rounded1 js-moduleUp'>
							<img src='$imgUpUrl' alt=''>
						</div>
						<div class='moduleDown ui-rounded1 js-moduleDown'>
							<img src='$imgDownUrl' alt=''>
						</div>
					</div>
				</div>

			</div>

			<div class='module module_gallery has_placeholder'>

				<div class='moduleImageHolder'>";


				foreach ($module['images'] as $image) {

					echo "<div class='gallery_item'><img class='$image->publicClass' src='{$image->img_path}' /></div>";

					}

				echo
					"</div>
			</div>
		</div>";

				$i++;
				break;






			case 'related':

		$id = $module['id'];
		$top = $module['top'];
		$numItems = $module['num_items'];
		$content = $module['num_items'];
		$relId = $module['rel_id'];
		$relItems = $module['related_items'];
		$mainId = $module['main_id'];
		$name = $module['name'];
		$relType = $module['rel_type'];

		$content = "";

		switch($relType){
					case "articles":
					 $label = 'Articles';
						break;
					case "tag":
					 $label = 'Tags';
						break;
		}



		// if ($module['rel_type'] == 'articles') {

			$content .= "<div class='related_type'>" . $label . "</div>" . "<div class='related_holder'>";
			foreach ($relItems as $rel) {
				// $relType = $rel['related_type'];
				// $relatedId = $rel['related_id'];
				$relItemId = $rel->id;
				$relName = $rel->name;

				$content .= "<div class='relModelem module_related_item_front'>{$relName}" . " ({$relItemId})" . "</div>";
			}


		$content .= "</div>";


		$stream =
		<<<HTML
		<div dbid='$id' module_id='$i'  top='$top' num_items='$numItems' rel_id='$relId' type='$relType' class='newModuleParent' data-text='Related module' >
			<div class='moduleNamingAndControls'>

				<div class="moduleNaming">Article list module</div>
				<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
				</div>

			</div>
			<div  class='module module_related has_placeholder'>
				$content
			</div>
		</div>
		HTML;

		echo $stream;
		$i++;


		break;



		case 'event':
			echo '<div dbid="' . $module['id'] . '" module_id=' . $i++ . ' class="module module_event has_placeholder " num_items="' . $module['num_items'] . '" future_events="' . $module['future_events'] . '" rel_id="' . $module['rel_id'] . '" type="' . $module['type'] . '" top="' . $module['top'] . '" data-text="Event module" style="">';
			echo "List: " . $module['name'] . " (" . $module['main_id'] . ")";
			echo '</div> ';
			break;


		case 'column_start':

			$id = $module['id'];
			$colType = $module['col_type'];
			$top = $module['top'];
			$displayText = "Column start module: Left 50%";
			$colImgDown = site_url() . 'items/backend/icons/iconArrowDown.svg';


			switch ($module['col_type']) {
				case '0':
					$displayText = "Column start module: Left 50%";
					break;
				case '1':
					$displayText = "Column start module: Right 50%";
					break;
				default:
					break;
			}

			$stream =
			<<<HTML
			<div dbid='$id' module_id='$i' top='$top' col_type='$colType' class='newModuleParent' data-text='Column start module'>

				<div class='moduleNamingAndControls'>

					<div class="moduleNaming moduleNamingColumn">
						Column start
						<div class="columnStartArrow">
							<img src="$colImgDown" alt="">
						</div>
					</div>
					<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
					</div>

				</div>

				<div  class='module module_column_start col_start_type_{$colType} has_placeholder'>
					$displayText
				</div>
			</div>
			HTML;

			echo $stream;
			$i++;

			break;


		case 'column_end':

			$id = $module['id'];
			$top = $module['top'];
			$displayText = "Column end module";
			$colImgUp = site_url() . 'items/backend/icons/iconArrowUp.svg';

			$stream =
			<<<HTML
			<div dbid='$id' module_id='$i' top='$top' class='newModuleParent' data-text='Column end module'>

				<div class='moduleNamingAndControls'>

					<div class="moduleNaming moduleNamingColumn">
						Column end
						<div class="columnStartArrow">
							<img src="$colImgUp" alt="">
						</div>
					</div>
					<div class="moduleControls">
					<div class="moduleDeleteEdit">
						<div class="moduleDelete ui-rounded1 js-moduleDelete">
							<img src="$imgBinIcon" alt="">
						</div>
						<div class="moduleEdit ui-rounded1 js-moduleEdit">
							<img src="$imgEditIcon" alt="">
						</div>
					</div>
					<div class="moduleUpDown">
						<div class="moduleUp ui-rounded1 js-moduleUp">
							<img src="$imgUpUrl" alt="">
						</div>
						<div class="moduleDown ui-rounded1 js-moduleDown">
							<img src="$imgDownUrl" alt="">
						</div>
					</div>
					</div>

				</div>

				<div  class='module module_column_end has_placeholder'></div>
			</div>
			HTML;

			echo $stream;
			$i++;

			break;


	}
	?>


            <?php endforeach; ?>
          </div>
