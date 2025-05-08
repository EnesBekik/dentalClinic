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

$get_id=$_GET['get_id'];



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
        <h1>employee details</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>employee details</span>
    </div>
   </div>

   <div class="view_container">
    <div class="heading">
            <h1>our best dental team</h1>
            <p>Bringing confidence through exceptional dentistry </p>
        </div>
        <?php
            if(isset($_GET['get_id'])){
                $get_id=$_GET['get_id'];
                $select_employee =$conn->prepare("SELECT * FROM `employee` WHERE id='$get_id'");
                $select_employee->execute();

                if($select_employee->rowCount() > 0){
                    while($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)){
                        
              
        ?>
        <form action="" method="post" class="box">
            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_employee['profile']; ?>" alt="">
                <img src="image/employee/signature-v.svg" class="sign" alt="">
                
            </div>
            <div class="detail">
                <div class="name"><?= $fetch_employee['name']; ?></div>
                <p class="info">profession: <span><?= $fetch_employee['profession'];?></span></p>
                <p class="info">phone number: <span><?= $fetch_employee['number'];?></span></p>
                <p class="info">email address: <span><?= $fetch_employee['email'];?></span></p>
                <p class="employee_detail"><?= $fetch_employee['profile_dec'];?></p>
                <input type="hidden" name="employee_id" value="<?= $fetch_employee['id']; ?>">
                <div class="flex-btn">
                    <a href="team.php?get_id=<?= $fetch_employee['id'];?>" class="btn" style="width: 100%;">go back</a>
                </div>
            </div>
        </form>
         <?php
                }
            }
        }else{
            echo '
            
           <div class="empty">
            <p>no employee added yet!</p>
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