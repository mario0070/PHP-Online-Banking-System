<?php 
    include("./tmp/modal.php");

    // check if a user is login
    if(!$_SESSION){
        header("location: login.php");
    }

    if(isset($_POST["reload"])){
        $senderBal = $_SESSION["balance"];
        $senderAcctNum = $_SESSION["acctNum"];

        // Get the sender balance and update it
        $sqlAcctNum = "SELECT * FROM bankusers WHERE account_number = '$senderAcctNum'";
        $fetch = mysqli_query($conn,$sqlAcctNum);
        $getbal = mysqli_fetch_assoc($fetch);
        $senderBal = $getbal["account balance"];
        $_SESSION["balance"] = $getbal["account balance"];
        $_SESSION["total_income"] = $getbal["total_income"];
        $_SESSION["total_expenses"] = $getbal["total_expenses"];
    }

    

    // get the sender and recipient info
    $acctNum = $_SESSION["acctNum"];
    $sql = "SELECT * FROM transactions WHERE transfer_from = '$acctNum' or transfer_to = '$acctNum' ORDER BY id DESC";
    $fetch = mysqli_query($conn,$sql);
    $result = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Banking</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/4d349a1f95.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="WhatsApp Image 2022-06-02 at 12.33.28 PM.jpeg" type="image/x-icon">
