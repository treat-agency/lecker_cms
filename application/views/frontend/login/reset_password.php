<style>
    #menu_items,
    .logging_btn {
        display: none
    }

    #log_in_input_btn{
        margin: auto;
    }

    #reset_password_final_btn, #reset_password_backend_btn {
        cursor:pointer;
        color: white;
        padding: 0.5em;
        background-color: black;
        width: 200px;
        text-align: center;
        margin: auto;
    }

    #log_in_input_btn {
        text-align: center ;
    }

    #welcome {
        text-align: center;
    }

    .treat_error_msg {
        text-align: center;
    }
</style>

<div id='login_page_holder' class="page_holder regular">


    <div id='login_container' class="">
        <?php if ($status):?>
            <h1 id="welcome" class='form_title'>Reset password</h1>
            <br>
            <br>
            <div id="log_in_input_btn">
                <input id="reset_password_field" class='login_row treat_input login_input' type="password" name="" placeholder='Password'>
                <input id="reset_password_r_field" class='login_row treat_input login_input' type="password" name="" placeholder='Repeat password'>
                <br>
                <br>
                <div id="reset_password_backend_btn" user_id='<?=$user->id?>' class='login_row login_btn treat_btn'>reset password</div>
            </div>
            <br>
            <div class="treat_error_msg">

            </div>
        <?php else:?>
            <div id="welcome" class='form_title'>Something went wrong.</div>
        <?php endif;?>
    </div>


</div>