<!-- TO INCLUDE SOMEWHERE  -->

<!-- inside of container -->
<div id="modContainer">


<!-- looping through modules START -->
	<? foreach ($modules as $module) :

		$top = $module['top'];
		$content = $module['content'] ?? "";

	switch ($module['mod']) {


		case 'column_start':

			$colType = $module['col_type'];

			$stream =
				<<<HTML
				<div class="module module_column_start  col_start_type_$colType" top="$top">
				HTML;

			echo $stream;
			break;


		case 'column_end':

			$stream =
				<<<HTML
				</div>
				HTML;

			echo $stream;
			break;



		case 'sectiontitle':

			$size = "";
			if ($module['size'] == 1) {
				$size = "subheaderSize";
			} else {
				$size = "bigHeaderSize";
			}

			$stream =
				<<<HTML
				<div class="module module_sectiontitle  $size" top="$top">
					$content
				</div>
				HTML;

			echo $stream;
			break;



		case 'text':

			$stream =
				<<<HTML
				<div class="module module_text" top="$top">
					$content
				</div>
				HTML;

			echo $stream;
			break;


		case 'collapsable':

			$arrow = site_url() . 'items/frontend/custom/mech-thickArrowBlue.svg';
			$title = $module['title'];
			// $image = $module['image'];

			$stream =
				<<<HTML
				<div class="module module_collapsable" top="$top" title="$title">

					<div class="">

						<div class="limit1000">

							<div class="collBlock js-collBlock">
								<div class="collTitle druk500 dblueColor">$title
									<div class="collArrow">
										<img src="$arrow" alt="">
									</div>
								</div>
								<div class="collColumns tinyFont">

									<div class="collColLeft">
										<br>
										$content
									</div>
									<div class="collColRight">
										<img src="<?= site_url() . 'items/frontend/custom/mech-lp.jpeg' ?>" alt="">
									</div>

								</div>
							</div>

						</div>
					</div>

				</div>
				HTML;

			echo $stream;
			break;



		case 'quote':

			$author = $module['author'];
			$content = "„" . $content . "“";

			$stream =

				<<<HTML
				<div class="module module_quote " top="$top">
					$content
					<div class="author">-$author</div>
				</div>
				HTML;

			echo $stream;
			break;


		case 'hr':

			$invisible = $module['visible'] == 0 ? "invisible" : "" ;

			$stream =

				<<<HTML
				<div class="module module_hr $invisible" top="$top">
				</div>
				HTML;

			echo $stream;
			break;


		case 'marquee':

			$animated = $module['marquee'] == 1 ? "animated" : "" ;
			$bmElem = $module['marquee'] == 1 ? "bmElemRight" : "" ;

			$text = "";
			for ($i = 0; $i < 8; $i++) {
				$text .= "<div class='{$bmElem}'><span>" . $module['content']   . "&nbsp;</span>&nbsp;&nbsp;&nbsp;</div>";
			}


			$linkOpener = "";
			$linkCloser = "";
			if($module['link'] != "") {
				$linkOpener = "<a target='_blank' href='" . $module['link'] . "' >";
				$linkCloser = "</a>";
			}

			$stream =

				<<<HTML
				<div class="module module_marquee $animated" top="$top">
					<section class="marqueeHolder">
						$linkOpener
							<div class="fullMarqueeHolder">
									$text
							</div>
						$linkCloser
					</section>
				</div>
				HTML;

			echo $stream;
			break;




		case 'download':


			$fileElems = "";
			foreach($module['files'] as $file) {

				$fileTitle = $lang == MAIN_LANGUAGE ? $file->title : $file->title_en ;

				if($file->image != "") {
					$fileImg = site_url() . 'items/uploads/images/' . $file->image;

					$fileElems =
					"<div class='dFileElem'>
						<a href='{$file->file_download}'>
							<div class='dFileWrapper'>
								<img src='{$fileImg}'>
								<div class='dFileTitle'>{$fileTitle}</div>
							</div>
						</a>
					</div>
					";

				} else {

					$fileElems =
					"<div class='dFileElem'>
						<a href='{$file->file_download}'>
							<div class='dFileWrapper'>
								<div class='dFileTitle'>{$fileTitle}</div>
							</div>
						</a>
					</div>
					";

				}

			}

			$stream =
				<<<HTML
				<div class="module module_download" top="$top">
					<div class="downloadModuleTitle">Download Files</div>
					<div class="moduleDownloadHolder">
						$fileElems
					</div>
				</div>
				HTML;

			echo $stream;
			break;



		case 'image':

			$link = $module['link'];
			$linkThere = $link != "";

			$image = $module['images'][0];


			if($linkThere) {

				$stream =
					<<<HTML
						<div class="module module_image" top="$top">
							<a href="$link">
								<img src="$image->img_path">
								<p class="moduleImageCredits">$image->Credits</p>
							</a>
						</div>
					HTML;

			} else {

				$stream =
					<<<HTML
					<div class="module module_image" top="$top">
						<img src="$image->img_path">
						<p class="moduleImageCredits">$image->Credits</p>
					</div>
					HTML;

			}


			echo $stream;
			break;



		case 'html':
			if ($item->pretty_url == "freunde" || $item->pretty_url == "friends_of_the_secession") {
				if (strip_tags($module['html']) == "Friendmodule") {
					echo $friends_module;
				}
				// $friends_module

			} else {
				echo '<div module_id=' . $module['id'] . ' class="module module_html " style="" module_html_id="' . $module['id'] . '"><div class="module_html_content">' . $module['html'] . '</div></div>';
			}

			break;




		case 'video' :

			$autoplay = $module['autoplay'] == 1 ? "autoplay muted" : "" ;
			$url = $module['url'];
			$displayType = $module['display_type'];
			$text = $module['text'];

			$stream =
				<<<HTML
				<div class="module module_video" top="$top">
					<video $autoplay src="$url"></video>
					<div class="videoText">$text</div>
				</div>
				HTML;

			echo $stream;
			break;


        break;



		case 'start':

			if ($module['header_img'] !== 'module_image_preview.png' && $module['header_img'] !== '') {
				$img = '<a  title="' . htmlentities(nl2br($module['alt'])) . '" href="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['header_img'] . '" data-title="' . htmlentities(nl2br($module['alt'])) . '" ><img title="' . htmlentities($module['alt']) . '" alt="' . htmlentities($module['alt']) . '" src="' . $hostUrl . 'items/uploads/images/thumbs/' . $module['header_img'] . '" /></a>';
			} else {
				$img = '<div style="margin: -35px auto;" ></div>';
			}

			echo '<div  class="module module_start " top="' . $module['top'] . '" data-text="Enter header here" style="">
					<h2 class="start_title">' .
				$module['title'] .
				'</h2>' .
				$img .
				'<div class="start_credits">' .
				$module['img_credits'] .
				'</div>
					<h2 class="start_subtitle">' .
				$module['sub_title'] .
				'</h2>' .
				'<div class="start_intro">' .
				$module['content'] .
				'</div>' .
				'</div>';

			break;





		case 'gallery':


			$slider = $module['slider'];
			$arrowLeft = site_url() . 'items/frontend/img/arrow_left.svg';
			$arrowRight = site_url() . 'items/frontend/img/arrow_right.svg';

			$gallSliderStream = "";

			if($slider) {

				foreach( $module['images'] as $tempImg) {
					$gallSliderStream .=
					"<div class='gallSliderImg'>
						<img src='" . $tempImg->img_path . "'>
						<div class='gallSliderCredits'>" . $tempImg->Credits . "</div>
					</div>";
				}


				$stream =
					<<<HTML
					<div class="module module_gallery" top="$top">
						<div class="gallSliderContainer">

							<div class="gallSliderArrowHolder">
								<div class="gallSliderArrows js-gallSliderLeft">
									<img src="$arrowLeft">
								</div>
								<div class="gallSliderArrows js-gallSliderRight">
									<img src="$arrowRight">
								</div>
							</div>

							<div class="gallSliderSlick">
								$gallSliderStream
							</div>

					</div>
					HTML;

			}


			echo $stream;
			break;




			break;



			case 'related':


				$relSliderStream = "";


				$j = 0;
				foreach ($module['related_items'] as $tempRel) {

					if ($j >= 3)
						break;

					$img = site_url() . 'items/frontend/custom/news1.jpeg';
					if (isset($tempRel->first_teaser)) {
						$img = $tempRel->first_teaser->img_path;
						}

					if (isset($tempRel->pretty_url)) {

						$relSliderStream .=
							"<a href='" . $tempRel->pretty_url . "' class='normalA'>
						<div class='lpNewsElem'>
							<img class='' src='" . $img . "' alt=''>
							<span class='lpNewsTitle interBold'>" . $tempRel->name . "</span> <br>
							<span class='lpNewsTeaser'>" . $tempRel->teaser . "</span>
							<span class='lpNewsArrow'>
								<img class='drArrow' src='" . site_url('items/frontend/custom/mech-downRightArrowpurple.svg') . "' alt=''>
							</span>

						</div>
					</a>
					";

						} else {

						$relSliderStream .=
							"
						<div class='lpNewsElem'>
							<img class='' src='" . $img . "' alt=''>
							<span class='lpNewsTitle interBold'>" . $lpNewsElem->name . "</span> <br>
							<span class='lpNewsTeaser'>" . $lpNewsElem->teaser . "</span>
							<span class='lpNewsArrow'>
								<img class='drArrow' src='" . site_url('items/frontend/custom/mech-downRightArrowpurple.svg') . "' alt=''>
							</span>

						</div>
					";

						}

					}


				if (count($module['related_items']) == 0) {
					$relSliderStream = '<div>' . $this->lang->line('no_articles') . '</div>';
					}




				$stream =
					<<<HTML
				<div class="module module_related" top="$top">
					<div class='limit1000'>
							<div class="relModuleHolder">
								<div class="lpNewsGrid">
									$relSliderStream
								</div>
							</div>
						</div>
					</div>
				</div>
				HTML;



				echo $stream;
				break;


			}

		?>

    <? endforeach; ?>   <!-- looping through modules END -->

  <!-- closing of container for modules  -->
  </div>