</head>
<body>


    <!-- navbar -->
    <nav>
        <div class="toggle">  
            <li onclick="toggle_sidebar()"><i class="fa fa-bars" aria-hidden="true" style="font-size: 1.8em;"></i>
            </li>
        </div>

        <div class="logo">  
            <li></li>
            <li> <img src="bank.jpeg" alt=""> MONIEBASE</li>
        </div>

        <div class="pics">  
            <li><a href="TX.php"><i class="fa fa-bell-o" aria-hidden="true" style="font-size: 1.8em;"></i></a></li>
            <li><i class="fa fa-comments" aria-hidden="true" style="font-size: 1.8em;"></i></li>
        </div>
    </nav>


    <!-- side bar -->
    <div class="sidebar" id="sidebar">

        <div class="pro-details">
            <div class="avatar">
            </div>
            <div class="name">
                <span><?php echo strtoupper($_SESSION["name"])?></span>
                <p >Acct : <?php echo $_SESSION["acctNum"]?></p>
            </div>
            <button id="btn-toggle" class="btn-close" onclick="toggle_sidebar()"></button>
        </div>

        <div class="balance">
            <span>Balance</span>
            <h4 id="balc"><?php echo "₦" . number_format($_SESSION["balance"])?>.00</h4>
            <div class="action">
                <div class="withdraw">
                    <p><i class="fa fa-arrow-down" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#withdraw"></i></p>
                    <p data-bs-toggle="modal" data-bs-target="#withdraw">withdraw</p>
                </div>
                <div class="deposit">
                    <p><i class="fa fa-plus" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#deposit"></i></p>
                    <p data-bs-toggle="modal" data-bs-target="#deposit">Deposit</p>
                </div>
                <div class="send" >
                    <p><i class="fa fa-arrow-right" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#myModal"></i></p>
                    <p data-bs-toggle="modal" data-bs-target="#myModal">Send</p>
                </div>
            </div>
        </div>

        <div class="sideAction">
            <p><i class="fa fa-paper-plane" aria-hidden="true"></i><a href="Tx.php">Transaction</a></p><hr>
            <p><i class="fa fa-user" aria-hidden="true"></i><a href="profile.php">Profile</a></p><hr>
            <p><i class="fa fa-bell-o" aria-hidden="true"></i><a href="TX.php">Notifications</a></p><hr>
            <p><i class="fa fa-phone" aria-hidden="true"></i><a href="">Message Us</a></p><hr>
            <p><i class="fa fa-credit-card-alt" aria-hidden="true"></i><a href="">Cards</a></p><hr>
            <p><i class="fa fa-sign-out logout" aria-hidden="true" ></i><a href="logout.php" class="logout">Logout</a></p><br>
        </div>

    </div>

    <div class="blank">
        <h1>blank</h1>
    </div>

    


    <!-- main page -->
    <div class="main">

        <!-- total balance -->
        
        <div class="name">
            <h5 id="randGreetings"></h5>
            <h5 class="fname"><?php echo strtoupper($_SESSION["fname"])?><i class="fa-solid fa-handshake"></i></h5>

        </div>
        <div class="totalB">
            <div class="money">
                <div class="balance">
                    <span>Total Balance <i onclick="Togglebal()" id="eye" class="fa fa-eye" aria-hidden="true"></i></span>
                    <h4 id="bal"><?php echo "₦" . number_format($_SESSION["balance"]) ?>.00</h4>
                </div>

                <div class="add">
                    <form action="index.php" method="post">
                        <button class="btn" name="reload" title="Reload the balance"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </form>
                </div>

            </div><hr>

            <div class="action">
                <div class="withdraw">
                    <p><i class="fa fa-arrow-down" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#withdraw"></i></p>
                    <p data-bs-toggle="modal" data-bs-target="#withdraw">withdraw</p>
                </div>
                <div class="deposit">
                    <p><i class="fa fa-plus" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#deposit"></i></p>
                    <p>Deposit</p>
                </div>
                <div class="send">
                    <p><i class="fa fa-arrow-right" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#myModal"></i></p>
                    <p id="se">Send</p>
                </div>
            </div>
            
        </div>

        <div class="static r" id="static">
            <h4><?php echo $notFound ?? ""?></h4>
        </div> 

        <!-- transaction history -->
        <div class="tx">
            <div class="head">
                <h5>Transactions</h5>
                <a href="TX.php">View all [ <?php echo count($result)?> ]</a>
            </div>

            <div class="txPack">
                <?php for($info = 0 ; $info < count($result) ;$info++){ ?>
                    <div class="info">

                        <?php if($info == 3){
                            break;
                        }?>

                        <?php if($acctNum == $result[$info]["transfer_to"] ):?>

                        <div class="flexAvatar">
                            <div class="avatar"></div>
                            <?php 
                                $tranfer_from = $result[$info]["transfer_from"];
                                $sql = "SELECT * FROM bankusers WHERE account_number = $tranfer_from ";
                                $fetch = mysqli_query($conn,$sql);
                                $results = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
                            foreach($results as $data):?>
                                <div class="txName">
                                    <h5><?php echo strtoupper($data["firstname"])?></h5><br>
                                    <span><?php echo $result[$info]["transfer_from"] ?></span>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="txAmount">
                            <p class="credit"><?php echo "+ ₦" . number_format($result[$info]["amount"]) ?>.00</p>
                            <div class="time"><?php echo $result[$info]["time"] ?></div>
                        </div>

                    <?php elseif($acctNum == $result[$info]["transfer_from"] ) :?>
                        
                        <div class="flexAvatar">
                            <div class="avatar"></div>
                            <?php 
                                $tranfer_to = $result[$info]["transfer_to"];
                                $sql = "SELECT * FROM bankusers WHERE account_number = $tranfer_to ";
                                $fetch = mysqli_query($conn,$sql);
                                $results = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
                            foreach($results as $data):?>
                                <div class="txName">
                                    <h5><?php echo strtoupper($data["firstname"])?></h5><br>
                                    <span><?php echo $result[$info]["transfer_to"] ?></span>
                                </div>
                            <?php endforeach ?>

                        </div>

                        <div class="txAmount">
                            <p class="debit"><?php echo "- ₦" . number_format($result[$info]["amount"]) ?>.00</p>
                            <div class="time"><?php echo $result[$info]["time"] ?></div>
                        </div>
                    <?php endif ?>
                        

                    </div>
                <?php } ?>
            </div>

        </div>

         <!-- four column -->
        <div class="fourcol">

            <div class="rows">
                <div class="">
                    <span>Income</span>
                    <h3 class="income"><?php echo "₦" .  number_format($_SESSION["total_income"])?>.00</h3>
                </div>
                <div class="">
                    <span>Expenses</span>
                    <h3 class="expenses"><?php echo "₦" . number_format($_SESSION["total_expenses"])?>.00</h3>
                </div>
            </div>

            <div class="rows">
                <div class="">
                    <span>Total Bills</span>
                    <h3 class="bills">₦ -----</h3>
                </div>
                <div class="">
                    <span>Savings</span>
                    <h3 class="savings"><?php echo "₦" . number_format($_SESSION["balance"])?>.00</h3>
                </div>
            </div>
            
        </div>

        <!-- Cards  -->
        <div class="cards">

            <div class="head">
                <h5>My Cards</h5>
                <a href="">View All</a>
            </div>

            <div class="card">

                <div class="cardBal">
                    <span>Balance</span>
                    <h4><?php echo "₦" . number_format($_SESSION["balance"])?>.00</h4><br>
                    <span>Card Number</span>
                    <h5>**** 9950</h5>
                </div>

                <div class="info">
                    <div class="exp">
                        <p>Expiry</p>
                        <span>12/25</span>
                    </div>
                    <div class="ccv">
                        <p>CCV</p>
                        <span>406</span>
                    </div>
                </div>

            </div>

        </div>

        <div class="bills">

        </div>


    </div>







    <!-- Modal -->
      
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Open modal
  </button> -->
</div>






   

 <script src="index.js"></script>
</body>
</html>
