<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Stylesheet -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <link href="<?php echo APPLICATION_URL.'resources/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo APPLICATION_URL.'resources/css/styles.css'; ?>">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript"> 
			var mtsoc_vars	= {
				'base_url'		: '<?php echo APPLICATION_URL; ?>',
				'application'	: '<?php echo $request['application']; ?>'
			}
		</script>
</head>

<body class="page-logon">
    <nav class="navbar col-md-offset-10  fixed-top ">

        <button class="btn btn-primary  float-right" data-target=".bs-example-modal-sm" id="min-logout" data-toggle="modal">Logout</button>

    </nav>
 