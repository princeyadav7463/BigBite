<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }

        body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: url(background1.jpg) no-repeat;
  background-size: cover;
  background-position: center;

}

        .wrapper {
  position: relative;
  width: 400px;
  height: 440px;
  margin: auto;
  margin-top: 120px;
  background: transparent;
  border: 2px solid rgba(255, 255, 255, .5);
  border-radius: 20px;
  backdrop-filter: blur(20px);
  box-shadow: 0 0 30px rgba(0, 0, 0, .5);
  /* display: flex; */
  justify-content: center;
  align-items: center;
  overflow: hidden;
  /* transform: scale(0); */
  transition: transform .5s ease, height .2s ease;
}

        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  padding: 20px 100px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 99;
  /* background: red; */
}

.Registration{
  font-size: 2em;
  color: #fff;
  user-select: none;
}

.navigation a {
  position: relative;
  font-size: 1.1em;
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  margin-left: 20px;
}

.navigation a::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 100%;
  height: 3px;
  background: #fff;
  border-radius: 5px;
  transform-origin: right;
  transform: scaleX(0);
  transition: transform .5s;
}

.navigation a:hover:after {
  transform-origin: left;
  transform: scaleX(1);
}

.navigation .btnLogin-popup {
  width: 130px;
  height: 50px;
  background: transparent;
  border: 2px solid #fff;
  outline: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1.1em;
  color: #fff;
  font-weight: 500;
  margin-left: 40px;
  transform: .5s;
}

.navigation .btnLogin-popup:hover {
  background: #fff;
  color: #162938;

}
    
    </style>
</head>
<body>

<header>
    <h2 class="Registration">Registration-Form</h2>
    <nav class="navigation">
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Services</a>
      <a href="#">Contact</a>
      <!-- <button class="btnLogin-popup">Login</button> -->
    </nav>
  </header>


    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>