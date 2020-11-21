(function ($) {
	$.mt_reports = $.mt_reports || {};

	$(document).ready(function () {
		$.mt_reports.on_click();
		$.mt_reports.resetForm();
	});

	$.mt_reports = {
		resetForm: function () {
			$(document).on("click", "input[type='reset']", function (e) {

			});
		},

		on_click: function () {

			$(document).on("click", "button", function (ev) {

				if ($(ev.target).is("button")) {
					if (ev.target.getAttribute("id").trim() == 'get_All') {
						getTable();
					}

					if (ev.target.getAttribute("id").trim() == 'edit_row') {
						var $row = $(this).closest("tr"),
							$tds = $row.find("td:nth-child(1)");

						$.each($tds, function () {
							var id = $(this).text();

							var r_data = "id=" + id;
							$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=get_id', {

									data: r_data,
									cache: false,

								})
								.done(function (responce) {

									var result1 = $.parseJSON(responce);
									$.each(result1, function (key, value) {
										result = value['name'];
									});

									$('#selected-pid').val(result1['result']['id']);
									$('#selected-course').val(result1['result']['course']);
									$('#selected-address').val(result1['result']['address']);
									$('#selected-age').val(result1['result']['age']);
									$('#selected-gender').val(result1['result']['gender']);
									$('#selected-dob').val(result1['result']['dob']);
									$('#selected-name').val(result1['result']['name']);
									$('#selected-email').val(result1['result']['email']);


								});
						});

					}

					if (ev.target.getAttribute("id").trim() == 'user_update') {

						var dob = $(".edit-section #selected-dob").val();
						var name = $(".edit-section #selected-name").val();
						var email = $(".edit-section #selected-email").val();
						var age = $(".edit-section #selected-age").val();
						var gender = $(".edit-section #selected-gender").val();
						var course = $(".edit-section #selected-course").val();
						var id = $(".edit-section #selected-pid").val();
						var address = $(".edit-section #selected-address").val();

						if (isNaN(age)) {
							confirm('please enter numeric values!');
							if (isNaN(age)) {
								$("input[name='selected-age']").focus();
							}
						} else if (isEmail(email) != true) {
							confirm('please enter valid email!');

							$("input[name='selected-email']").focus();

						} else {
							if (dob != '' && name != '' && email != '' && age != '' && gender != '' && course != '' && state != '' && appartment != '' && city != '' && street != '' && zip != '') {

								var r = confirm('Are you sure to submit?');


								if (r == true) {
									var r_data = "id=" + id + "&name=" + name + "&email=" + email + "&dob=" + dob + "&age=" + age + "&gender=" + gender + "&course=" + course + "&address=" + address;


									$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=edit_user', {

										data: r_data,
										cache: false,


									}).done(function (responce) {

										var result = responce.trim();

										/* var result1 = $.parseJSON(responce);
												$.each( result1, function( key, value ) 
													{
														result=value['date'];
													});  */

										if (result == 'updated') {


											$(".edit-section #selected-dob").val('');
											$(".edit-section #selected-name").val('');
											$(".edit-section #selected-email").val('');
											$(".edit-section #selected-age").val('');
											$(".edit-section #selected-gender").val('').prop('checked', false).change();
											$(".edit-section #selected-course").val('');
											$(".edit-section #selected-pid").val('');
											$(".edit-section #selected-address").val('');


											$('#errordisplay').html('');
											$('#editdisplaymsg').html('*Record Updated in database.');
											getTable();
											var id = 'editing-section';

											reset_column(ev, id);
										}
									});
								}
							} else {
								$('#editdisplaymsg').html('');
								$('#errordisplay').html('*Please fill all the fields.');
							}
						}
					}

					if (ev.target.getAttribute("id").trim() == 'delete_row') {

						var $row = $(this).closest("tr"),
							$tds = $row.find("td:nth-child(1)");
						confirm('Confirm Delete?');
						$.each($tds, function () {
							var id = $(this).text();

							var r_data = "id=" + id;
							$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=delete_user', {

								data: r_data,
								cache: false,


							}).done(function (responce) {

								if (responce.trim() == 'deleted') {
									getTable();
									$('#displaymsg1').html('*Record Deleted in  database.');

								}
							});
						});
					}

					if (ev.target.getAttribute("id").trim() == 'register') {
						var dob = $("input[name='dob']").val();
						var name = $("input[name='name']").val();
						var email = $("input[name='email']").val();
						var age = $("input[name='age']").val();
						var gender = $("#gender").val();
						var course = $("#course").val();

						var street = $("input[name='street']").val();
						var appartment = $("input[name='appartment']").val();
						var city = $("input[name='city']").val();
						var state = $("#state").val();
						var zip = $("input[name='zip']").val();

						if (isNaN(age) || isNaN(zip)) {
							confirm('please enter numeric values!');
							if (isNaN(zip)) {
								$("input[name='zip']").focus();
							} else if (isNaN(age)) {
								$("input[name='age']").focus();
							}
						} else if (isEmail(email) != true) {
							confirm('please enter valid email!');

							$("input[name='email']").focus();

						} else {
							if (dob != '' && name != '' && email != '' && age != '' && gender != '' && course != '' && state != '' && appartment != '' && city != '' && street != '' && zip != '') {

								var r = confirm('Are you sure to submit?');

								if (r == true) {
									var address = street + "," + appartment + "," + city + "," + state + "," + zip;
									var r_data = "name=" + name + "&email=" + email + "&dob=" + dob + "&age=" + age + "&gender=" + gender + "&course=" + course + "&address=" + address;


									$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=insert', {

										data: r_data,
										cache: false,

									}).done(function (responce) {



										var result = responce.trim();

										/* var result1 = $.parseJSON(responce);
												$.each( result1, function( key, value ) 
													{
														result=value['date'];
													});  */

										if (result == 'inserted') {

											$("input[name='dob']").val('');
											$("input[name='name']").val('');
											$("input[name='email']").val('');
											$("input[name='age']").val('');
											//$("input[name='gender']").val('').prop('checked', false).change();
											//$("#course").val('');
											$("input[name='street']").val('');
											$("input[name='appartment']").val('');
											$("input[name='city']").val('');
											//$("#state").val('');
											$("input[name='zip']").val('');



											$('#displaymsg').html('');
											$('#displaymsg1').html('*Record inserted into database.');
											getTable();

											//reset_column(ev, id);

										}

									});
								}
							} else {
								$('#displaymsg1').html('');
								$('#displaymsg').html('*Please fill all the fields.');
							}
						}
					}

					if (ev.target.getAttribute("id").trim() == 'reset') {

						ev.preventDefault();
						$('#gender').prop('checked', false);
						$(this).closest('#form1').find('input, radio, select, textarea').not('input[type=reset]').each(function (i, v) {
							$(this).val('');
						});
						var targetElement = $(this).closest('#form1').find('input,radio, select, textrea, a');
						$(targetElement).each(function () {
							if ($(this).hasClass('select2-hidden-accessible') || $(this).hasClass('select2')) {
								$('#' + $(this).attr('id')).select2("val", "");
							}
						});
					}

					if (ev.target.getAttribute("id").trim() == 'main-logout') {


						$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=logout', {
							cache: false,
							success: function (data) {
								var result1 = $.parseJSON(data);
								//console.log(data)
							}

						})
					}

					if (ev.target.getAttribute('id').trim() == "submit_data") {

						var string = $("input[name='string']").val();
						var needtoreplace = $("input[name='needtoreplace']").val();
						var replace_word = $("input[name='replace_word']").val();
						var string_position = $("input[name='string_position']").val();
						if (string != '' && needtoreplace != '' && replace_word != '' && string_position != '') {

							var data = "string=" + string + "&needtoreplace=" + needtoreplace + "&replace_word=" + replace_word + "&string_position=" + string_position

							console.log(data)
							$.ajax(mtsoc_vars.base_url + 'gateway/action?application=basics&action=get_results', {
								method: 'POST',
								data: data,
								cache: false

							}).done(function (data) {

								var result1 = $.parseJSON(data.trim());

								var res = result1['result']

								$('#length').html(res['length']);
								$('#shuffled').html(res['shuffled']);
								$('#count').html(res['wordcount']);
								$('#replace').html(res['replaced']);
								$('#string').html(res['position']);

								$('#lowerstring').html(res['lower']);
								$('#upperstring').html(res['upper']);

								$('#firstLetter').html(res['first_letter']);
								$('#lastLetter').html(res['last_letter']);
								$('#reversed').html(res['reversed']);
								$('#firstLetterupper').html(res['f_upper']);
								$('#firstLetterlower').html(res['f_lower']);

								$('#md5').html(res['md5']);
								$('#space').html(res['whitespaceremoved']);
								$('#compare').html(res['stringcompare']);

							})
						} else {
							alert('EVERY FIELD SHOULD BE FILLED!');
						}
					}

					if (ev.target.getAttribute('id').trim() == "submit_arr") {
						var arr_length = $("#array_length").val();
						var html = '';
						var i = 0;
						for (i; i < arr_length; i++) {
							html += '<label>Enter the value of array index:' + i + '</label>';
							html += '<input type="number" id=' + i + '  autocomplete="off"><br>';
							// console.log( '<input type="number" id=' + i + ' autocomplete="off"><br>')
						}

						$(html).appendTo('#array_values');

					}
					if (ev.target.getAttribute('id').trim() == "proceed") {


						var arr_length = $("#array_length").val();

						var insert = $("input[name='insert']").val();
						var _delete = $("input[name='delete']").val();
						var num_delete = $("input[name='num_delete']").val();
						var search = $("input[name='search']").val();

						var arr = new Array();
						var j = 0;

						for (j; j < arr_length; j++) {
							arr.push($("#" + j).val());

						}
						console.log(arr);


						var data = "arr=" + arr + "&insert=" + insert + "&_delete=" + _delete + "&num_delete=" + num_delete + "&search=" + search;

						console.log(data);


						$.ajax(mtsoc_vars.base_url + 'gateway/action?application=abasics&action=get_results', {

							data: data,
							cache: false,

						}).done(function (responce) {

							console.log(responce)
							var result1 = $.parseJSON(responce.trim());

							var res = result1['result']

							$('#created').html(res['created_array']);

							$('#ascending').html(res['asorted']);

							$('#descending').html(res['wordcount']);

							$('#afterInsert').html(res['inserted_array']);

							$('#afterDelete').html(res['deleted_array']);

							$('#copy').html(res['copy_array']);

							$('#merged').html(res['merged_array']);

							$('#removal').html(res['num_deleted_array']);

							$('#inilength').html(res['ini_count']);

							$('#mergedlength').html(res['mer_count']);

							$('#fiveinsert').html(res['ele_insert']);

							$('#displayfour').html(res['first_four']);


							$('#index').html(res['search']);

							$('#unique').html(res['unique']);


						})

					}

					if (ev.target.getAttribute('id').trim() === "m_add") {

						var name = $("input[name='name']").val();
						var email = $("input[name='email']").val();
						var password = $("input[name='password']").val();



						if (isEmail(email) != true) {
							confirm('please enter valid email!');

							$("input[name='email']").focus();

						} else {
							if (name != '' && email != '' && password != '') {

								var r = confirm('Are you sure to submit?');

								if (r == true) {

									var r_data = "name=" + name + "&email=" + email + "&password=" + password;
									console.log(r_data)

									$.ajax(mtsoc_vars.base_url + 'gateway/action?application=mbasics&action=insert', {

										data: r_data,
										cache: false,

									}).done(function (responce) {


										if (responce.trim() == 'inserted') {
											alert("INSERTED IN TO DB");
										} else {
											alert("NOT INSERTED IN TO DB");
										}
									});
								}
							} else {
								alert("PLEASE ENTER EVERY FIELD")
							}
						}
					}

					if (ev.target.getAttribute('id').trim() === "m_getAll") {

						$("#m_table").empty();

						$.ajax(mtsoc_vars.base_url + 'gateway/action?application=mbasics&action=get_all_id', {


							cache: false,
						}).done(function (responce) {

							var result1 = $.parseJSON(responce);
							var result = result1['result'];

							var html = '<table border="2" id="displaydata"  class="table table-bordered table-hover table-sm" align="center" cellspacing="2" cellpadding="2"><tr> <td><font face="Arial">Id</font></td><td><font face="Arial">Name</font></td><td><font face="Arial">Email</font></td><td><font face="Arial">CREATED DATE</font></td>';

							$.each(result, function (key, row) {

								var field1 = row["id"];
								var field2 = row["userName"];
								var field3 = row["email"];
								var field4 = row["createdDate"];


								html += '<tr class="getAll-table-construct"><td class="nr" name="pid" id="pid">'
								html += field1 + '</td><td>' + field2 + '</td> <td>' + field3 + '</td><td>' + field4 + '</td></tr>'



							});

							html += '</table>'
							$(html).appendTo('#m_table');

						});

					}

					if (ev.target.getAttribute('id').trim() === "m_edit") {


						var name = $("input[name='new_username']").val();
						var email = $("input[name='edit_email']").val();
						var o_password = $("input[name='edit_o_password']").val();
						var n_password = $("input[name='new_password']").val();


						var id = $(".edit-section #selected-pid").val();


						if (isEmail(email) != true) {
							confirm('please enter valid email!');

							$("input[name='selected-email']").focus();



						} else {
							if (name != '' && email != '' && password != '') {

								var r = confirm('Are you sure to submit?');


								if (r == true) {
									var r_data = "name=" + name + "&email=" + email + "&o_password=" + o_password + "&n_password=" + n_password;

									console.log(r_data)
									$.ajax(mtsoc_vars.base_url + 'gateway/action?application=mbasics&action=edit_user', {

										data: r_data,
										cache: false,


									}).done(function (responce) {

										var result = responce.trim();

										/* var result1 = $.parseJSON(responce);
												$.each( result1, function( key, value ) 
													{
														result=value['date'];
													});  */
										console.log(responce)
										if (result == 'updated') {
											alert('UPDATED');
										} else {
											alert('NOT UPDATED');
										}
									});
								}
							} else {
								$('#editdisplaymsg').html('');
								$('#errordisplay').html('*Please fill all the fields.');
							}
						}




					}

					if (ev.target.getAttribute('id').trim() === "m_getById") {

						var id = $("input[name='id_to_get']").val();
						console.log(id)
						var r_data = "id=" + id;
						$.ajax(mtsoc_vars.base_url + 'gateway/action?application=mbasics&action=get_id', {

								data: r_data,
								cache: false,

							})
							.done(function (responce) {

								var result1 = $.parseJSON(responce);
								console.log(result1['result']['userName'])
								// $.each(result1, function (key, value) {
								// 	result = value['name'];
								// });

								$('#e_name').html(result1['result']['userName']);
								$('#e_email').html(result1['result']['email']);
								$('#e_date').html(result1['result']['createdDate']);

							});

					}

					if (ev.target.getAttribute('id').trim() === "m_delete") {

						var email = $("input[name='email_to_delete']").val();
						if (isEmail(email) != true) {
							confirm("ENTER A  VALID EMAIL");
						} else {
							var r = confirm('Confirm Delete?');
							if (r == true) {

								var r_data = "id=" + id;
								$.ajax(mtsoc_vars.base_url + 'gateway/action?application=mbasics&action=delete_user', {

									data: r_data,
									cache: false,
								}).done(function (responce) {

									if (responce.trim() == 'deleted') {
										alert("DELETED")
									}
								});
							}
						}
					}
				}
			});

		},
	};


})(jQuery);

