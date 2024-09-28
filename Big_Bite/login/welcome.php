<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* body{ font: 14px sans-serif; text-align: center; } */

        
        /* body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; } */

        body {
            margin:130px;
            text-align: center;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url(background1.jpg) no-repeat;
            background-size: cover;
            background-position: center;
            color: #fff;
            
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
      <a href="../index.html">Home</a>
      <!-- <a href="../about.html">About</a>
      <a href="s../ervices.html">Services</a>
      <a href="../contact.html">Contact</a> -->
      <a href="logout.php" class="btn btn-danger ml-3">Log-out</a>
      <!-- <button class="btnLogin-popup">Login</button> -->
    </nav>
  </header>


  <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <!-- <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a> -->
    </p>

</body>
</html>