
    <div 
        class="mosaic mosaic_image" 
        <?php if($isBackend):?>db_id=<?= $module['id']?><?php endif;?>
        <?php if($isBackend):?>mosaic_id=<?= $i?><?php endif;?> 
        style=" left: <?= $module['posX']?>px; top: <?= $module['posY']?>px; width: <?= $module['width']?>px; 
                height: <?= $module['height']?>px; z-index: <?= $module['zIndex']?>; 
                background-color: <?= $module['bg_color'] != null ? $module['bg_color'] : 'transparent'?>;"
    >
        <?php if($isBackend):?>
            <div class="mosaic_tools">
                <div class="mosaic_tool move"></div>
                <div class="mosaic_tool edit"></div>
            </div>
            <img class="mosaic_content_image" src="<?= site_url(''.$module['filepath']) ?>" />
        <?php else:?>
            <img class="mosaic_content_image" src="<?= site_url(''.$module['filepath']) ?>" />
        <?php endif;?>
    </div>
    