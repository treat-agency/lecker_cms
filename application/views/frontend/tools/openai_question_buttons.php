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

<div class="questionHolder" chat_id="<?= $new_chat_id ?>">
  <? foreach ($prompts as $prompt): ?>
        <div class="question o_question" topic="<?= $prompt->topic ?>">
      </div>
<? endforeach; ?>
</div>
<br>
<div class="responseHolder">
  <div class="response ">
    </div>
    <div class="locationHolder">

    </div>
</div>
