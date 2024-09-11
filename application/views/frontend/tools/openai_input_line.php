<link rel="stylesheet" type="text/css" href="<?= site_url("items/openai/openai.css?ver=" . VERSION); ?>">
<? include(getcwd() . '/items/openai/openai_script.php'); ?>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<select id="o_language" data-placeholder="Choose a Language..." id="language_selector">
  <? foreach ($languages as $key => $language): ?>
              <? if ($key < 10): ?>
                        <option value="<?= $language->id ?>"><?= $language->language ?></option>
              <? endif; ?>
  <? endforeach; ?>
</select>


<br>
<br>
<br>

<input type="text" id="inputField" placeholder="Ask something...">
<div class="buttonHolder" chat_id="<?= $last_chat_id ?>">
  <? foreach ($prompts as $prompt): ?>
          <button class="o_button" topic="<?= $prompt->topic ?>"><?= $prompt->question ?></button>
  <? endforeach; ?>
</div>

<div class="responseHolder">
  <div class="response "></div>
</div>
