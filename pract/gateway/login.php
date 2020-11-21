<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mtutor Reports Login</title>
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
</head>

<body class="page-logon">
    <div id="site" class="clearfix">
        <!-- Header Start -->
        <header id="mast-head">
            <?php //$this->view('primary_navigation'); ?>
        </header>
        <!-- Header End -->
        <!-- Content Start -->
        <main id="main-content" class="clearfix" role="main">
            <div class="logon-panel">
                <div class="logon-header">Login to Continue</div>
                <div class="logon-box">
                    <form method="POST" action="action?application=admin&action=login">
                        <?php if(isset($request['display']) && $request['display'] == 'error') { ?>
                        <div class="validation-error">
                            Invalid Username / Password.
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="group-icon">
                                <input type="text" placeholder="Username" class="form-control" id="username"
                                    name="username" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="group-icon">
                                <input type="password" placeholder="Password" class="form-control" id="password"
                                    name="password" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success login-btn">Login</button>
                        </div>
                        <!--<div class="form-group">
							<a href="#" class="forgot-btn">Forgot Password?</a>
						</div>-->
                    </form>
                </div>
            </div>