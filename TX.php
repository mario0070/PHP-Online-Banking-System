<?php 

    session_start();
    
    if(!$_SESSION){
        header("location: login.php");
    }

    include("./tmp/header.php");
    include("./tmp/connection.php");
    $acctNum = $_SESSION["acctNum"];

    // get the sender and recipient info
    $sql = "SELECT * FROM transactions WHERE transfer_from = '$acctNum' or transfer_to = '$acctNum' ORDER BY id DESC";
    $fetch = mysqli_query($conn,$sql);
    $result = mysqli_fetch_all($fetch,MYSQLI_ASSOC);

    
 
?>


        <!-- transaction history -->
        <div class="tx">
            <div class="top">
                <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <span>Total Transactions - [ <?php echo count($result)?> ]</span>
            </div>

            <div class="txPack">

            <?php foreach($result as $info){ ?>
                <div class="info">
                    <?php if($acctNum == $info["transfer_to"] ):?>

                        <div class="flexAvatar">
                            <div class="avatar"></div>
                            <?php 
                                $tranfer_from = $info["transfer_from"];
                                $sql = "SELECT * FROM bankusers WHERE account_number = $tranfer_from ";
                                $fetch = mysqli_query($conn,$sql);
                                $result = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
                            foreach($result as $data):?>
                                <div class="txName">
                                    <h5><?php echo strtoupper($data["firstname"])?></h5><br>
                                    <span><?php echo $info["transfer_from"] ?></span>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="txAmount">
                            <span><?php echo "+ ₦" . number_format($info["amount"]) ?>.00</span>
                            <div class="time"><?php echo $info["time"] ?></div>
                        </div>

                    <?php elseif($acctNum == $info["transfer_from"] ) :?>
                        
                        <div class="flexAvatar">
                            <div class="avatar"></div>
                            <?php 
                                $tranfer_to = $info["transfer_to"];
                                $sql = "SELECT * FROM bankusers WHERE account_number = $tranfer_to ";
                                $fetch = mysqli_query($conn,$sql);
                                $result = mysqli_fetch_all($fetch,MYSQLI_ASSOC);
                            foreach($result as $data):?>
                                <div class="txName">
                                    <h5><?php echo strtoupper($data["firstname"])?></h5><br>
                                    <span><?php echo $info["transfer_to"] ?></span>
                                </div>
                            <?php endforeach ?>

                        </div>

                        <div class="txAmount">
                            <p><?php echo "- ₦" . number_format($info["amount"]) ?>.00</p>
                            <div class="time"><?php echo $info["time"] ?></div>
                        </div>
                    <?php endif ?>

                </div>
                <?php } ?>
                
               
            </div>

        </div>

<?php 

    include("./tmp/footer.php");
?>