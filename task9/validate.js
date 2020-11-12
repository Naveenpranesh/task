function validateForm() {

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var date = document.getElementById("date").value;
    var age = document.getElementById("age").value;

    
    var gender = document.getElementById("gender").value;
    var course = document.getElementById("course").value;
    var street = document.getElementById("street").value;
    var appartment = document.getElementById("appartment").value;

    var city = document.getElementById("city").value;
    var state = document.getElementById("state").value;
    var zip = document.getElementById("zip").value;

    if (name == "") {
        alert("Name must be filled out");
        return false;
    }

    if (email == "") {
        alert("Email must be filled out");
        return false;
    }

    if (date == "") {
        alert("DOB must be filled out");
        return false;
    }

    if (age == "") {
        alert("Age must be filled out");
        return false;
    }

    if (gender == "") {
        alert("Gender must be filled out");
        return false;
    }

    if (course == "") {
        alert("Course must be filled out");
        return false;
    }
    if (street == "") {
        alert("Street must be filled out");
        return false;
    }
    if (appartment == "") {
        alert("Appartment must be filled out");
        return false;
    }
    if (city == "") {
        alert("City must be filled out");
        return false;
    }
    if (state == "") {
        alert("state must be filled out");
        return false;
    }
    if (zip == "") {
        alert("state must be filled out");
        return false;
    }


}
function edit(){
    var name = document.getElementById("e_name").value;
    var email = document.getElementById("e_email").value;
    var date = document.getElementById("e_dob").value;
    var age = document.getElementById("e_age").value;
    var id = document.getElementById("pid").value;
    
    var gender = document.getElementById("e_gender").value;
    var course = document.getElementById("e_course").value;
   
    var address = document.getElementById("e_address").value;

  


    if (id == "") {
        alert("Id must be filled out");
        return false;
    }
    
    if (name == "") {
        alert("Name must be filled out");
        return false;
    }

   

    if (email == "") {
        alert("Email must be filled out");
        return false;
    }

    if (date == "") {
        alert("DOB must be filled out");
        return false;
    }

    if (age == "") {
        alert("Age must be filled out");
        return false;
    }

    if (gender == "") {
        alert("Gender must be filled out");
        return false;
    }

    if (course == "") {
        alert("Course must be filled out");
        return false;
    }
    if (address == "") {
        alert("Address must be filled out");
        return false;
    }



}
