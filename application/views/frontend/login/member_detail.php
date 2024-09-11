

<!-- <div><? var_dump($item);?></div> -->

<style>

.memberName {
    padding-top: 50px;
    font-size: 80px;
    text-transform: unset;
}

.memberContainer {
    min-height: 70vh;
    border-bottom: 1px solid black
}

.memberYear {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 20px !important;
}

.memberExhHeader {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 20px !important;
    text-decoration: lowercase;
}

.memberElem {
    display: flex;
    justify-content: space-between;

    font-weight: 700;
    font-size: 28px;
}

.member {
    font-size: 18px;
    font-weight: 400;
}

.mLeft {
    flex: 1 1 auto;
}

.mRight {
    margin-left: 20px;
    text-decoration: underline;
    flex: 0 0 auto;
}

.flexElem {
    display: flex;
    margin-bottom: 20px;
}


.mElemL {
    /* flex-basis: 300px; */
    margin-right: 20px;
    font-size: 30px;
    font-weight: 700;
}

.mElemR {
    flex-basis: 300px;
    flex-grow: 1;
    font-size: 18px;

    margin-top: 9px;
}

@media screen and (max-width: 1100px) {

    .memberElem {
        flex-direction: column;
        margin-bottom: 1em;
    }

    .mRight {
        margin-left: 0;
    }

}


</style>

<div class="memberContainer">

    <div class="memberName titleHolder">/<?= strtolower($item->first_name . " " . $item->last_name)?> </div>
    <br><br>

    <!-- <? var_dump($item);?> -->

    <? if($item->email != "") : ?>
        <div class="flexElem">
            <div class="mElemL"><?= ($lang == MAIN_LANGUAGE) ? "E-Mail:" : "E-Mail:" ; ?></div>
            <div class="mElemR"><?= $item->email?></div>
        </div>
    <? endif; ?>
    <? if($item->website != "") : ?>
        <div class="flexElem">
            <div class="mElemL"><?= ($lang == MAIN_LANGUAGE) ? "Website:" : "Website:" ; ?></div>
            <div class="mElemR"><a target='_blank' href="<?= $item->website?>"><?= $item->website?></a> </div>
        </div>
    <? endif; ?>
    <? if($item->birthday != "" && $item->bio == "") : ?>
        <div class="flexElem">
            <div class="mElemL"><?= ($lang == MAIN_LANGUAGE) ? "Geburtsjahr:" : "Birth year:" ; ?></div>
            <div class="mElemR"><?= $item->birthday?></div>
        </div>
    <? endif; ?>
    <? if($item->bio != "") : ?>
        <div class="flexElem">
            <div class="mElemL"><?= ($lang == MAIN_LANGUAGE) ? "Biografie:" : "Biography:" ; ?></div>
            <div class="mElemR"><?= ($lang == MAIN_LANGUAGE) ? $item->bio : $item->bio_en ; ?></div>
        </div>
    <? endif; ?>

    <? if($item->exhibitions != "") : ?>
    <div class="flexElem">
        <div class="mElemL"><?= ($lang == MAIN_LANGUAGE) ? "Externe Ausstellungen:" : "external exhibitions:" ; ?></div>
        <div class="mElemR"><?= $item->exhibitions?></div>
    </div>
    <? endif; ?>


    <? if(count($artistExhibitions) > 0 || count($artistExhibitionsCurator) > 0) : ?>

        <br> <br>
        <div class="memberExhHeader"><?= ($lang == MAIN_LANGUAGE) ? "/ausstellungen" : "/exhibitions" ; ?></div>
        <div class="memberExhibitions">

            <? foreach($artistExhibitions as $exh) : ?>

				<?php if($exh->pretty_url != ''):?>
                	<a href="<?= site_url() .  $exh->pretty_url ?>">
                <?php endif;?>
                    <div class="memberElem">
                        <? if($exh->name != "") : ?>
                            <div class="mLeft"><?= $exh->name ?></div>
                        <? else : ?>
                            <div class="mLeft"><?= $item->first_name . " " . $item->last_name ?></div>
                        <? endif; ?>
                        <div class="mRight"><?= $this->lang->line('mehrErfahren') ?></div>
                    </div>
               <?php if($exh->pretty_url != ''):?>
               	 </a>
 			   <?php endif;?>
            <? endforeach; ?>

            <? foreach($artistExhibitionsCurator as $exh) : ?>


               <?php if($exh->pretty_url != ''):?>
                	<a href="<?= site_url() .  $exh->pretty_url ?>">
                <?php endif;?>
                    <div class="memberElem">
                        <? if($exh->name != "") : ?>
                            <div class="mLeft"><?= $exh->name ?></div>
                        <? else : ?>
                            <div class="mLeft"><?= $item->first_name . " " . $item->last_name ?></div>
                        <? endif; ?>
                        <div class="mRight"><?= $this->lang->line('mehrErfahren') ?></div>
                    </div>
               <?php if($exh->pretty_url != ''):?>
               	 </a>
 			   <?php endif;?>
            <? endforeach; ?>

        </div>

    <? endif; ?>


    <? if(count($artistEvents) > 0) : ?>

        <br> <br>
        <div class="memberExhHeader"><?= ($lang == MAIN_LANGUAGE) ? "/veranstaltungen" : "/events" ; ?></div>
        <div class="memberExhibitions">

            <? foreach($artistEvents as $eve) : ?>

				<?php if($eve->pretty_url != ''):?>
                	<a href="<?= site_url() .  $eve->pretty_url ?>">
                <?php endif;?>
                    <div class="memberElem">
                        <? if($eve->name != "") : ?>
                            <div class="mLeft"><?= $eve->name ?></div>
                        <? else : ?>
                            <div class="mLeft"><?= $item->first_name . " " . $item->last_name ?></div>
                        <? endif; ?>
                        <div class="mRight"><?= $this->lang->line('mehrErfahren') ?></div>
                    </div>
               <?php if($eve->pretty_url != ''):?>
               	 </a>
 			   <?php endif;?>
            <? endforeach; ?>

        </div>

    <? endif; ?>




    <br> <br>
    <br> <br>

</div>
