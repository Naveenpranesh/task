(function($) {
	$.mt_reports = $.mt_reports || {};

	$(document).ready(function() {
		$.mt_reports.init();
		$.mt_reports.resetForm();
		$.mt_reports.mtutor_form_submit();
		$.mt_reports.report_entry();
	});

	$.mt_reports = {
		resetForm: function () {		
			$(document).on("click", "input[type='reset']", function(e){
				e.preventDefault();
				$(this).closest('form').find('input, select, textrea').not('.control-datepicker').not('input[type=reset]').each(function(i, v) {
					$(this).val('');
				});
				var targetElement = $(this).closest('form').find('input, select, textrea, a');
				$(targetElement).each(function () {
					if( $(this).hasClass('select2-hidden-accessible') || $(this).hasClass('select2') ){
						$('#' + $(this).attr('id')).select2("val", "");
					}
				});
			});
		},
		init: function() {
			var $loading = $('#ajaxSpinnerContainer');
			$(document).ajaxStart(function () {
				$loading.show();
			}).ajaxStop(function () {
				$loading.hide();
			});
			$(".select2").select2({
				maximumSelectionLength: 5,
				placeholder		: "Select upto 5 choice",
				closeOnSelect	: false
			});
			$(".select2").change(function(){
				var ele = $(this);
				if(ele.val() != null){
					if(ele.val().length==5)
					{
						ele.select2('close');
					}
				}
			});
			var startDate = new Date();
			startDate.setDate(startDate.getDate() - 60);
			
			$('.control-datepicker').each(function() {
				if( $(this).hasClass("single_date") ) {
					if( $(this).hasClass("start") ) {
						$(this).daterangepicker({
							singleDatePicker	: true,
							showDropdowns		: true,
							autoApply	: true,
							locale		: {
								format	: 'DD-MM-YYYY'
							},
							startDate	: startDate,
							minDate		: "01/01/2016",
							maxDate		: new Date()
						});
					} else {
						$(this).daterangepicker({
							singleDatePicker	: true,
							showDropdowns		: true,
							autoApply	: true,
							locale		: {
								format	: 'DD-MM-YYYY'
							},
							endDate		: new Date(),
							minDate		: "01/01/2016",
							maxDate		: new Date()
						});
					}
				} else {
					$(this).daterangepicker({
						showDropdowns	: true,
						autoApply	: true,
						locale		: {
							format: 'DD-MM-YYYY'
						},
						startDate	: startDate,
						endDate		: new Date(),
						minDate		: "01/01/2016",
						maxDate		: new Date()
					});
				}
			});
		},
		mtutor_form_submit: function() 
		{
			
		},
		report_entry: function() 
		{
			$('.form-control').keydown(function(e) {
					if (e.keyCode == 13) 
					{
						$("#report_entry").trigger("click");
					}
				});
			
			
			
			$('#check_entry').click(function()
			{
				
				var day = $("input[name='rep_date']").val();
				var send='date='+day;
				$.ajax(mtsoc_vars.base_url+'gateway/action?application=truemove&action=fetch_data',   // request url
						{      
							data:send ,
							cache: false,
								
						}
				).done(function( data ) 
						{
							var result = $.parseJSON(data);
							var en_date='',newsub,unsub,activesub,tottrans,mtsucc;
							$.each( result, function( key, value ) 
							{
								en_date=value['date'];
								newsub=value['new_sub'];
								unsub=value['un_sub'];
								activesub=value['active_sub'];
								tottrans=value['total_trans'];
								mtsucc=value['mt_success'];
							
							});
							
							if(en_date!='')
							{	
								$('#displaymsg1').html('');
								$('#displaymsg').html('*Record exists in database.');
								 $("#f1").val(newsub);
								$("#f2").val(unsub);
								$("#f3").val(activesub);
								$("#f4").val(tottrans);
								$("#f5").val(mtsucc);
							}
							else
							{
								var msg='date_no';
								$.mt_reports.formreset(msg);
								$('#displaymsg1').html('');
								$('#displaymsg').html('*No record found on this day.');
							}
						});
			});
			$('#report_entry').click(function()
			{
				var r_date = $("input[name='rep_date']").val();
				var r_ns = $("input[name='new_sub']").val();
				var r_us = $("input[name='un_sub']").val();
				var r_as = $("input[name='active_sub']").val();
				var r_tt = $("input[name='tot_trans']").val();
				var r_ms = $("input[name='mt_succ']").val();
				if(isNaN(r_ns)||isNaN(r_us)||isNaN(r_as)||isNaN(r_tt)||isNaN(r_ms))
				{
					confirm('please enter numeric values!');
					if(isNaN(r_ns))
					{
						$("input[name='new_sub']").focus();
					}
					else if(isNaN(r_us))
					{
						$("input[name='un_sub']").focus();
					}
					else if(isNaN(r_as))
					{
						$("input[name='active_sub']").focus();
					}
					else if(isNaN(r_tt))
					{
						$("input[name='tot_trans']").focus();
					}
					else if(isNaN(r_ms))
					{
						$("input[name='mt_succ']").focus();
					}
				}
				else
				{
						if(r_date!=''&&r_ns!=''&&r_us!=''&&r_as!=''&&r_tt!=''&&r_ms!='')
						{
							
							confirm('Are you sure to submit!');
							var r_data='date='+r_date+'&newsub='+r_ns+'&unsub='+r_us+'&actsub='+r_as+'&tottrans='+r_tt+'&mtsucc='+r_ms;
							$.ajax(mtsoc_vars.base_url+'gateway/action?application=truemove&action=insert',
									{   
										
										data:r_data ,
										cache: false,
											
									}
							).done(function(responce)
							{
								var msg='date_val';
								$.mt_reports.formreset(msg);
								var en_date=responce;
								  /* var result1 = $.parseJSON(responce);
									$.each( result1, function( key, value ) 
										{
											en_date=value['date'];
										});  */
									
									if(en_date!='inserted')
									{
										$('#displaymsg').html('');
										$('#displaymsg1').html('*Record updated in database.');
									}
									else
									{
										$('#displaymsg').html('');
										$('#displaymsg1').html('*Record inserted into database.');
									}
							}) ;
						}
						else
						{
							$('#displaymsg1').html('');
							$('#displaymsg').html('*Please fill all the fields.');
						}
				}	
			});
			
			
		},
		formreset : function(res)
		{
			if(res=='date_val')
			{
				var today = moment().format('DD-MM-YYYY');
				$('#f').val(today);
			}
			$('#report_entry').closest('#true_entry').find('input').not('.control-datepicker').each(function(i, v) {
					$(this).val('');
				}); 
		}
	};
	
})(jQuery);