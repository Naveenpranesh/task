<div tabindex="-1" class="modal bs-example-modal-sm" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Logout <i class="fa fa-lock"></i></h4>
                </div>
                <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
                <div class="modal-footer"><a  href="<?php echo APPLICATION_URL.'gateway/action?application=task&action=login_form' ?>"><button class="btn btn-primary btn-block" id="main-logout">Logout</button></a></div>
            </div>
        </div>
    </div>
<!-- USER INSERT -->
<div class="text-center ">
    <div class="form-group md-4">
        <img class="mb-4" src="<?php echo APPLICATION_URL.'resources/images/task/logo.jpg'; ?>" alt="" width="72"
            height="72" />
        <h1 class="h3 mb-3 font-weight-normal">User Registration</h1>
        <p>Please fill out the form</p>
    </div>
    <div>
        <div id="displaymsg" style="color:red;padding-top:25px;"></div>
    </div>
</div>

<div id='form1' class="form-group col-md-4  col-md-offset-4">

    <div>
        <label for="name">User Name</label>
        <input type="text" class="form-control" placeholder="Naveen Kumar" name="name" id="name">
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" class="form-control" placeholder="naveen@gmail.com" name="email" id="email">
    </div>
    <div>
        <label for="inputState">DOB</label>

        <input type="date" class="form-control" placeholder="28/04/1999" name="dob" id="dob">
    </div>
    <div>
        <label for="inputAge">Age</label>
        <input type="Number" class="form-control" name="age" placeholder="18" id="age">
    </div>
    <div>

        <label for="gender">Gender</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender" value="male">
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
    <div>
        <label for="inputCourse">Courses</label>
        <select class="form-control" name="course" id="course" value=''>
            <option selected>Choose...</option>
            <option name="course" id="course" value='php'>PHP</option>
            <option name="course" id="course" value='angular'>Angular</option>
            <option name="course" id="course" value='java script'>Java Script</option>
            <option name="course" id="course" value='java'>Java</option>
            <option name="course" id="course" value="pearl">Pearl</option>
        </select>
    </div>
    <div>
        <label for="inputAddress">Street</label>
        <input type="text" class="form-control" name="street" id="street" placeholder="1234 Main St">
    </div>
    <div>
        <label for="inputAddress2">Appartment</label>
        <input type="text" class="form-control" name="appartment" id="appartment"
            placeholder="Apartment, studio, or floor">
    </div>
    <div>
        <label for="inputCity">City</label>
        <input type="text" class="form-control" placeholder="Bangalore,Chennai,Hyderabad..." name="city" id="city">
    </div>
    <div>
        <label for="inputState">State</label>
        <select id="state" name="state" value='' class="form-control">
            <option selected>Choose...</option>
            <option id="state" name="state" value="tamil nadu">Tamil Nadu</option>
            <option id="state" name="state" value="Uttra Pradesh">Uttra Pradesh</option>
            <option id="state" name="state" value="Hyderabad">Hyderabad</option>
            <option id="state" name="state" value="Karnataka">Karnataka</option>
            <option id="state" name="state" value="Delhi">Delhi</option>
        </select>
    </div>
    <div>
        <label for="zip">Zip</label>
        <input type="text" name="zip" placeholder="638104" class="form-control" id="zip">
    </div>



    <div class="form-group col-md-4  col-md-offset-4 align-self-center">
        <br>
        <button class="btn btn-lg btn-danger btn-block" id='reset' name='reset' type="reset">Reset</button>
        <button class="btn btn-lg btn-success btn-block" id="register" name="register">Submit</button>
        <button class="btn btn-lg btn-primary btn-block get_All" id="get_All" name="register">Show All</button>
        <div calss='text-center' id="displaymsg1" style="color:red;padding-top:10px;"></div>
    </div>


</div>
<!-- TABLE DIV -->
<div id='displaytable'>
   
</div>

<!-- EDIT SECTION -->
<div id="editing-section" class="form-group col-md-4  col-md-offset-4 edit-section">
    <div class="text-center ">
        <p>Make Neccessary Changes</p>
    </div>
    <div>
        <div id="errordisplay" style="color:red;padding-top:25px;"></div>
    </div>
    <div>
        <label for="pid">ID</label>
        <input type="number" class="form-control" name="pid" id="selected-pid" value='' disabled>
    </div>



    <div>
        <label for="name">User Name</label>
        <input type="text" class="form-control" id="selected-name" value="" name="name">
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" class="form-control" id="selected-email" value="" name="selected-email">
    </div>
    <div>
        <label for="dob">DOB</label>

        <input type="date" class="form-control" id="selected-dob" value="" name="dob">
    </div>
    <div>
        <label for="inputAge">Age</label>
        <input type="Number" class="form-control" id="selected-age" name="age" value="">
    </div>
    <div>

        <label for="Gender">Gender</label>
        <div>
            <input type="text" class="form-control" id='selected-gender' value='' disabled>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="selected-gender" id="selected-gender" value="male">
            <label class="form-check-label" for="gender">
                Male
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="selected-gender" id="selected-gender" value="female">
            <label class="form-check-label" for="gender">
                Fe-Male
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="selected-gender" id="selected-gender" value="other">
            <label class="form-check-label" for="gender">
                Not Preffered
            </label>
        </div>
    </div>
    <div>
        <label for="inputCourse">Courses</label>
        <div>

            <input type="text" class="form-control" id='selected-course' value='' disabled>
        </div>
        <br>
        <select class="form-control" name="selected-course" id="selected-course" value=''>
            <option selected>Choose...</option>
            <option name="selected-course" id="selected-course" value='php'>PHP</option>
            <option name="selected-course" id="selected-course" value='angular'>Angular</option>
            <option name="selected-course" id="selected-course" value='java script'>Java Script</option>
            <option name="selected-course" id="selected-course" value='java'>Java</option>
            <option name="selected-course" id="selected-course" value="pearl">Pearl</option>
        </select>
    </div>
    <div>
        <br>
        <label for="inputAddress"><Address></Address></label>
        <input type="text" class="form-control" name="selected-address" value='' id="selected-address"
            placeholder="1234 Main St">
    </div>

    <div class="form-group col-md-4  col-md-offset-4 align-self-center">
        <br>
        <button class="btn btn-lg btn-success btn-block" id="user_update" name="user_update">Update</button>
        <div calss='text-center' id="editdisplaymsg" style="color:red;padding-top:10px;"></div>
    </div>


</div>


<!-- FOOTER SECTION -->
<div class="form-group col-md-4  col-md-offset-4">
   