<?php 

    session_start();
    if(!$_SESSION){
        header("location: login.php");
    }

    include("./tmp/header.php")

?>



<div class="userProfile">
    <div class="top">
        <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <span>Personal Data</span>
    </div>
    
    <div class="head"></div>

    <div class="body">
        <label for="">Name</label>
        <input type="text" readonly value="<?php echo strtoupper( $_SESSION["name"]) ?>">

        <label for="">Email</label>
        <input type="email" readonly value="<?php echo strtoupper($_SESSION["email"]) ?>">

        <label for="">Account Number</label>
        <input type="num" readonly value="<?php echo $_SESSION["acctNum"] ?>">

        <label for="">Phone Number</label>
        <input type="num" readonly value="<?php echo $_SESSION["phone"] ?>">
        
        <label for="">Date of birth</label>
        <input type="text" readonly value="<?php echo $_SESSION["dob"] ?>">
    </div> 

    <div class="footer">
        <p>Deactivate your account</p>
        <span>Visit the bank to update your information.</span>
    </div>
</div>








<?php 
    include("./tmp/footer.php");
?>