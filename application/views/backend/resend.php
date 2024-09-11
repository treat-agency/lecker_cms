        
        
        <div id="content">
        
            <div class="content_h1">Resend shop E-mails</div>
            <br/>
            <div class="content_h3">Select order</div>
            <form method="post" action="<?= site_url('entities/Shop/resend_email')?>">
                <select id="select_order" name="select_order">
                    <?php foreach($orders->result() as $order):?>
                        <option value=<?=$order->id?>><?= 'Invoice: ' . $order->invoice . ' - ' . $order->orderstatus_ts .  ' - ' . $order->firstname . ' ' . $order->lastname ?></option>
                    <?php endforeach;?>
                </select><br/>
                <br/>
                <div class="content_h3">E-mail</div>
                <input type="text" id="select_email" name="select_email" /><br/>
                <br/>
                <div class="content_h3">Select which mails you want to receive</div>
                <input type="checkbox" id="select_confirmation" name="select_confirmation"> Confirmation E-mail<br/>
                <input type="checkbox" id="select_invoice" name="select_invoice" > Invoice E-mail<br/>
                <br/>
                <input type="submit" value="Resend"/>
            </form>
            
            <?php if(isset($msg)):?>
                <div class="content_h2"><?= $msg?></div>
            <?php endif;?>
            
        </div>        