<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
    header('location:login.php');

}






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
        <h1>booked appointments</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>booked appointments</span>
    </div>
   </div>

   <!-- booked appointmentsection starts -->
    <div class="appointments">
        <div class="heading">
            <h1>booked appointments</h1>
        </div>
        <div class="box-container">
            <?php
                $select_appointments=$conn->prepare("SELECT * FROM `appointments` WHERE user_id=?");
                $select_appointments->execute([$user_id]);

                if($select_appointments->rowCount() > 0){
                    while($fetch_appointments=$select_appointments->fetch(PDO::FETCH_ASSOC)){
                        $service_id=$fetch_appointments['service_id'];
                        $select_service=$conn->prepare("SELECT * FROM `services` WHERE id=?");
                        $select_service->execute([$fetch_appointments['service_id']]);

                        if($select_service->rowCount() > 0){
                            while($fetch_service=$select_service->fetch(PDO::FETCH_ASSOC)){
                                
                      
            ?>
            <div class="box">
                <a href="view_appointment.php?get_id=<?=$fetch_appointments['id'];?>">
                    <img src="uploaded_files/<?= $fetch_service['image']; ?>" class="image" alt="">
                    <div class="content">
                        <p class="date"><i class="fa-solid fa-calendar-days"></i><span><?=$fetch_appointments['date'];?></span> </p>
                        <div class="row">
                            <h3 class="name"><?=$fetch_service['name'];?></h3>
                            <p class="price">$<?=$fetch_service['price'];?>/-</p>
                            <p class="status" style="color:<?php if($fetch_appointments['status']=='booked'){echo "green";}else{echo "red";}?>"><?=$fetch_appointments['status'];?></p>
                        </div>
                    </div>
                </a>
            </div>

            <?php
                            }
                        }
                    
                    }
                }else{
                    echo '
                    
                   <div class="empty">
                    <p>no appointment bookedyet!</p>
                   </div> ';
                }
            
            ?>
        </div>
    </div>
    
    <!--booked appointments section ends -->
   
  
    <?php include 'components/user_footer.php';?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/user_script.js"></script>


    <?php include 'components/alert.php'; ?>

</body>

</html>