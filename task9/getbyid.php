<?php 
error_reporting(0);
	if(isset($_GET['id']) && !empty($_GET['id']))
	{
			include 'connect.php';
			$idr=$_GET['id'];
			$sql5= "SELECT * FROM user WHERE id='$idr'";
			$result = mysqli_query($conn,$sql5);
			while ($row = mysqli_fetch_assoc($result))
			{
				$id=$row['id'];
				$name= $row['name'];
				$email= $row['email'];
				$gender= $row['gender'];
                $address=$row['address'];
                $age=$row['age'];
                $dob=$row['dob'];
                $course=$row['course'];
               
			}
	}
	else
	{
        $id='';
        $name= '';
        $email= '';
        $gender= '';
        $address='';
        $age='';
        $dob='';
        $course='';
	}
		
	
    ?>


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


    <div id="editform" class="form-signin">

  
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

        <div class="text-center mb-4">
            <img class="mb-4" src="img/logo.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">EDIT SECTION</h1>
            <p>Please fill out the form</p>


        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="name">ID</label>
                <input type="number" class="form-control" placeholder="01234..." name="pid" id="pid"
                    value='<?php echo $id; ?>' disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">User Name</label>
                <input type="text" class="form-control" placeholder="Naveen Kumar" name="e_name" id="e_name"
                    value='<?php echo $name; ?>'>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="naveen@gmail.com" name="e_email" id="e_email"
                    value='<?php echo $email; ?>'>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="inputState">DOB</label>

                <input type="date" class="form-control" placeholder="28/04/1999" name="e_dob" id="e_dob"
                    value='<?php echo $dob; ?>'>
            </div>

            <div class="form-group col-md-6">
                <label for="inputAge">Age</label>
                <input type="Number" class="form-control" name="e_age" placeholder="18" id="e_age"
                    value='<?php echo $age; ?>'>
            </div>

        </div>
        <div class="form-group">
            <label for="Gender">Gender</label>
            <div class="form-group col-md-6">

                <input type="text" class="form-control" value='<?php echo $gender; ?>' disabled>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="e_gender" id="e_gender" value="male">
                <label class="form-check-label" for="gender">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="e_gender" id="e_gender" value="female">
                <label class="form-check-label" for="gender">
                    Fe-Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="e_gender" id="e_gender" value="other">
                <label class="form-check-label" for="gender">
                    Not Preffered
                </label>
            </div>
        </div>


        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="state">Courses</label>
                <select class="form-control" name='e_course' id="e_course" value=''>
                    <option selected><?php echo $course; ?></option>
                    <option value='php'>PHP</option>
                    <option value='angular'>Angular</option>
                    <option value='java script'>Java Script</option>
                    <option value='java'>Java</option>
                    <option value="pearl">Pearl</option>
                </select>
            </div>

        </div>

        <div class="form-group">
            <label for="e_address">Address</label>
            <input type="text" class="form-control" name="e_address" id="e_address" placeholder="1234 Main St"
                value='<?php echo $address; ?>'>
        </div>


        <div class="form-row container">
            <div class="form-group col align-self-center">

                <button class="btn btn-lg btn-primary btn-block" id="editing" name="editing"
                    onclick="return edit()">UPDATE</button>

            </div>
        </div>



    </div>



</body>

</html>