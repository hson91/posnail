<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Please sign In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/css/login-style.css" />
    <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <div class="content">
                <div class="header">
                    Please Sign In
                </div>
        	    <?php echo $content; ?>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
