var x = 0;
var array = {};

$(document).ready(function () {
    $("#add_to_array").click(function () {

        var name = $("#name").val();
        var score = $("#score").val();

        var array_index = $("#array_index").val();


        var data = "name=" + name + "&score=" + score + "&score=" + score + "&array_index=" + array_index;

        $.ajax({
            method: "post",
            url: "add.php",
            data: data,
            success: function (data) {

                $("#register_output").html(data);
            }

        });
        if (name != '' && score != '') {
            array[name] = score;
            alert("Element: " + array[name] + " Added at index " + name);
            $("#name").val("");
            $("#score").val("");
        }

        if ($("#array_index").val() < 4) {
            $("#array_index").val(Number($("#array_index").val()) + 1);


        } else {
            $("#array_index").val(0);
        }

        if (array_index >= 4) {
            $('#result').show();
            $('#b_score').show();
            $('#db_result').show();
            $('#db_score').show();
        } else {

            $('#result').hide();
            $('#b_score').hide();
            $('#dresult').hide();
            $('#db_score').hide();

        }

    });

    $("#result").click(function () {
        var e = "<table><tr><th>Name</th><th>Score</th><tbody>";

        $.each(array, function (element, index) {

            e += "<tr><td> " + element + "</td>" + "<td>" + index + "</td></tr>";
        })
        e += '</tbody></table>';
        $("#results").html(e);

    })


    $("#b_score").click(function () {
        var e = "<p>High Score:</p>";

        var max = 0;

        var arr = Object.values(array);

        var max = Math.max(...arr);
        var key = Object.keys(array).reduce(function (a, b) {
            return array[a] > array[b] ? a : b
        });
        var sum = arr.reduce((pv, cv) => {
            return pv + (parseFloat(cv) || 0);
        }, 0);

        e += "<p>" + key + ' with a score of ' + max + '</p>';
        e += "<p>Avereage Score: </p>";
        e += "<p>" + sum / 5 + '</p>';
        $("#score_output").html(e);
    })


    $("#db_result").click(function () {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("db_register_output").innerHTML = this.responseText;
            }
          };
       
        xmlhttp.open("GET","display.php?q",true);
        xmlhttp.send();

    })



    $("#db_score").click(function () {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("db_score_output").innerHTML = this.responseText;
            }
          };
       
        xmlhttp.open("GET","score.php?q",true);
        xmlhttp.send();
    })




});