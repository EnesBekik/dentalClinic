<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

$get_id=$_GET['post_id'];

if (isset($_POST['delete'])) {
    $service_id = $_POST['service_id'];
    $service_id = htmlspecialchars($service_id, ENT_QUOTES, 'UTF-8');

    // Önce silinecek kaydın resmini al
    $get_image = $conn->prepare("SELECT image FROM `services` WHERE id = ?");
    $get_image->execute([$service_id]);
    $fetch_image = $get_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_image && $fetch_image['image'] != '') {
        $image_path = '../uploaded_files/' . $fetch_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // resmi sil
        }
    }

    // Sonra servisi sil
    $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
    $delete_service->execute([$service_id]);

    header('location:view_service.php');
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
        <?php include '../components/admin_header.php'; ?>

        <section class="read-container">
            <div class="heading">
                <h1><img src="../uploaded_files/separator.png" alt=""> Services Detail<img src="../uploaded_files/separator.png" alt=""></h1>
            </div>
            <div class="container">
               <?php
               $select_services=$conn->prepare("SELECT * FROM `services` WHERE id=?");
               $select_services->execute([$get_id]);

               if($select_services->rowCount()>0){
                while($fetch_services=$select_services->fetch(PDO::FETCH_ASSOC)){
                    
                
               ?>
               <form action="" method="post" class="box">
                <input type="hidden" name="service_id" value="<?=$fetch_services['id'] ?>">
                <div class="status" style="color: <?php if ($fetch_services['status'] == 'active') {
                                                                        echo "limegreen";
                                                                    } else {
                                                                        echo "red";
                                                                    } ?>;"><?= $fetch_services['status']; ?></div>
                 <?php if ($fetch_services['image'] != '') {  ?>
                                    <img src="../uploaded_files/<?= $fetch_services['image']; ?>" class="image">

                                <?php
                                }

                                ?>
               <p class="price"><?= $fetch_services['price'];?>/-</p>
                <div class="name"><?= $fetch_services['name'];?></div>
                <div class="content"><?= $fetch_services['service_detail'];?></div>
                <div class="flex-btn">
                    <a href="edit_service.php?id=<?= $fetch_services['id'];?>" class="btn">Edit</a>
                    <button type="submit" name="delete" class="btn" onclick="confirm('delete this service')">Delete</button>
                    <a href="view_service.php?post_id=<?= $fetch_services['id'];?>" class="btn">Go Back</a>

                  </div>

               </form>
               <?php
                     }
                  }else{
                    echo '
                    
                   <div class="empty">
                    <p>no services added yet! <br> <a href="add_service.php" class="btn" style="margin-top:1rem;">add services</a> </p>
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