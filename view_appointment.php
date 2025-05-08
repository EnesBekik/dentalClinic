<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
    header('location:login.php');

}

if(isset($_GET['get_id'])){
    $get_id=$_GET['get_id'];
}else{
    $get_id='';
    header('location:book_appointment.php');

}

if(isset($_POST['canceled'])){
    $update_appointment=$conn->prepare("UPDATE `appointments` SET status=? WHERE id=? LIMIT 1");
    $update_appointment->execute(['canceled',$get_id]);
    header('location:book_appointment.php');
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
        <h1>appointment details </h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>appointment details</span>
    </div>
   </div>

   <!-- booked appointment section starts -->
    <div class="appointment-detail">
        <div class="heading">
            <h1>appointment details</h1>
        </div>
        <div class="container">
            <?php
                $grand_total=0;

                $select_appointment=$conn->prepare("SELECT * FROM `appointments` WHERE id=? LIMIT 1");
                $select_appointment->execute([$get_id]);

                if($select_appointment->rowCount() > 0){
                    while($fetch_appointment=$select_appointment->fetch(PDO::FETCH_ASSOC)){
                        $select_service=$conn->prepare("SELECT * FROM `services` WHERE id=? LIMIT 1");
                        $select_service->execute([$fetch_appointment['service_id']]);

                        if($select_service->rowCount() > 0){
                            while($fetch_service=$select_service->fetch(PDO::FETCH_ASSOC)){
                                $sub_total=$fetch_appointment['price'];
                                $grand_total+=$sub_total;     

            ?>
            <div class="box">
                <div class="col">
                    <img src="uploaded_files/<?= $fetch_service['image']; ?>" class="image" alt="">
                    <p class="date"><i class="fa-solid fa-calendar-days"></i><span><?=$fetch_appointment['date'];?></span></p>
                    <div class="detail">
                        <h3 class="name"><?= $fetch_service['name']; ?></h3>
                        <p class="grand-total">total amount paid: <span>$<?= $grand_total; ?>/-</span> </p>
                    </div>
                </div>
                <div class="col">
                    <?php
                       $select_employee=$conn->prepare("SELECT * FROM `employee` WHERE id = ? LIMIT 1");
                    $select_employee->execute([$fetch_appointment['employee_id']]);

                    if($select_employee->rowCount() > 0){
                        while($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)){


                   
                    ?>
                    <p class="title">employee name:</p>
                    <div class="employee">
                        <img src="uploaded_files/<?= $fetch_employee['profile']; ?>" class="employee">
                        <div>
                            <p><?= $fetch_employee['name']; ?></p>
                            <p><?= $fetch_employee['profession']; ?></p>
                        </div>
                    </div>
                    <?php
                            }    
                        }
                    ?>
                    <p class="title">customer detaails</p>
                    <p class="user"><i class="fa-solid fa-users-rectangle"></i><?= $fetch_appointment['name']; ?></p>
                    <p class="user"><i class="fa-solid fa-phone"></i><?= $fetch_appointment['number']; ?></p>
                    <p class="user"><i class="fa-solid fa-envelope"></i><?= $fetch_appointment['email']; ?></p>
                    <p class="user"><i class="fa-solid fa-calendar-alt"></i><?= $fetch_appointment['date']; ?></p>
                    <p class="user"><i class="fa-solid fa-users-rectangle"></i><?= $fetch_appointment['time']; ?></p>
                    <p class="title">appointment status</p>
                    <p class="status" style="color:<?php if($fetch_appointment['status']=='booked'){echo "green";}elseif($fetch_appointment['status']=='canceled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_appointment['status']; ?></p>

                    <?php if($fetch_appointment['status']=='canceled'){ ?>
                        <a href="appointment.php?get_id=<?=$fetch_service['id'];?>" class="btn">book appointment again"></a>
                         <?php }else{ ?>
                            <form method="post" action="" >
                                <button type="submit" name="canceled" class="btn" onclick="return confirm('do you want to canceled this appointmaent');">canceled this appointmaent</button>

                            </form>
                            <?php }?>
                    </div>
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