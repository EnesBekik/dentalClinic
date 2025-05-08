<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
}

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
}

$pid=$_GET['pid'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denti Care - Dental clinic website template</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">

</head>

<body >

    <?php include 'components/user_header.php';?>

    <div class="banner">
    <div class="detail">
        <h1>service details</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>service details</span>
    </div>
   </div>
   
<div class="view_container">
    <?php
        if(isset($_GET['pid'])){
            $pid=$_GET['pid'];
            $select_service=$conn->prepare("SELECT * FROM `services` WHERE id='$pid' ");
            $select_service->execute();

            if($select_service->rowCount()>0){
                while($fetch_service=$select_service->fetch(PDO::FETCH_ASSOC)){

    ?>
    <form action="" method="post" class="box">
        <div class="img-box">
            <div class="heading">
                <h1><img src="image/separator.png">service details<img src="image/separator.png"></h1>
            </div>
            <img src="uploaded_files/<?= $fetch_service['image'];?>" alt="">
        </div>
        <div class="detail">
            <p class="price">$<?= $fetch_service['price'];?>/-</p>
            <div class="name"><?= $fetch_service['name'];?></div>
            <p class="sevice-dtail"><?= $fetch_service['service_detail'];?></p>
            <input type="hidden" name="service_id" value="<?= $fetch_service['id'];?>" >
            <div class="flex-btn">
                <a href="appointment.php?get_id=<?= $fetch_service['id'];?>" class="btn" style="width: 100%;">book appointment now</a>
            </div>
        </div>
    </form>
    <?php
                }
            }
        }else{
            echo '
            
           <div class="empty">
            <p>no services added yet!</p>
           </div> ';
        }
    ?>
</div>



    <?php include 'components/user_footer.php';?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/user_script.js"></script>


    <?php include 'components/alert.php'; ?>

</body>

</html>