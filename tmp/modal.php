<?php 

    session_start();

    include("./tmp/connection.php");

    if(isset($_POST["submit"])){
      $acctNum = $_POST["acct"];
      $amount = $_POST["amount"];
      $remark = $_POST["remark"];

      $sqlAcctNum = "SELECT * FROM bankusers WHERE account_number = '$acctNum'";
      $fetch = mysqli_query($conn,$sqlAcctNum);
      $info = mysqli_fetch_assoc($fetch);

      if($info){
        $recipientBal = $info["account balance"];
        $senderAcctNum = $_SESSION["acctNum"];
        $senderBal = $_SESSION["balance"];

        if($amount > $senderBal ){
          $notFound = "Insufficient balance";
        }elseif($amount < 5){
          $notFound = "Transfer mininum of ₦5";
        }elseif($acctNum == $senderAcctNum){
          $notFound = "Can't tranfer to  self account";
        }else{
          // add to the recipient acct balance
          $sqlAdd = "UPDATE `bankusers` SET `account balance` = '$recipientBal' + '$amount' WHERE account_number = '$acctNum'  ";
          $result = mysqli_query($conn,$sqlAdd);

          // Get the sender balance
          $sqlAcctNum = "SELECT * FROM bankusers WHERE account_number = '$senderAcctNum'";
          $fetch = mysqli_query($conn,$sqlAcctNum);
          $getbal = mysqli_fetch_assoc($fetch);
          $senderBal = $getbal["account balance"];

          // deduct from the sender acct balance
          $sqlDeduct = "UPDATE `bankusers` SET `account balance` = '$senderBal' - '$amount' WHERE account_number = '$senderAcctNum'  ";
          $result = mysqli_query($conn,$sqlDeduct);
          
          // expenses increment
          $expenses = $_SESSION["total_expenses"];
          $sqlExpenses = "UPDATE `bankusers` SET `total_expenses` = '$expenses'  + '$amount' WHERE account_number = '$senderAcctNum'  ";
          $result = mysqli_query($conn,$sqlExpenses);

          // income increment
          $income = $info["total_income"];
          $sqlIncome = "UPDATE `bankusers` SET `total_income` = '$income'  + '$amount' WHERE account_number = '$acctNum'  ";
          $result = mysqli_query($conn,$sqlIncome);

          if($result){
            $RecipientAcctNum = $info["account_number"];
            $RecipientEmail = $info["email"];
            $RecipientName = $info["firstname"]. " - " .$info["lastname"];
            $RecipientPhone = $info["phone_number"];

            // balance of the sender updated
            $_SESSION["balance"] = $getbal["account balance"];

            // trasactions details
            $sqlTX = "INSERT INTO transactions(`transfer_to`, `transfer_from`, `amount`, `remark`) 
            VALUES('$RecipientAcctNum','$senderAcctNum','$amount','$remark')";
            mysqli_query($conn , $sqlTX);

            // save transaction data in sessions
            $_SESSION["amount"] = $amount;
            $_SESSION["RecipientAcctNum"] = $RecipientAcctNum;
            $_SESSION["RecipientEmail"] = $RecipientEmail;
            $_SESSION["RecipientName"] = $RecipientName;
            $_SESSION["RecipientPhone"] = $RecipientPhone;
            $_SESSION["remark"] = $remark;
            
            header("location: receipt.php");

          }else{
            echo "error" . mysqli_error($conn);
          }

        }

      }else{
        $notFound = "Account not found (" . $acctNum .")" ;
      }
    }


?>


<!-- Send money Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Send money to someone</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="index.php" method="post">

        <label for="">Account Number</label>
        <input type="num" name="acct" id="acctNumb" placeholder="Enter Account 9 digits number">

        <label for="">Amount ₦</label>
        <input type="num" class="amt" name="amount" id="" placeholder="Amount in number">

        <label for="">Remark</label>
        <input type="text" name="remark" id="" placeholder="Remark for this transaction">

        <button name="submit" class="submit" id="send">Send</button>

        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- deposit money modal -->
<div class="modal fade" id="deposit">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Deposit into your account</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p>Send money to this account number. <br><br>
            
         <strong><?php echo "Name : " . strtoupper($_SESSION["name"]) ." <br><br>Account Number : ". $_SESSION["acctNum"]?></strong>
        </p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>




<!-- withdraw money Modal -->
<div class="modal fade" id="withdraw">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Withdraw to another account</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="index.php" method="post">

          <label for="">Account Number</label>
          <input type="num" name="acct" id="acctNumb" placeholder="Enter Account 9 digits number">

          <label for="">Amount ₦</label>
          <input type="num" class="amt" name="amount" id="" placeholder="Amount in number">

          <label for="">Remark</label>
          <input type="text" name="remark" id="" placeholder="Remark for this transaction">

          <button name="submit" class="submit" id="send">Send</button>

        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>




<script>
  // stop form resubmission
  if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href);
  }
</script>