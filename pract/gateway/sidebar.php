<header class="main-header">
	<a href="<?php echo APPLICATION_URL . 'gateway/action?application=home&action=initiate'; ?>" class="logo">
		<span class="logo-mini"><b>M</b>R</span>
		<span class="logo-lg"><b>Mtutor</b>Reports</span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<a class="logout-btn" href="<?php echo APPLICATION_URL.'gateway/action?application=admin&action=logout' ?>">Logout</a>
	</nav>
</header>
<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
			<li class="header">REPORTS</li>
			<!-- <li <?php if(mtutor_current_application() == 'registration') echo 'class="active"'; ?>>
				<a href="<?php echo APPLICATION_URL . 'gateway/action?application=registration&action=initiate'; ?>">
					<span>Registration Report</span>
				</a>
			</li>
			<li <?php if(mtutor_current_application() == 'test') echo 'class="active"'; ?>>
				<a href="<?php echo APPLICATION_URL . 'gateway/action?application=test&action=initiate'; ?>">
					<span>Login Report</span>
				</a>
			</li> -->
			<li <?php if(mtutor_current_application() == 'truemove') echo 'class="active"'; ?>>
				<a href="<?php echo APPLICATION_URL . 'gateway/action?application=truemove&action=initiate'; ?>">
					<span>TrueMove Report Entry</span>
				</a>
			</li>
			<li <?php if(mtutor_current_application() == 'truemove') echo 'class="active"'; ?>>
				<a href="<?php echo APPLICATION_URL . 'gateway/action?application=truemove&action=get_report'; ?>">
					<span>TrueMove Report</span>
				</a>
			</li>
		</ul>
	</section>
</aside>
