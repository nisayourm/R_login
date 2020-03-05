
<?php
 $con = new mysqli('localhost', 'root', '', 'login');
 $errors = array(
     'email' => '',  
     'password' => '', 
     'class'=>'',
 );

 session_start();
 
 // Storing session data
 $_SESSION["name"] = "Peter";
 

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if(empty($email)){
        $errors['email'] = "Email Correct!";

    }else{
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email Correct!";
          
    
        }
    }
    //password of login
    if(empty($password)){
        $errors['password'] = "Password required";
        $errors['class'] = "text-danger";
    }
    
     if(!array_filter($errors)){
        $sql = "SELECT id,password FROM user WHERE email = '$email'";
        $con->query($sql);
        
    //excute row
    $query = $con->query($sql);
    //it to check the data from table if it have it will select it to display 
    if($query->num_rows >0){
        //get the password from databast
        $data = $query->fetch_array();
        //echo $data['password'];
        //use if for compart password in put to compat width databast
        if(password_verify($password,$data['password'])){
           $_SESSION['email'] = $email;
            header('location: welcome.php');
        } else {
            $errors['password'] = $errors['email'] = "password and Email not found";
        }
        }else{
            $errors['email'] = "Email not correct!";
        }

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
                    <div class="card-header">Login Now!</div>
                    <div class="card-body">
                         <form action ="#" method="POST">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                <small class="form-text text-danger  <?php echo  $errors['class'];?>"></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" id="password">
                                <small class="form-text text-danger  <?php echo  $errors['class'];?>"></small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="login">Login Now</button>
                            <a href="index.php" class="btn btn-success btn-block">Register Now</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</body>
</html>