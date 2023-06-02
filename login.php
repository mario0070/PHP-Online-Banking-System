<?php 
    include("./tmp/header.php");
    include("./tmp/footer.php");
    include("./tmp/connection.php");

    
    session_start();
    if(isset($_SESSION["name"])){
        header("location: index.php");
    }
    // set input to empty string
    $email = $pass1 =  "";
    
    // an array of error msg
    $error = ["email" => "", "","pass1" => ""];

    // if the form is submitted
    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $pass1 = $_POST["pass1"];

        // validate the form input

        // check if a User EMail Exist
        $sqlGetEmail = "SELECT * FROM bankusers WHERE email ='$email' and password = '$pass1'";
        $fetch = mysqli_query($conn,$sqlGetEmail);
        $info = mysqli_fetch_assoc($fetch);
        if(mysqli_num_rows($fetch)){
            $_SESSION["fname"] = $info["firstname"];
            $_SESSION["name"] = $info["firstname"] ." - ". $info["lastname"] ;
            $_SESSION["balance"] = $info["account balance"] ;
            $_SESSION["acctNum"] = $info["account_number"] ;
            $_SESSION["email"] = $info["email"] ;
            $_SESSION["phone"] = $info["phone_number"] ;
            $_SESSION["dob"] = $info["dob"] ;
            $_SESSION["total_income"] = $info["total_income"] ;
            $_SESSION["total_expenses"] = $info["total_expenses"] ;
        }else{
            $error["email"] = "Credential is incorrect";
            $error["pass1"] = "Password is Incorrect";
        }

         // check if there is an error
        if(array_filter($error)){
            // do nothing
        }else{
            header("location: index.php"); 
        }
        
        

    }
  


?>

<div class="reg-form">
    <h2>Login Account</h2>
    <p>Don't have an account ? <a href="register.php">Register</a></p>
    <form action="login.php" method="post">

        <label for="">Email Address</label>
        <input type="email" name="email" id="" placeholder="Enter your email address" value="<?php echo $email ?>">
        <span><?php echo $error["email"] ?></span>

        <label for="">Password</label>
        <input type="password" name="pass1" id="" placeholder="******">
        <span><?php echo $error["pass1"] ?></span>

        <button name="submit">Login</button>

    </form>
</div>