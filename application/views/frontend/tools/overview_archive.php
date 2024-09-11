<style>

#overviewElementsContainer {
    display: grid;
    grid-gap: 20px;
    grid-template-columns: repeat(4, 1fr);
}

.groupElemWrapper {
    width: 100%;
    height: unset;
    margin-bottom: 30px;
}

.groupElemLink {
    cursor:pointer;
}


@media only screen and (max-width: 1200px) {

    #overviewElementsContainer {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media only screen and (max-width: 1100px) {

    #overviewElementsContainer {
        grid-template-columns: repeat(2, 1fr);
    }
}

</style>

<? if (count($items)) :

    foreach ($items as $item) :

        $dateString = "";

        $start_year = date('Y', strtotime($item->start_date_time));
        $end_year = date('Y', strtotime($item->end_date_time));

        if ($start_year == $end_year) {
            $dateString = date('j.n.', strtotime($item->start_date_time)) . " – " . date('j.n.Y', strtotime($item->end_date_time));
        } else {
            $dateString = date('j.n.Y', strtotime($item->start_date_time)) . " – " . date('j.n.Y', strtotime($item->end_date_time));
        }
?>



        <div class="groupElemWrapper">

            <?php if ($item->pretty_url != '') : ?>
                <a href="<?= site_url($item->pretty_url) ?>">
                <?php endif; ?>

                <div class="groupElemImg">
                    <img loading="lazy" src="<?= site_url() . ($item->image != '' ? 'items/uploads/images/' . $item->image : "items/frontend/img/logo/logo.png"); ?>" alt="">
                </div>
                <div class="groupElemContent">
                    <? if (count($item->artists) > 3) : ?>
                        <div class="groupElemCat mt5">
                            <?= $this->lang->line('mehrereKue') ?>
                        </div>
                    <? else : ?>
                        <div class="groupElemCat mt5">
                            <?
                            for ($j = 0; $j < count($item->artists); $j++) {
                                if ($j != 0) echo ", ";
                                echo $item->artists[$j]->first_name . " " . $item->artists[$j]->last_name;
                            }
                            ?>
                        </div>
                    <? endif; ?>

                    <div class="groupElemTitle">
                        <?= $item->name ?>
                    </div>
                    <div class="groupElemText">
                        <?= $dateString ?>
                    </div>
                    <br>


                    <div class="groupElemLink">
                        <?= $this->lang->line('mehrErfahren') ?>
                    </div>

                </div>

                <?php if ($item->pretty_url != '') : ?>
                </a>
            <?php endif; ?>

        </div>


    <? endforeach;
else : ?>
    <div>No results found</div>

<?php endif; ?>