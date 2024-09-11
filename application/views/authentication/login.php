<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <!-- TITLE -->
  <title><?= SITE_NAME ?> CMS</title>

  <!-- META -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/reset.css"); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/fonts.css"); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/backend/css/backend.css?ver=") . time(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= site_url("items/general/css/jquery-ui.css"); ?>">

  <link rel="stylesheet" type="text/css" href="<?= site_url("items/authentication/css/authentication.css?ver=") .time(); ?>">

  <!-- FAVICON -->
  <link rel="icon" type="png" href="https://www.treat.agency/items/frontend/img/lollipop.png">
  <!-- <link rel="icon" type="image/png" href="../../../items/frontend/img/logo/favicon.png"> -->

  <!-- JS -->
  <script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-1.11.2.min.js"); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/general/js/libraries/jquery-ui.min.js"); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/backend/js/backend.js"); ?>"></script>
  <script type="text/javascript" src="<?= site_url("items/backend/js/login.js?ver=" . VERSION); ?>"></script>


  <!-- VARIABLES -->
  <script type="text/javascript">
    var rootUrl = "<?= site_url(); ?>";
  </script>
</head>

<body>
  <div id="backend_container">

    <div id="content" class="content_log">
      <div class="con">
        <div id="logo_holder">
          <img id="mfnm1" src="<?= site_url() . "items/backend/logo/lecker2024.svg"?>" style="width:220px;">

          <!-- // treatstart -->
          <!-- feel free to add logo -->
          <!-- <img id="mfnm" style="width:165px;" src="<?= site_url('items/frontend/img/logo/logo.png') ?>" /> -->
          <div id="mfnm" style="font-size:36px;"><?= LOGO_IMAGE != '' ? site_url(LOGO_IMAGE) : SITE_NAME ?></div>
        </div>

        <div class="centerLogin">

          <div id="errormessage"><?php if ($errormessage != '') echo $errormessage; ?></div>
          <div id="resetpw_overlay">
            <form id="reset_form" action="<?= site_url('Authentication/resetPw') ?>" method="post">
              <h3>Reset Password</h3> </br>
              <input type="text" name="email" placeholder="Email:"><br>
              <input type="button" class="reset_button" id="close_reset" value="Close" />
              <input type="submit" class="reset_button" id="send_reset" value="Send" />
            </form>
          </div>

          <form id="authentication_form" action="<?= site_url('Authentication/loginUser/?previous_url=' . $previous_url) ?>" method="post">
            <h3>LOGIN</h3>
            <p class="welcomeP">Welcome to our CMS System</p>

            <div class="newLoginBox">

              <div class="inputwidth loginInput"><input type="text" name="username" id="username" value="" placeholder="Username" /></div>
              <div class="inputwidth loginInput"><input type="password" name="pword" id="pword" value="" placeholder="Password" />
              </div>

              <div class="loginButtons">
                <div class="loginButton authButton">
                  <input type="submit" id="submitbutton" class="button ui-rounded1" value="Login" />
                </div>
                <div id="pv" class="forgotButton authButton ui-rounded1">
                      <div id="forget_pw">Forgot password</div>
                </div>
                <br>
              </div>

              <div class="poweredTreat">
                <span>powered by</span>
                <img id="" src="<?= site_url() . "items/general/img/treat_logo_2023.svg"?>">
              </div>

            </div>


          </form>

        </div>



      </div>
    </div>

  </div>
</body>
</html>