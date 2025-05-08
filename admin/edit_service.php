<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

if(isset($_POST['update'])){
    $service_id = $_POST['service_id'];
    $service_id = htmlspecialchars($service_id, ENT_QUOTES, 'UTF-8');


    $name = $_POST['name'];
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    

    $price = $_POST['price'];
    $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');

    $content = $_POST['content'];
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    $status = $_POST['status'];
    $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

    $update_service = $conn->prepare("UPDATE `services` SET name = ?, price = ?, service_detail = ?, status = ? WHERE id = ?");
    $update_service->execute([$name, $price, $content, $status, $service_id]);

    $success_msg[]='service updated successfully';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='../uploaded_files/'.$image;

    $select_image=$conn->prepare("SELECT * FROM `services` WHERE image=?");
    $select_image->execute([$image]);

    if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[]='image size is too large';
        }elseif($select_image->rowCount()>0 AND $image!=''){
            $warning_msg[]='please rename your image';
        }else{
            $update_image=$conn->prepare("UPDATE `services` SET image=? WHERE id=?");
            $update_image->execute([$image,$service_id]);
            
            move_uploaded_file($image_tmp_name, $image_folder);

            if($old_image !=$image AND $old_image !=''){
                unlink('../uploaded_files/'.$old_image);
            }

            $success_msg[]='image updated successfully';


        }
    }

}


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

        <section class="post_editor">
            <div class="heading">
                <h1><img src="../uploaded_files/separator.png" alt=""> Edit Service <img src="../uploaded_files/separator.png" alt=""></h1>
            </div>
            <div class="container">
              <?php
                 $service_id=$_GET['id'];

                 $select_services=$conn->prepare("SELECT * FROM `services` WHERE id=?");
                 $select_services->execute([$service_id]);

                 if($select_services->rowCount()>0){
                     while($fetch_services=$select_services->fetch(PDO::FETCH_ASSOC)){

                  
                   
               ?>
               <div class="form-container" >
                <form action=""  method="post" enctype="multipart/form-data" class="register" >
                   <input type="hidden" name="old_image" value="<?=$fetch_services['image'] ?>">
                   <input type="hidden" name="service_id" value="<?=$fetch_services['id'] ?>">

                   <div class="input-fielad">
                    <p>service status <span>*</span> </p>
                    <select name="status" class="box " >
                        <option selected value="<?=$fetch_services['status'] ?>"></option>
                        <option value="active">active</option>
                        <option value="deactive">deactive</option>
                    </select>
                   </div>
                   <div class="input-field">
                   <p>service name <span>*</span> </p>
                    <input type="text" name="name" value="<?=$fetch_services['name'] ?>" class="box">
                   </div>


                   <div class="input-field">
                   <p>service price <span>*</span> </p>
                    <input type="number" name="price" value="<?=$fetch_services['price'] ?>" class="box">
                   </div>


                   <div class="input-field">
                   <p>service description <span>*</span> </p>
                   <textarea name="content" class="box"><?=$fetch_services['service_detail'] ?></textarea>
                   </div>

                   
                   <div class="input-field">
                   <p>service image <span>*</span> </p>
                    <input type="file" name="image" accept="image/*" class="box">
                    <?php if($fetch_services['image'] != ''){?>
                        <img src="../uploaded_files/<?=$fetch_services['image'] ?>" class="image" alt="" style="width: 100%;">
                    <?php }?>
                </div>
                <div class="flex-btn">
                    <button type="submit" class="btn" name="update">update service</button>
                    <button type="submit" class="btn" name="delete" onclick="return confirm('delete this service ');">delete service</button>
                    <a href="view_service.php?post_id=<?= $fetch_services['id'];?>" class="btn" style="text-align: center;">Go Back</a>

                    
                </div>



                </form>

               </div>
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