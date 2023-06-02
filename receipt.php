<?php 
    session_start();
    include("./tmp/header.php");
    // $url = "index.php";
    // header("Refresh: 1; url = $url");

    if(!$_SESSION){
        header("location: login.php");
    }
    
    echo "<script> alert('Money sent successfully') </script>";
?>

    <div class="done">
        <h3>Done</h3>
    </div>

    <div class="reciept">
        <div class="img">
            <img src="./img//images.png" alt="">
        </div>
        <div class="head">
            <h2>Transaction Successful !!</h2>
        </div>

        <div class="body">

            <div class="pack">
                <h5>Transfered to</h5>
                <span><?php echo $_SESSION["RecipientAcctNum"] ."   " . $_SESSION["RecipientName"]?> </span>
            </div>

            <div class="pack">
                <h5>Transfered from</h5>
                <span><?php echo $_SESSION["acctNum"] . "   " .$_SESSION["name"] ?></span>
            </div>

            <div class="pack">
                <h5>Amount Transfered</h5>
                <span><?php echo "₦" . number_format($_SESSION["amount"])  ?>.00</span>
            </div>

            <div class="pack">
                <h5>Remark</h5>
                <span><?php echo $_SESSION["remark"] ?? "None"  ?></span>
            </div>

            <div class="pack">
                <h5>Date</h5>
                <span>date now</span>
            </div>

            <div class="btns">
                <a href="TX.php" class="sendbtn">Check Transactions</a>
                <a href="index.php" class="goHome">Go Home</a>
            </div>


        </div>
    </div>



<?php 
    include("./tmp/footer.php");
?>