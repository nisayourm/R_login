<?php
    $con = new mysqli('localhost', 'root', '', 'login');
    $errors = array(
        'email' => '', 
        'name' => '', 
        'password' => '', 
        'cpassword' => '',
        'class'=>'',
    );

    if(isset($_POST['login'])) {
        
        $name = $con->real_escape_string($_POST['name']);
        $email = $con->real_escape_string($_POST['email']);
        $password = $con->real_escape_string($_POST['password']);
        $cpassword = $con->real_escape_string( $_POST['cpassword']);
        


        if(empty($email)) { 
            $errors['email'] = "Email required";
            $errors['class'] = "text-danger";

            
        }else {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email not validate";
                $errors['class'] = "text-danger";
                
            }
        }
        if(empty($name)) {
            $errors['name'] = "Name required";
            $errors['class'] = "text-danger";
           
        }else {
            if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
                $errors['name'] = 'Name must be letters and spaces only';
               
			}
        }

        if(empty($password)) {
            $errors['password'] = "Password required";
            $errors['password'] = "text-danger";
           
        }

        if(empty($cpassword)) {
            $errors['cpassword'] = "Confirm Password required";
            $errors['cpassword'] = "text-danger";
            
        }

        if($password != $cpassword) {
            $errors['password'] = "Password doesn't match with confirm password";
            $errors['cpassword'] = "Confirm Password not the same previus password";
           
        }


        if(!array_filter($errors)){
           
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO user (name,email,password) VALUES('$name', '$email','$hash')";
            $con->query($sql);

            $errors['name'] = "Name Correct!";
            $errors['email'] = "Email Correct!";
            $errors['password'] = "Password Correct!";
            $errors['cpassword'] = "Confirm Password Correct!";
            $errors['class'] = "text-success";

        
        }
       

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">Register Now!</div>
                    <div class="card-body">
                         <form action ="index.php" method="POST">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                                <small class="form-text <?php echo  $errors['class'];?>"><?php echo $errors['name']; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                <small class="form-text <?php echo  $errors['class'];?>" ><?php echo $errors['email']; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" id="password">
                                <small class="form-text <?php echo  $errors['class'];?>"><?php echo $errors['password']; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" id="cpassword">
                                <small class="form-text <?php echo  $errors['class'];?>"><?php echo $errors['cpassword']; ?></small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="login">Register</button>
                            <a href="login.php" class="btn btn-success btn-block">Existing Account</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</body>
</html>