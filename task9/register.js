$(document).ready(function () {

    $("#submit").click(function () {

        var name = $("#name").val();
        var email = $("#email").val();
        var dob = $("#dob").val();
        var age = $('#age').val();
        var gender = $('#gender').val();
        var course = $('#course').val();
        var street = $('#street').val();
        var appartment = $('#appartment').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var zip = $('#zip').val();

        var address = street + "," + appartment + "," + city + "," + state + "," + zip;

        var data = "name=" + name + "&email=" + email + "&dob=" + dob + "&age=" + age + "&gender=" + gender + "&course=" + course + "&address=" + address; //+street+appartment+city+zip;




        $.ajax({
            method: "post",
            url: "register.php",
            data: data,
            success: function (data) {
                $("#register_output").html(data);
            }



        });
        $.ajax({
            method: "post",
            url: "getall.php",
            data: data,
            success: function (data) {
                $("#getAll_output").html(data);
            }
        });

    });
   
});

$(document).ready(function () {

    var name = $("#name").val();
    var email = $("#email").val();
    var dob = $("#dob").val();
    var age = $('#age').val();
    var gender = $('#gender').val();
    var course = $('#course').val();
    var street = $('#street').val();
    var appartment = $('#appartment').val();
    var city = $('#city').val();
    var state = $('#state').val();
    var zip = $('#zip').val();

    var address = street + "," + appartment + "," + city + "," + state + "," + zip;

    var data = "name=" + name + "&email=" + email + "&dob=" + dob + "&age=" + age + "&gender=" + gender + "&course=" + course + "&address=" + address; //+street+appartment+city+zip;



    $.ajax({
        method: "post",
        url: "getall.php",
        data: data,
        success: function (data) {
            $("#getAll_output").html(data);
        }
    });
});