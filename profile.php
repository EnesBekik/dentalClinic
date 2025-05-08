<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
    header('location:login.php');
}

$select_appointment=$conn->prepare("SELECT * FROM `appointments` WHERE user_id=?");
$select_appointment->execute([$user_id]);
$total_appointments=$select_appointment->rowCount();

$select_msg=$conn->prepare("SELECT * FROM `message` WHERE user_id=?");
$select_msg->execute([$user_id]);
$total_msg=$select_msg->rowCount();


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
        <h1>my profile</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>my profile</span>
    </div>
   </div>


<div class="profile">
    <div class="heading">
        <h1><img src="image/separator.png" alt="">profile details<img src="image/separator.png" alt=""></h1>
    </div>
    <div class="details">
        <div class="user">
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
            <h3><?= $fetch_profile['name']; ?></h3>
            <p>user</p>
            <a href="update.php" class="btn">update profile"></a>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="flex">
                <i class="fa-solid fa-book"></i>
                    <h3><?= $total_appointments; ?> appointments</h3>
                </div>
                <a href="book_appointment.php" class="btn">view appointments</a>
            </div>
            <div class="box">
                <div class="flex">
                    <i class="fa-regular fa-comment"></i>
                    <h3><?= $total_msg; ?> message send</h3>
                </div>
                <a href="contact.php" class="btn">send message</a>
            </div>
        </div>
    </div>
</div>
   
    

   
    <?php include 'components/user_footer.php';?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/user_script.js"></script>


    <?php include 'components/alert.php'; ?>

</body>

</html>