function getTable() {

	$("#displaytable").empty();

	$.ajax(mtsoc_vars.base_url + 'gateway/action?application=user&action=get_all_id', {


		cache: false,
	}).done(function (responce) {

		var result1 = $.parseJSON(responce);
		var result = result1['result'];



		var html = '<table border="2" id="displaydata"  class="table table-bordered table-hover table-sm" align="center" cellspacing="2" cellpadding="2"><tr> <td><font face="Arial">Id</font></td><td><font face="Arial">Name</font></td><td><font face="Arial">Email</font></td><td><font face="Arial">Gender</font></td><td><font face="Arial">Age</font></td><td><font face="Arial">DOB</font></td> <td><font face="Arial">ADDRESS</font></td> <td><font face="Arial">CREATED DATE</font></td><td><font face="Arial">EDIT</font></td> <td><font face="Arial">DELETE</font></td></tr>';

		$.each(result, function (key, row) {

			var field1 = row["id"];
			var field2 = row["name"];
			var field3 = row["email"];
			var field4 = row["gender"];
			var field5 = row["age"];
			var field6 = row["dob"];
			var field7 = row["address"];
			var field8 = row["course"];

			html += '<tr class="getAll-table-construct"><td class="nr" name="pid" id="pid">'
			html += field1 + '</td><td>' + field2 + '</td> <td>' + field3 + '</td><td>' + field4 + '</td><td>' + field5 + '</td><td>'
			html += field6 + '</td><td>' + field7 + '</td><td>' + field8
			html += '</td><td><button id="edit_row" class="btn edit-user">edit</button></td><td><button class="btn  delete-user" id="delete_row">delete';
			html += '</button></td></tr>'


		});

		html += '</table>'
		$(html).appendTo('#displaytable');

	});
}


function reset_column(ev, res) {
	console.log(res)
	if (res == 'editing-section') {

		$('#selected-gender').prop('checked', false);
		$(this).closest('#editing-section').find('input, radio, select, textarea').not('input[type=reset]').each(function (i, v) {
			$(this).val('');
		});
	}
	if (res == 'form1') {
		console.log("here")
		ev.preventDefault();
		$('#gender').prop('checked', false);
		console.log($(this).closest('#form1').find('input, radio, select, textarea').each(function (i, v) {
			console.log($(this).val())

		}))
		$(this).closest('#form1').find('input, radio, select, textarea').each(function (i, v) {
			$(this).val('');
		});
		var targetElement = $(this).closest('#form1').find('input,radio, select, textrea, a');
		$(targetElement).each(function () {
			if ($(this).hasClass('select2-hidden-accessible') || $(this).hasClass('select2')) {
				$('#' + $(this).attr('id')).select2("val", "");
			}
		});
	}
}

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}