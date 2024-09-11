<link rel="stylesheet" type="text/css" href="<?= site_url("items/frontend/css/_forms.css?ver=") . time(); ?>">





 <div class='container1200' style="    background-color: #DAD9D4;">

 <div class="formHolder">

 <? if($special_head): ?>
   <div class="topInfoHeader bold45"><?= $special_head ?></div>
      <br>
<? endif ?>
   <form method='POST' id='form'>


  <div class="topInfoInfo bold18"><?= $this->lang->line('school_form_title') ?></div>
  <div class="topInfoInfo bold18"><?= $this->lang->line('program') ?>: <?= $item->name ?></div><br/>
  <input type="text" placeholder="<?= $this->lang->line('firstname') ?>*" name='firstname' /><br>
  <input type="text" placeholder="<?= $this->lang->line('lastname') ?>*" name='lastname' /><br>
  <input type="text" placeholder="<?= $this->lang->line('school_address') ?>*" name='address' /><br>
  <input type="text" placeholder='E-Mail*' name='email' /><br>
  <input type="text" placeholder="<?= $this->lang->line('phone') ?>*"  name='phone' /><br>
  <input type="text" placeholder="<?= $this->lang->line('number_of_ppl') ?>*" name='number_of_ppl' /><br>
  <input type="text" placeholder="<?= $this->lang->line('grade_age') ?>*" name='grade_age' /><br>
  <input type="text" placeholder="<?= $this->lang->line('desired_date') ?>*" name='desired_date' /><br>
  <input type="text" placeholder="<?= $this->lang->line('desired_time') ?>*" name='desired_time' /><br>
  <input type="text" placeholder="<?= $this->lang->line('form_note') ?>" name='note' /><br>

   <div class="formGrouper">
     <input type='checkbox' name='daten' />
     <label for="daten"><?= $this->lang->line('daten')  ?></label>
   </div>

   <input type="hidden" value="<?= $table_name ?>" name="table_name" id="table_name">
  <input type="hidden" value="<?= $email_to ?>" name="email_to" id="email_to">
  <input type="hidden" value="<?= $item->pretty_url ?>" name="programme" id="referrer">
  <input type="hidden" value="<?= $type ?>" name="type" id="type">


   <br>
   <button class="js-form_button button noWidthButton fullButton blackButton"> <?= $this->lang->line('school_reg_request')  ?></button>


   </form>


   <div id="form_message"></div>


 </div>


</div>