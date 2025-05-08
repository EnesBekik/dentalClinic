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
        <h1>our team</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>our team</span>
    </div>
   </div>

   <div class="show-container">
   <div class="heading">
        <h1>our best dental team</h1>
        <p>Bringing confidence through exceptional dentistry </p>
    </div>
    <div class="box-container">
        <?php
           $select_employee =$conn->prepare("SELECT * FROM `employee` WHERE status=?");
           $select_employee->execute(['active']);

           if($select_employee->rowCount() > 0){
               while($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)){
  
        ?>
        <form action="" method="post" class="box">
            <img src="uploaded_files/<?= $fetch_employee['profile'];?>" class="image">
            <div class="content">
                <div><h3><?= $fetch_employee['name']; ?></h3></div>
                <p>profession:<span><?= $fetch_employee['profession']; ?></span></p>
                <input type="hidden" name="employee_id" value="<?= $fetch_employee['id']; ?>">
                <div class="flex-btn">
                    <a href="employee_detail.php?get_id=<?= $fetch_employee['id']; ?>" class="btn" style="width: 100%;">view profile detail</a>
                </div>
            </div>
        </form>
         <?php
                    }
                }else{
                    echo '
                    
                   <div class="empty">
                    <p>no employee added yet!</p>
                   </div> ';
                }
                
            ?>
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