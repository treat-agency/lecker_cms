
    <div 
        class="mosaic mosaic_text" 
        <?php if($isBackend):?>db_id=<?= $module['id']?><?php endif;?>
        <?php if($isBackend):?>mosaic_id=<?= $i?><?php endif;?> 
        style=" left: <?= $module['posX']?>px; top: <?= $module['posY']?>px; width: <?= $module['width']?>px; 
                height: <?= $module['height']?>px; z-index: <?= $module['zIndex']?>; 
                background-color: <?= $module['bg_color'] != null ? $module['bg_color'] : 'transparent'?>;
	            line-height: <?= ($module['line_height'] != null && $module['line_height'] != 0)? $module['line_height'].'px' : ''?>;"
    >
        <?php if($isBackend):?>
            <div class="mosaic_tools">
                <div class="mosaic_tool move"></div>
                <div class="mosaic_tool edit"></div>
            </div>
            <div class="mosaic_content has_placeholder"><?= $module['content'] ?></div>
        <?php else:?>
        	<?= $module['content'] ?>     
        <?php endif;?>
    </div>

    