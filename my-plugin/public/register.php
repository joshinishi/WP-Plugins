<?php
    if(isset($_POST['register'])){
        global $wpdb;
        $fname = $wpdb->escape($_POST['name']);
        
    }
?>

<form action="<?php echo get_the_permalink();?>" method="post">
    First Name: <input type="text" name="name" id="name"></br>

    Last Name: <input type="text" name="lastname" id="lastname"></br>

    User Name: <input type="text" name="username" id="username"></br>

    Password: <input type="password" name="password" id="password"></br>

    Confirm Password: <input type="password" name="password" id="password"></br>

    <input type="submit" class="button" name="register" value="Register">
</form>
