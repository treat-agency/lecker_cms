

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


<div id="overview_page_holder" class="page_holder regular no_scrollbar">

    <div id="overview_elements_container">
        <!-- main category text elements here -->

        <!-- title -->
        <div class="titleWrapper">
            <!--<a href="">
                <div class="goLeftWrapper">
                    <span class="goLeftArrow">
                        < </span>
                            <div class="goLeftText">
                                zum Thema <br>
                                <span style='border-bottom: 1px solid lightgrey'>Ärzte</span>
                            </div>
                </div>
            </a>-->

            <div class="titleHolder">
                <?= ($lang == SECOND_LANGUAGE)? "/".$cat->name : "/".$cat->name_de ; ?>
            </div>

         <!--  <a href="">
                <div class="goRightWrapper">
                    <div class="goRightText">
                        zum Thema <br>
                        <span style='border-bottom: 1px solid lightgrey'>COVID-Hilfe</span>
                    </div>
                    <span class="goRightArrow">
                        > </span>
                </div>
            </a> -->
        </div>


        <!-- subtitle-->
        <div class="subtitleWrapper">
            <!-- module information -->
            <div class="subtitleHeader">

            </div>
            <div class="subtitleText">
                <?= ($lang == MAIN_LANGUAGE)? $cat->intro_de : $cat->intro_en; ?>
            </div>


        </div>


        <div id="overviewElementsContainer">
            <?= $cat->items_html ?>
        </div>

    </div>

    <div style="height: 100px"></div>




    <script>

        $(function() {

            $('.ergebnisseNumber').text($('.groupElemWrapper').length);

        });



    </script>