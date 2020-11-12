$(document).ready(function () {
    $("#deleting").click(function () {

        var id = $("#pid").val();
        

        var data = "id=" + id;


        $.ajax({
            method: "post",
            url: "delete.php",
            data: data,
            success: function (data) {
                if (data) {
                   alert("Deleted Successfully");
                    window.location.href = "http://localhost/work/task/task9/user.php";
                  
                }
            }
        });
        
    });



});