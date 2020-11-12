$(document).ready(function () {
    $("#editing").click(function () {

        var id = $("#pid").val();
        var name = $("#e_name").val();
        var email = $("#e_email").val();
        var dob = $("#e_dob").val();
        var age = $('#e_age').val();
        var gender = $('#e_gender').val();
        var course = $('#e_course').val();
        var address = $('#e_address').val();

        var data = "id=" + id + "&name=" + name + "&email=" + email + "&dob=" + dob + "&age=" + age + "&gender=" + gender + "&course=" + course + "&address=" + address; //+street+appartment+city+zip;

  
        $.ajax({
            method: "post",
            url: "edit.php",
            data: data,
            success: function (data) {
                if (data) {
                    alert("Updation Success");
                    window.location.href = "http://localhost/work/task/task9/user.php";
                  
                }
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