<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<style>
		body {
			font-size: 18px;
			-ms-text-size-adjust: none;
			-moz-text-size-adjust: none;
			-o-text-size-adjust: none;
			-webkit-text-size-adjust: none;
		}

		td {
			width: 400px;
		}
	</style>
</head>

<body style="font-family: 'Trebuchet MS';width:800px;">

	<div style="font-size:24px;text-align:left;font-family: Trebuchet MS;color:#000;margin-top:20px;font-weight:bold;width:800px;">
		<span style="font-size:24px;">You have been granted access to <br /> <?= $front ? site_url('login') : site_url('backend'); ?> </span><br />

	</div>
	<br />
	<div>Here are your credentials:<br />
		<br />
		Username: <?= $username; ?><br />
		Password: <?= $pw; ?>
	</div>

</body>

</html>