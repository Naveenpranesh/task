<div class="content-wrapper">
	<section class="content-header">
		<h1>TrueMove Data Entry</h1>
	</section>
	<section class="content">
		<form id="true_entry">
			<div class="box box-default">
				<div class="box-body">
						<div class="row form-group">
							<div class="col-md-2 ">
								<label for="rep_date" class="control-label">Entry Date:</label>
								<input type="text" id="f" class="form-control control-datepicker single_date" name="rep_date" value="<?php echo $today; ?>" >
							</div>
							<div class="col-md-2 " style="padding-top:25px;">
								<a id="check_entry" class="btn btn-primary btn-md">Check</a>
							</div>
							<div class="col-md-4 ">
								<div id="displaymsg"  style="color:red;padding-top:25px;"></div>
							</div>
						 </div>
						<div class="row form-group">
							<div class="col-md-4 ">
								<label for="new_sub" class="control-label">New Subscription:</label>
								<input id="f1" type="text" class="form-control " name="new_sub"   autofocus  placeholder="New Subscription">
                            </div>
							<div class="col-md-4 ">
								<label for="un_sub" class="control-label">Unsubscription:</label>
								<input id="f2" type="text" class="form-control" name="un_sub" pattern="[0-9]{100}" autofocus  placeholder="Unsubscription">
							</div>
							<div class="col-md-4 ">
								<label for="active_sub" class="control-label">Active Subscription:</label>
								<input id="f3" type="text" class="form-control" name="active_sub" autofocus  placeholder="Active Subscription">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-4 ">
								<label for="tot_trans" class="control-label">Total Transfer:</label>
								<input id="f4" type="text" class="form-control " name="tot_trans"   autofocus placeholder="Total Transfer">

                            </div>
							<div class="col-md-4 ">
								<label for="tot_trans" class="control-label">MT Success:</label>
								<input id="f5" type="text" class="form-control" name="mt_succ"  autofocus placeholder="MT Success">
							</div>
						</div>
						<div class="row form-group">
							<div class=" col-md-1 ">
								<a id="report_entry" class="btn btn-success btn-md"  style="margin-left: 10px;">Submit</a> 
							</div>
							<div class=" col-md-4 ">
								<div id="displaymsg1" style="color:red;padding-top:10px;"></div>
							</div>
						</div>
				</div>
			</div>
		</form>
	</section>
</div>