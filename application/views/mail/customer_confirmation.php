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
			font-family: 'Helvetica';
		}

		td {
			width: 400px;
		}
		
		
		#button {
            background: #000;
            color: #fff;
            text-align: center;
            width: 180px;
            padding: 5px;
            cursor: pointer;
            text-transform: uppercase;
            margin:20px 0px;
        }
		
	</style>
</head>

<body style="width:800px;">

	Vielen Dank, dass Sie sich registriert haben.
	<br/>
	Bitte klicken Sie auf diesen Link, um ihre E-Mail-Adresse zu bestätigen und damit Ihren Account zu aktivieren.
    <a style="text-decoration:none;" href="<?= site_url('confirm_registration/'.$confirmation_token) ?>">
    	<div id="button">Bestätigen</div>
    </a>
    Sollten Sie keinen Button sehen, kopieren Sie diesen Link in Ihren Browser:<br/>
    <?= site_url('confirm_registration/'.$confirmation_token) ?>
	</div>
	
	

</body>

</html>