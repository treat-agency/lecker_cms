<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


	<style>
		body {

			font-family: 'Helvetica';
			font-size: 14px;
			color: #fff;
			-ms-text-size-adjust: none;
			-moz-text-size-adjust: none;
			-o-text-size-adjust: none;
			-webkit-text-size-adjust: none;
			width: 100%;
			height: 100%;

			margin: 0;
			padding: 0;
		}

		#content {

			justify-content: center;
			height: 100vh;
			font-family: 'Helvetica';
			line-height: 25px;
			color: black;
			-ms-text-size-adjust: none;
			-moz-text-size-adjust: none;
			-o-text-size-adjust: none;
			-webkit-text-size-adjust: none;

			font-family: 'Helvetica';
			width: 80%;
			max-width: 800px;
			background: #ffffff;
			margin: 0px auto 0px;
			font-size: 14px;
			padding: 20px;
			border-left: 1px solid #000;
			border-right: 1px solid #000;
		}

		#welcome_mes {
			font-size: 18px;
			text-align: left;
			margin-bottom: 20px;
		}

		#button {
			width: 160px;
			height: 44px;
			border: none;
			font-size: 16px;
			font-family: 'Helvetica';
			text-decoration: none;
			text-align: center;

			z-index: 100;
			color: #fff !important;
			background-color: black;
			cursor: pointer;
			line-height: 44px;
			background-image: url(../img/if_r.png);
			background-size: 20px 20px;
			background-repeat: no-repeat;
			background-position: 95px 13px;
			border: 1px black solid;

		}

		#end_text {
			margin-top: 30px
		}

		#bg {
			width: 100%;
			height: 100%;
			background: #fff;
		}
	</style>
</head>

<body>
	<div id="bg">
		<div id="content">
			<div id="welcome_mes">
				Hi <?= $username ?>,
				<br />
				Please Reset your password by clicking the button below.
			</div>
			<a style="color:black; text-decoration: none;" href="<?= site_url("reset_password/" . $user_id . "/" . $token); ?>">
				<div id="button"> Reset password </div>
			</a>
			<div id="end_text">
				If you can’t see the button copy paste this link into your browser: <br>
				<small>
					<?= site_url("reset_password/" . $user_id . "/" . $token); ?>
				</small>
			</div>
		</div>
	</div>
</body>

</html>