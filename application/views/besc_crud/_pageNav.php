

    <script>
        console.log("acurr", '<?= $paging['currentPage'] ?>')
        console.log("atot", '<?= $paging['totalPages'] ?>')
        console.log("astart", '<?= $paging['list_start'] ?>')
        console.log("aend", '<?= $paging['list_end'] ?>')

    </script>
    <?php if ($paging['list_start'] != $paging['list_end']) : ?>


        <div class="controlRight">

            <div class="bc_paging_bottom">
    
                <?php if ($paging['currentPage'] != 0) : ?>
                <div class="bc_paging_button invertHover bc_paging_first" target=<?= 0 ?>>
                    <span class="pageArrowHolder">
                    <img src="<?= site_url('items/backend/icons/other/twoArrowL.png') ?>" alt="">
                    </span>
                </div>
                <?php endif; ?>
    
                <?php if ($paging['currentPage'] != 0) : ?>
                <div class="bc_paging_button invertHover bc_paging_prev" target=<?= $paging['currentPage'] - 1 ?>>
                    <span class="pageArrowHolder singleArrow">
                    <img src="<?= site_url('items/backend/icons/other/oneArrowL.png') ?>" alt="">
                    </span>
                </div>
                <?php endif; ?>
    
            </div>
            
    
    
            <div class="bc_paging_sites">
    
                <?php for ($i = $paging['list_start']; $i <= $paging['list_end']; $i++) : ?>
                    <div class="bc_paging_page basicButton invertHover <?php if ($i == $paging['currentPage']) : ?>bc_current_page<?php endif; ?>" page="<?= $i ?>">
                        <?= $i + 1 ?>
                    </div>
                <?php endfor; ?>
                
            </div>
    
    
    
            <div class="bc_paging_bottom">
    
                <?php if ($paging['currentPage'] < $paging['totalPages'] - 1) : ?>
                    <div class="bc_paging_button invertHover bc_paging_next" target="<?= $paging['currentPage'] + 1 ?>">
                    <span class="pageArrowHolder singleArrow">
                    <img src="<?= site_url('items/backend/icons/other/oneArrowR.png') ?>" alt="">
                    </span>
                </div>
                <?php endif; ?>
    
                <?php if ($paging['currentPage'] < $paging['totalPages'] - 1) : ?>
                    <div class="bc_paging_button invertHover bc_paging_last" target=<?= $paging['totalPages'] - 1 ?>>
                    <span class="pageArrowHolder">
                    <img src="<?= site_url('items/backend/icons/other/twoArrowR.png') ?>" alt="">
                    </span>
                </div>
                <?php endif; ?>
    
            </div>
            
        </div>





    <?php endif; ?>

