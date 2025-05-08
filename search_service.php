<?php

include 'components/connect.php';

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
        <h1>search result</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
            repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
        <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>search result</span>
    </div>
</div>

<div class="show-container">
    <div class="heading">
    <h1>search result</h1>
    </div>
    <div class="box-container">
        <?php
            if(isset($_POST['search_service']) or isset($_POST['search_service_btn'])){
                $search_service=$_POST['search_service'];
                $select_services=$conn->prepare("SELECT * FROM `services` WHERE name LIKE '%{$search_service}%' AND status =? ");
                $select_services->execute(['active']);

                if($select_services->rowCount()>0){
                    while($fetch_services=$select_services->fetch(PDO::FETCH_ASSOC)){
                        $service_id=$fetch_services['id'];
           
        
        ?>
         <form action="" method="post" class="box">
                <img src="uploaded_files/<?= $fetch_services['image']; ?>" class="image" alt="">
                <p class="price">$<?= $fetch_services['price']; ?>/-</p>
                <div class="content">
                    <div class="button">
                        <div><h3><?= $fetch_services['name']; ?></h3></div>
                        <div>
                            <a href="view_page.php?pid=<?= $fetch_services['id']; ?>" class="fa-solid fa-eye"></a>
                        </div>
                    </div>
                    <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                    <div class="flex-btn">
                        <a href="appointment.php?get_id=<?= $fetch_services['id']; ?>" class="btn" style="width:100% ">book appointment</a>
                    </div>
                </div>
            </form>
        <?php
                    }
                }else{
                    echo '
                    
                   <div class="empty">
                    <p>no services found!</p>
                   </div> ';
                }
            }else{
                echo '
                    
                   <div class="empty">
                    <p>no services added yet!</p>
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