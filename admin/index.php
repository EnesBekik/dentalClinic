<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
    $admin_id=$_COOKIE['admin_id'];
}else{
    $admin_id='';
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
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>

<body style="padding-left: 0;">
    
<div class="main-contaner">
    <?php include '../components/admin_header.php';?>

     <section class="dashboard">
        <div class="heading">
            <h1><img src="../uploaded_files/separator.png" alt="">DASHBOARD<img src="../uploaded_files/separator.png" alt=""></h1>
        </div>
     <div class="box-container">
        <div class="box">
            <h3>WELCOME</h3>
            <p><?=$fetch_profile['name']; ?></p>
            <a href="profile.php" class="btn">view profile</a>
        </div>
        <div class="box">
            <?php
               $select_msg=$conn->prepare("SELECT * FROM `message`");
               $select_msg->execute();
               $num_of_msg=$select_msg->rowCount();
            ?>
            <h3><?=$num_of_msg; ?></h3>
            <p>all messages</p>
            <a href="admin_message.php" class="btn">view messages</a>
        </div>

        <div class="box">
            <?php
               $select_services=$conn->prepare("SELECT * FROM `services`");
               $select_services->execute();
               $num_of_services=$select_services->rowCount();
            ?>
            <h3><?=$num_of_services; ?></h3>
            <p>view services</p>
            <a href="view_service.php" class="btn">view services</a>
        </div>

        <div class="box">
            <?php
               $select_active_services=$conn->prepare("SELECT * FROM `services` WHERE status=?");
               $select_active_services->execute(['active']);
               $num_of_active_services=$select_active_services->rowCount();
            ?>
            <h3><?=$num_of_active_services; ?></h3>
            <p>view active services</p>
            <a href="view_service.php" class="btn">view active services</a>
        </div>



        <div class="box">
            <?php
               $select_deactive_services=$conn->prepare("SELECT * FROM `services` WHERE status=?");
               $select_deactive_services->execute(['deactive']);
               $num_of_deactive_services=$select_deactive_services->rowCount();
            ?>
            <h3><?=$num_of_deactive_services; ?></h3>
            <p>view deactive services</p>
            <a href="view_service.php" class="btn">view deactive services</a>
        </div>


        <div class="box">
            <?php
               $select_employee=$conn->prepare("SELECT * FROM `employee` ");
               $select_employee->execute();
               $num_of_employee=$select_employee->rowCount();
            ?>
            <h3><?=$num_of_employee; ?></h3>
            <p>view employee</p>
            <a href="view_employee.php" class="btn">view employee</a>
        </div>


        <div class="box">
            <?php
               $select_appointment=$conn->prepare("SELECT * FROM `appointments` ");
               $select_appointment->execute();
               $num_of_appointment=$select_appointment->rowCount();
            ?>
            <h3><?=$num_of_appointment; ?></h3>
            <p>view appointment</p>
            <a href="admin_appointment.php" class="btn">view appointment</a>
        </div>

        <div class="box">
            <?php
               $select_canceled_appointment=$conn->prepare("SELECT * FROM `appointments` WHERE status=? ");
               $select_canceled_appointment->execute(['canceled']);
               $num_of_canceled_appointment=$select_canceled_appointment->rowCount();
            ?>
            <h3><?=$num_of_canceled_appointment; ?></h3>
            <p>view canceled appointment</p>
            <a href="admin_appointment.php" class="btn">view canceled appointment</a>
        </div>

        <div class="box">
            <?php
               $select_users=$conn->prepare("SELECT * FROM `users`");
               $select_users->execute();
               $num_of_users=$select_users->rowCount();
            ?>
            <h3><?=$num_of_users; ?></h3>
            <p>registered users</p>
            <a href="user_Account.php" class="btn">registered users</a>
        </div>


    </div>
   


     </section>



</div>


    <!-- sweetalert cdn link -->

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="../js/admin_script.js"></script>


    <?php include '../components/alert.php'; ?>

</body>

</html>