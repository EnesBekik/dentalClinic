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
    $employee_id = $_POST['employee_id'] ?? null;
    $employee_id = htmlspecialchars($employee_id, ENT_QUOTES, 'UTF-8');

    // Önce silinecek kaydın resmini al
    $get_image = $conn->prepare("SELECT profile FROM `employee` WHERE id = ?");
    $get_image->execute([$employee_id]);
    $fetch_image = $get_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_image['image'] != '') {
        $image_path = '../uploaded_files/' . $fetch_image['profile'];
        if (file_exists($image_path)) {
            unlink($image_path); // resmi sil
        }
    }

    // Sonra servisi sil
    $delete_employee= $conn->prepare("DELETE FROM `employee` WHERE id = ?");
    $delete_employee->execute([$employee_id]);

    header('location:view_employee.php');
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
               $select_employee=$conn->prepare("SELECT * FROM `employee` WHERE id=?");
               $select_employee->execute([$get_id]);

               if($select_employee->rowCount()>0){
                while($fetch_employee=$select_employee->fetch(PDO::FETCH_ASSOC)){
                    
                
               ?>
               <form action="" method="post" class="box">
                <input type="hidden" name="employee_id" value="<?=$fetch_employee['id'] ?>">
                <div class="status" style="color: <?php if ($fetch_employee['status'] == 'active') {
                                                                        echo "limegreen";
                                                                    } else {
                                                                        echo "red";
                                                                    } ?>;"><?= $fetch_employee['status']; ?></div>
                 <?php if ($fetch_employee['profile'] != '') {  ?>
                                    <img src="../uploaded_files/<?= $fetch_employee['profile']; ?>" class="image">

                                <?php
                                }

                                ?>
                <div class="name"><?= $fetch_employee['name'];?></div>
                <div class="profession">Profession: <span><?= $fetch_employee['profession'];?></span></div>
                <div class="email">Employee Number: <span><?= $fetch_employee['number'];?></span></div>
                <div class="email">Employee Email: <span><?= $fetch_employee['email'];?></span></div>

                <div class="content"><?= $fetch_employee['profile_dec'];?></div>
                <div class="flex-btn">
                    <a href="edit_employee.php?id=<?= $fetch_employee['id'];?>" class="btn">Edit</a>
                    <button type="submit" name="delete" class="btn" onclick="confirm('delete this employee')">Delete</button>
                    <a href="view_employee.php?post_id=<?= $fetch_employee['id'];?>" class="btn">Go Back</a>

                  </div>

               </form>
               <?php
                     }
                  }else{
                    echo '
                    
                   <div class="empty">
                    <p>no employee added yet! <br> <a href="add_employee.php" class="btn" style="margin-top:1rem;">add employee</a> </p>
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