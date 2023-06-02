<?php 
    include("./tmp/header.php");
    include("./tmp/footer.php");
    include("./tmp/connection.php");

    session_start();
    if(isset($_SESSION["name"])){
        header("location: index.php");
    }

    // generate acct number
    $acctNum = rand(200000000,299000000);

    // set input to empty string
    $fname = $lname = $email = $pass1 = $phone = $dob = $gender = $bvn = "";
    
    // an array of error msg
    $error = ["fname" => "","lname" => "","email" => "","phone" => "","bvn" => "","pass1" => "" ,"pass2" => "","","gender" => "","dob" => ""];

    // if the form is submitted
    if(isset($_POST["submit"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $bvn = $_POST["bvn"];
        $pass1 = $_POST["pass1"];
        $pass2 = $_POST["pass2"];
        $gender = $_POST["gender"];
        $dob = $_POST["dob"];

        // validate the form inputs
        if(empty($fname)){
            $error["fname"] = "First name cannot be empty";
        }

        if(empty($lname)){
            $error["lname"] = "Last name cannot be empty";
        }

        if(empty($phone)){
            $error["phone"] = "Phone number cannot be empty";
        }

        if(empty($gender)){
            $error["gender"] = "Please choose your gender";
        }

        if(empty($email)){
            $error["email"] = "Email address cannot be empty";
        }
        elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            $error["email"] = "Email address is not valid";
        }

        if(empty($fname)){
            $error["fname"] = "first name cannot be empty";
        }

        if(empty($pass1)){
            $error["pass1"] = "Password cannot be empty";
        }
        elseif($pass1 <= 5){
            $error["pass1"] = "Password length is short";
        }

        if($pass2 !== $pass1){
            $error["pass2"] = "Password did not match";
        }

        // check if a User EMail Exist
        $sqlGetEmail = "SELECT * FROM bankusers WHERE email ='$email'";
        $fetch = mysqli_query($conn,$sqlGetEmail);
        $info = mysqli_fetch_assoc($fetch);
        if(mysqli_num_rows($fetch) > 0){
            $error["email"] = "Email address already existed";
        }

        
        // check if a User Phone number Exist
        $sqlGetNum = "SELECT * FROM bankusers WHERE phone_number = '$phone'";
        $fetch = mysqli_query($conn,$sqlGetNum);
        $info = mysqli_fetch_assoc($fetch);
        if(mysqli_num_rows($fetch) > 0){
            $error["phone"] = "Phone Number already existed";
        }

        
        // check if there is an error
        if(array_filter($error)){
            // echo "error";
        }else{
            $sqlInsert = "INSERT INTO bankusers(`firstname`, `lastname`, `email`, `phone_number`, `account_number`, `bvn or nin`, `dob`, `gender`, `password`) 
            VALUES('$fname','$lname','$email','$phone','$acctNum','$bvn','$dob','$gender','$pass1')";
            $query = mysqli_query($conn,$sqlInsert);

          
            if($query){
                header("location: login.php");
            }else{
                echo "not inserted" . mysqli_error($conn);
            }
        }
        
        

    }

?>

<div class="reg-form">
    <h2>Register Today</h2>
    <p>Already have an account ? <a href="login.php">Login</a></p>
    <form action="register.php" method="post">

        <label for="">First Name</label>
        <input type="text" name="fname" id="" placeholder="First Name" value="<?php echo $fname ?>">
       <span><?php echo $error["fname"] ?></span>

        <label for="">Last Name</label>
        <input type="text" name="lname" id="" placeholder="Last Name" value="<?php echo $lname ?>">
        <span><?php echo $error["lname"] ?></span>

        <label for="">Email Address</label>
        <input type="email" name="email" id="" placeholder="Enter your email address" value="<?php echo $email ?>">
        <span><?php echo $error["email"] ?></span>

        <label for="">Phone Number</label>
        <input type="tel" name="phone" id="" placeholder="1234567890" value="<?php echo $phone ?>">
        <span><?php echo $error["phone"] ?></span>

        <label for="">BVN or NIN (optional)</label>
        <input type="num" name="bvn" id="" placeholder="Enter BVN or NIN" value="<?php echo $bvn ?>">
        <span><?php echo $error["bvn"] ?></span>

        <label for="">Password</label>
        <input type="password" name="pass1" id="" placeholder="******" >
        <span><?php echo $error["pass1"] ?></span>

        <label for="">Confirm Password</label>
        <input type="password" name="pass2" id="" placeholder="******">
        <span><?php echo $error["pass2"] ?></span>

        <label for="">Date Of Birth</label>
        <input type="date" name="dob" id="" value="<?php echo $dob ?>">
        <span></span>

        <label for="">Gender</label>
        <select name="gender" id="" value="<?php echo $gender ?>">
            <option value="">Choose one</option>
            <option value="Female">Female</option>
            <option value="Male">Male</option>
            <option value="Prefer not to say">Prefer not to say</option>
        </select>
        <span><?php echo $error["gender"] ?></span>

        <button name="submit">Register</button>

    </form>
</div>