<!DOCTYPE html>
<html>

<head>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
    }
    </style>

    <title>FRAME Assessment 3</title>
    <script src="<?php echo APPLICATION_URL.'resources/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo APPLICATION_URL.'resources/js/task/scripts.js'; ?>"></script>
    <script type="text/javascript">
    var mtsoc_vars = {
        'base_url': '<?php echo APPLICATION_URL; ?>',
        'application': '<?php echo $request['application']; ?>'
    }
    </script>
</head>

<body>
    <div>
        <h2>USER APPLICATION</h2>
        <h5>ADD SECTION</h5>

        <label>Your Email</label>
        <input type="email" name="email" autocomplete="off" required>

        <label>User Name</label>
        <input type="text" name="name" autocomplete="off" required>

        <label>Password</label>
        <input type="password" name="password" autocomplete="off" required>

        <button name="submit" id="m_add">SUBMIT</button>
        <br>
        <br>
    </div>
    <div>

        <h5><label>GET ALL SECTION:</label></h5>

        <input type="text" name="getAll" value="GetAll" default='GETALL' readonly>
        <button type="submit" name="getAll" id="m_getAll" value="GETALL">GET ALL</button>
        <div id="m_table"></div>
        <br>
        <br>



    </div>
    <div>
        <h5><label>EDIT SECTION:</label></h5>

        <label>Enter Your Email:</label>
        <input type="email" name="edit_email" autocomplete="off" required>
        <?php echo $errors['edit_email']; ?>
        <label>Enter Your Password</label>
        <input type="password" name="edit_o_password" autocomplete="off" required>
        <?php echo $errors['edit_password']; ?>
        <br>
        <br>
        <label>New User Name</label>
        <input type="text" name="new_username" autocomplete="off" required>

        <label>New Email</label>
        <input type="email" name="new_email" autocomplete="off" required>

        <label>New Password </label>
        <input type="password" name="new_password" autocomplete="off" required>
        <br>
        <br>

        <button type="submit" name="edit" id="m_edit" value="EDIT">EDIT</button>
        <br>
        <br>



    </div>
    <div>
        <h5><label>DELETE SECTION:</label></h5>


        <label>Enter the Email to Delete:</label>
        <input type="email" name="email_to_delete" autocomplete="off" required>
        <button type="submit" id="m_delete" name="delete" value="DELETE">DELETE</button>
    </div>
    <div>

        <h5><label>GET BY PARTICULAR ID SECTION:</label></h5>

        <label>Enter id to retrive:</label>
        <input type="text" name="id_to_get" autocomplete="off" required>
        <button type="submit" id="m_getById" name="getById" value="GET BY ID">GET BY ID</button>
        <br>
        <br>
        <div>
            <label>Email:<p id="e_email"></p></label>
            <label>Created Date:<p id="e_date"></p></label>
            <label>Name:<p id="e_name"></p></label>
        </div>
    </div>

</body>

</html>