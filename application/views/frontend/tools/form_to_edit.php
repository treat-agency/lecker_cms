<script src="<?= site_url("items/frontend/js/artist.js?ver=1"); ?>" type="text/javascript"></script>

<div id="item_container" class="regular">
	<!-- <div class="titleHolder">/<?=  $this->lang->line('edit_artist') ?></div> -->
	<div class="titleHolder">/Profil bearbeiten</div>

	<div class="editArtistTitle">/<?=  $artist->first_name." ".$artist->last_name ?></div>
	<br> <br>

	<div>
		<div class="inputHolder">
			<div class="inputTitleLeft">Bio DE: </div>
			<textarea name="artist_bio" id="artist_bio" placeholder="Bio DE..."><?= $artist->bio ?></textarea>
		</div>
		<div class="inputHolder">
			<div class="inputTitleLeft">Exhibitions DE: </div>
			<textarea name="artist_exhibitions" id="artist_exhibitions" placeholder="Exhibitions DE..."><?= $artist->exhibitions ?></textarea>
		</div>
		<div class="inputHolder">
			<div class="inputTitleLeft">Bio EN: </div>
			<textarea name="artist_bio_en" id="artist_bio_en" placeholder="Bio EN..."><?= $artist->bio_en ?></textarea>
		</div>
		<div class="inputHolder">
			<div class="inputTitleLeft">Exhibitions EN: </div>
			<textarea name="artist_exhibitions_en" id="artist_exhibitions_en" placeholder="Exhibitions EN..."><?= $artist->exhibitions_en ?></textarea>
		</div>
		
		<div id="update_artist" aid="<?= $artist->id ?>">Update</div>
		
		<div id="message"></div>
	</div>
</div>


<style>

	.editArtistTitle {
		font-size: 60px;
		font-weight: 700;
	}
	
	.titleHolder {
		padding-top: 50px;
	}
	
	.inputHolder {
		display: flex;
		margin-bottom: 36px;
	}
	
	.inputTitleLeft {
		flex-basis: 250px;
		font-size: 30px;
		font-weight: 700;
	}

	textarea {
		border: 1px solid black;
		outline: 1px solid black;
		flex-grow: 1;
		height: 200px;
		padding: 18px;
		font-size: 18px;
	}

	#update_artist, #message {
		width: 200px;
		height: 72px;
		text-align: center;
		line-height: 72px;
		font-family: 'Helvetica';
		font-size: 30px;
		font-weight: 700;
		color: white;
		background-color: black;
		cursor: pointer;
		margin: auto;
	}

	#message {
		margin-top: 50px;
		cursor: default;
		background-color: white;
		color: black;
		border: 2px solid black;
	}

	#message:empty {
		display: none;
	}

	

	


</style>