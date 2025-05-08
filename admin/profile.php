<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
    $admin_id=$_COOKIE['admin_id'];
}else{
    $admin_id='';
    header('location:login.php');
}

$select_service=$conn->prepare("SELECT * FROM `services`");
$select_service->execute();
$total_services=$select_service->rowCount();

$select_employee=$conn->prepare("SELECT * FROM `employee`");
$select_employee->execute();
$total_employee=$select_employee->rowCount();


$select_appointment=$conn->prepare("SELECT * FROM `appointments`");
$select_appointment->execute();
$total_appointments=$select_appointment->rowCount();



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

     <section class="profile-container">
        <div class="heading">
            <h1><img src="../uploaded_files/separator.png" alt="">Profile Details<img src="../uploaded_files/separator.png" alt=""></h1>
        </div>
        <div class="details">
            <div class="admin">
                <img src="../uploaded_files/<?=$fetch_profile['image']; ?>" alt="">
                <h3><?=$fetch_profile['name']; ?></h3>
                <span>admin</span>
                <a href="profile.php" class="btn">Profile</a>
            </div>
            <div class="flex">
                <div class="box">
                    <span><?= $total_services;?></span>
                    <p>total services</p>
                    <a href="view_service.php" class="btn">total services</a>
                </div>
                <div class="box">
                    <span><?= $total_employee;?></span>
                    <p>total employee</p>
                    <a href="view_employee.php" class="btn">total employee</a>
                </div>
                <div class="box">
                    <span><?= $total_appointments;?></span>
                    <p>total appointments</p>
                    <a href="admin_appointment.php" class="btn">total appointments</a>
                </div>


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