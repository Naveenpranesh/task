<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>mTutor Reports</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?php echo APPLICATION_URL.'resources/css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo APPLICATION_URL.'resources/css/styles.css'; ?>"> 
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo APPLICATION_URL.'resources/css/theme.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo APPLICATION_URL.'resources/css/skin-blue.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo APPLICATION_URL.'resources/css/daterangepicker-bs3.css'; ?>">
		<link rel="stylesheet" href="<?php echo APPLICATION_URL.'resources/css/select2.min.css'; ?>">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript"> 
			var mtsoc_vars	= {
				'base_url'		: '<?php echo APPLICATION_URL; ?>',
				'application'	: '<?php echo $request['application']; ?>'
			}
		</script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<!-- Ajax Loader -->
		<div id="ajaxSpinnerContainer"></div>
		<div class="wrapper">
		<?php include('sidebar.php'); ?>