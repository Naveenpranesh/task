<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>User Registration Form</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>
    <script src="register.js"></script>
    <script src="validate.js"></script>
    <script src="edit.js"></script>
    <script src="delete.js"></script>
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>

    <link href="floating-labels.css" rel="stylesheet">
</head>

<body>


    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

        <button class="btn btn-primary" data-target=".bs-example-modal-sm" data-toggle="modal">Logout</button>

    </nav>

   

<div tabindex="-1" class="modal bs-example-modal-sm" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
      <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
      <div class="modal-footer"><a class="btn btn-primary btn-block" href="logout.php">Logout</a></div>
    </div>
  </div>
</div>



    <div id="myForm" class="form-signin">

        <div class="text-center mb-4">
            <img class="mb-4" src="img/logo.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">User Registration</h1>
            <p>Please fill out the form</p>
            <p>
            <div id="register_output"></div>
            </p>

        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">User Name</label>
                <input type="text" class="form-control" placeholder="Naveen Kumar" name="name" id="name">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="naveen@gmail.com" name="email" id="email">
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="inputState">DOB</label>

                <input type="date" class="form-control" placeholder="28/04/1999" name="dob" id="date">
            </div>

            <div class="form-group col-md-6">
                <label for="inputAge">Age</label>
                <input type="Number" class="form-control" name="age" placeholder="18" id="age">
            </div>

        </div>
        <div class="form-group">
            <label for="inputAddress">Gender</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked>
                <label class="form-check-label" for="gender">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                <label class="form-check-label" for="gender">
                    Fe-Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="other">
                <label class="form-check-label" for="gender">
                    Not Preffered
                </label>
            </div>
        </div>


        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="state">Courses</label>
                <select class="form-control" name='course' id="course" value=''>
                    <option selected>Choose...</option>
                    <option value='php'>PHP</option>
                    <option value='angular'>Angular</option>
                    <option value='java script'>Java Script</option>
                    <option value='java'>Java</option>
                    <option value="pearl">Pearl</option>
                </select>
            </div>

        </div>

        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" class="form-control" name="street" id="street" placeholder="1234 Main St">
        </div>
        <div class="form-group">
            <label for="inputAddress2">Address 2</label>
            <input type="text" class="form-control" name="appartment" id="appartment"
                placeholder="Apartment, studio, or floor">
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" name="city" id="city">
            </div>
            <div class="form-group col-md-4">
                <label for="state">State</label>
                <select id="state" name="state" class="form-control">
                    <option selected>Choose...</option>
                    <option value="tamil nadu">Tamil Nadu</option>
                    <option value="Uttra Pradesh">Uttra Pradesh</option>
                    <option value="Hyderabad">Hyderabad</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Delhi">Delhi</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="zip">Zip</label>
                <input type="text" name="zip" class="form-control" id="zip">
            </div>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="terms"> I agree to the <a href="#">terms and conditions</a>
            </label>
        </div>
        <div class="form-row container">
            <div class="form-group col align-self-center">
                <button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button>
                <button class="btn btn-lg btn-danger btn-block" id="submit" name="submit"
                    onclick="return validateForm()">Submit</button>

            </div>
        </div>
    </div>


    <div class="form-signin">
        <p class="mx-auto align-middle" style="width: 200px;" id="getAll_output"> </p>
    </div>


</body>

</html>