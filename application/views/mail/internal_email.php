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

		#content img {
			width: 50%;
			max-width: 350px;
			margin-bottom: 50px;
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
			background-color: #043368;
			cursor: pointer;
			line-height: 44px;
			background-image: url(../img/if_r.png);
			background-size: 20px 20px;
			background-repeat: no-repeat;
			background-position: 95px 13px;
			border: 1px black solid;

		}

		#end_text {
			margin-top: 30px;
			font-size: 12px;
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
			<img src="<?= site_url("items/frontend/img/logo/logo.svg") ?>" alt="">

			<div id="welcome_mes">
				Hi,
			</div>
			
			<div id="end_text">

				Someone just registered to be a member with the following data
				<br>
				<br>
				Product: <?= $product ?><br>
				Name: <?= $first_name . ' ' . $last_name ?><br>
				Email: <?= $email ?><br>
				Phone: <?= $phone ?><br>
				Fax: <?= $fax ?><br>
				Street/Nr: <?= $street ?><br>
				ZIP/City: <?= $zip_city ?><br>
				Send via: <?= $send_via ?><br>
				Paid: <?= $paid ?><br>


			</div>



		</div>
	</div>
</body>

</html>