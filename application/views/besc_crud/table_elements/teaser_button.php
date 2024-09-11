
<td class="tdImage">
    <a href="<?php echo $url; ?><?= isset($add_type) && $add_type >= 0 ? '/' . $article_noarticle_type : '' ?><?= $add_pk ? '/' . $pk : '' ?><?= isset($has_article) && $has_article == false ? '/0' : '' ?>" <?= isset($blank) && $blank ? 'target = "_blank" ' : '' ?>>

      <div class='teaserImageHolder'>

          <!-- unpublic images are red -->
          <img <?= $public != 1 ? 'class="unPublicImage"' : '' ?> src='<?= $image_path ?>' alt='Teaser Images' />

      </div>
    </a>

</td>