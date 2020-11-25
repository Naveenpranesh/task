<?php //echo $application_name;?>
<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo $report_name; ?></h1>
	</section>
	<section class="content">
		<form id="mtutor-form-<?php echo $request['application']; ?>">
			<div class="box box-default">
				<div class="box-body">
					<div class="row">
						<?php echo $form; ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<a id="report-submit" class="btn btn-primary" data-application="<?php echo $request['application']; ?>">Submit</a>
									<input type="reset" value="Reset" class="btn btn-danger" style="margin-left: 10px;"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div id="ajax-result"></div>
	</section>
</div>

	