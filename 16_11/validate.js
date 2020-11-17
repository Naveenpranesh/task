
function validateForm() {

    var name = document.getElementById("name").value;

    var score = document.getElementById("score").value;


    if (name == "") {
        alert("Name must be filled out");
        return false;
    }
    if (score == "") {
        alert("Score must be filled out");
        return false;
    }  


}

