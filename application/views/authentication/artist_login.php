<div id="content" class="content_log">
            <div class="con">                
                <div id="errormessage"><?php if ($errormessage != '') echo $errormessage; ?></div>
               
                <form id="artist_login_form" action="<?= site_url('Frontend/loginArtist') ?>" method="post">
                    <h3>/Login für Künstler*innen</h3>
                    <table>
                        <tbody>
                            <tr >
                                <td class="inputTitleLeft">Username: </td>
                                <td autocomplete="off" class="inputwidth"><input type="text" name="username" id="artist_username" value="" /></td>
                            </tr>
                            <tr >      
                                <td class="inputTitleLeft">Password: </td>
                                <td autocomplete="off" class="inputwidth"><input type="password" name="pword" id="artist_pword" value="" /></td>
                            </tr>
                            <tr>
                                
                                <td colspan="2">
                                  <!--   <span id="pv"><a id="forget_pw" href="#">Forgot your password?</a> </span>--> 
                                    <input type="submit" id="submitbutton" value="LOG IN" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

            </div>
        </div>


<style>
    h3 {
    padding-top: 50px;
    font-size: 80px;
    font-weight: 700;
    line-height: normal;
    text-transform: lowercase;
    margin-bottom: 50px;    
    }

	.inputTitleLeft {
		width: 250px;
		font-size: 30px;
		font-weight: 700;
	}



    tr {
        /* vertical-align: top; */
        margin-bottom: 100px;
        height: 100px;
    }

    #submitbutton {
        outline: none;
        border: none;
        width: 200px;
        height: 72px;
        text-align: center;
        line-height: 72px;
        font-family: 'Helvetica';
        font-size: 30px;
        font-weight: 700;
        color: white;
        background-color: black;
        cursor: pointer;
        margin: auto;
    }

    #artist_username, #artist_pword {

        outline: 1px solid black;
        border: 1px solid black;
        background-color: white;
        
        width: 500px;
        height: 60px;

        padding: 10px;

        text-align: center;
        line-height: 72px;
        font-family: 'Helvetica';
        font-size: 30px;
        font-weight: 700;

        cursor: pointer;
        margin: auto;

    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        font-size: 30px !important;
        font-weight: 700 !important;
    }

    input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
    font-size: 30px !important;
        font.weight:700 !important;
}

</style>