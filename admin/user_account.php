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

     <section class="accounts">
        <div class="heading">
            <h1><img src="../uploaded_files/separator.png" alt="">Registered User's<img src="../uploaded_files/separator.png" alt=""></h1>
        </div>
     <div class="box-container">
        <?php
           $select_users=$conn->prepare("SELECT * FROM `users`");
           $select_users->execute();
           
           if($select_users->rowCount() > 0){
               while($fetch_users=$select_users->fetch(PDO::FETCH_ASSOC)){
                $user_id=$fetch_users['id'];
                   
             
        ?>
        <div class="box">
            <img src="../uploaded_files/<?=$fetch_users['image']; ?>" alt="">
            <p>user id: <span><?= $user_id;?></span></p>
            <p>user name: <span><?= $fetch_users['name'];?></span></p>
            <p>user email: <span><?= $fetch_users['email'];?></span></p>


        </div>
        <?php
              }
            }else{
                echo '
                
               <div class="empty">
                <p>no user registired yet ! </p>
               </div> ';
            }
        ?>


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