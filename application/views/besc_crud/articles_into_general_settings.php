<?


$itemsToEdit = array();

function createItemToEdit($item = null, $lang = null, $pk_value = null, $article_type = '')
  {
  $itemToEdit = (object) array();
  $itemToEdit->id = $item ? $item->id : 0;
  $itemToEdit->name = $item ? $item->name : "name";
  $itemToEdit->teaser = $item ? $item->teaser : "teaser";
  $itemToEdit->pretty_url = $item ? $item->pretty_url : "";
  $itemToEdit->visible = $item ? $item->visible : 0;
  $itemToEdit->seo_description = $item ? $item->seo_description : "";
  $itemToEdit->og_description = $item ? $item->og_description : "";
  $itemToEdit->external_url = $item ? $item->external_url : "";
  $itemToEdit->type = $item ? $item->type : $article_type;
  $itemToEdit->entity_id = $item ? $item->entity_id : (isset($pk_value) ? $pk_value : 0);
  $itemToEdit->lang = $item ? $item->lang : $lang['key'];
  $itemToEdit->original_item_id = $item ? $item->original_item_id : '';
  $itemToEdit->languageName = strtoupper($itemToEdit->lang) ;
  return $itemToEdit;
  }


if (count($articlesForEntity)):


  foreach ($articlesForEntity as $item) {

    $itemsToEdit[] = createItemToEdit($item);
    }

  if (count($itemsToEdit) == 1):
    foreach ($languageArray as $lang) {
      if ($lang['key'] != $itemsToEdit[0]->lang):
        $itemsToEdit[] = createItemToEdit(null, $lang, $pk_value, $article_type);
      endif;
      }
  endif;
elseif ($article_type):
  foreach ($languageArray as $lang) {
    $itemsToEdit[] = createItemToEdit(null, $lang, (isset($pk_value) ? $pk_value : $next_entity_id), $article_type);
    }
endif;


      function getPrettyName($name){
    // makes normal name from table name

        $name_array = explode('_', $name);
        $pretty_name = '';

          foreach($name_array as $key=>$word){
            if($key == 0){
                // first letter in capital
                $add = ucfirst($word);
            } else {
                $add = $word;
            }

            if($key != count($name_array)){
                 $pretty_name .= $add . ' ';
            } else {
                $pretty_name .= $add;
            }

          }
          return $pretty_name;
    }


  $disabled = array('id', 'lang', 'entity_id', 'original_item_id', 'type', 'languageName');
  $selector = array('visible');

    ?>


  <?php

  if (!$is_article): ?>

  <style>
  .crudInfo {
    display: none;
  }
</style>


  <?


    foreach ($itemsToEdit as $item): ?>

        <form class="item_edit_table" item_id="<?= $item->id ?>" lang="<?= $item->lang ?>">
          <div class="langTitle">Article <?= $item->languageName ?></div>

          <?php foreach (get_object_vars($item) as $property => $value):

            $propertyPrettyName = rtrim(getPrettyName($property)) . ":";

            $labelDescription = '';
            // switch()

            $style = in_array($property, $disabled) ? 'hideClass' : '';

            $tempLabel = "";
            $tempLabelInfo = "";


            switch ($propertyPrettyName) {
              case 'Pretty url:':
                $tempLabel = 'Pretty url:';
                $tempLabelInfo = 'This is the URL for this article. It needs to be unique and may not contain spaces and special characters';
                break;

              case 'Visible:':
                $tempLabel = 'Visible:';
                $tempLabelInfo = 'Set the visibility of your article here: ';
                break;

              case 'Seo description:':
                $tempLabel = 'SEO description:';
                $tempLabelInfo = 'The description of the article for search engine optimization';
                break;

              case 'Og description:':
                $tempLabel = 'OG description:';
                $tempLabelInfo = 'The description of the article that shows up when you share the URL via social media or direct message';
                break;

                case 'External url:':
                $tempLabel = 'Redirect to external URL:';
                $tempLabelInfo = 'If filled out the article will automatically redirect to the given address. Use absolute addresses';
                  break;

              default:
                break;
            }


            ?>

            <? if ($property == 'visible'): ?>
              <div class="itemField <?= $style ?>">
                <label for="<?= $property ?>"><?= $tempLabel ?></label>
                <p class="bc_column_info"><i><?= $tempLabelInfo?> </i></p>
                <select class="ui-rounded1" type="text" id="<?= $property ?>" name="<?= $property ?>" value="<?= $value ?>">
                  <option value="<?= VISIBLE ?>" <?= $value == VISIBLE ? 'selected' : '' ?>>Visible</option>
                  <option value="<?= DIRECT_ONLY ?>" <?= $value == DIRECT_ONLY ? 'selected' : '' ?>>Direct only</option>
                   <option value="<?= LOGGED_ONLY ?>" <?= $value == LOGGED_ONLY ? 'selected' : '' ?>>Logged in only</option>
                  <option value="<?= HIDDEN ?>" <?= $value == HIDDEN ? 'selected' : '' ?>>Hidden</option>
                </select>
              </div>

             <? elseif ($property == 'teaser'): ?>
              <div class="itemField <?= $style ?>">
                <label for="<?= $property ?>"><?= $propertyPrettyName ?></label>
                <textarea class="ui-rounded1" id="<?= $property ?>" name="<?= $property ?>" value="<?= $value ?>"><?= $value ?></textarea>
              </div>



            <? else: ?>
              <div class="itemField <?= $style ?>">
                <label for="<?= $property ?>"><?= $tempLabel ?></label>
                <p class="bc_column_info"><i><?= $tempLabelInfo?> </i></p>
                <input class="ui-rounded1" type="text" id="<?= $property ?>" name="<?= $property ?>" value="<?= $value ?>" />
              </div>

            <? endif; ?>

          <?php endforeach; ?>

          <?php
          if ($item->id != 0): ?>
              <? $tempLang = $item->languageName == "DE" ? "german" : "english" ; ?>
              <p class="bc_column_info"><i>By deleting the <?= $tempLang ?> article you remove it from the website.</i></p>
              <div class="deleteArticle ui-rounded1 invertHover" item_id="<?= $item->id ?>" lang="<?= $item->lang ?>">Delete</div>
          <?php endif; ?>

        <?php if (NUMBER_OF_LANGUAGES > 1 && $item->id != 0 && $item->lang == MAIN_LANGUAGE): ?>
      <div class="cloneModuleButton" pk_value="<?= $item->id ?>">
      <span class="unselectable item_clone ui-rounded1 invertHover" title="Clone" type="html">Clone article content to English</span>
      <br>
      <br>
      <p class="bc_column_info"><i>All modules and content will be moved for translation to the English article. Attention: this will overwrite existing content.</i></p>

    </div>
  <? endif; ?>

        </form>

        <br>
    <?php endforeach;

  endif;
  ?>


  <div class="bc_delete_dialog_article" display="none" style="display: none;">
		<h3> Delete </h3>
		<p id="article_delete_dialog" class="bcDeleteText"> Are you sure you want to delete this article?
		</p>

    <div class="df-jcc gap5">
      <div class="bc_delete_button basicButton invertHover js_delete_really_article">Delete</div>
      <div class="bc_delete_button basicButton invertHover js_delete_cancel_article">Cancel</div>
    </div>

	</div>
