<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

if(isset($_POST['update'])){
    $employee_id = $_POST['employee_id'];
    $employee_id = htmlspecialchars($employee_id, ENT_QUOTES, 'UTF-8');


    $name = $_POST['name'];
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    

    $email = $_POST['email'];
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $number = $_POST['number'];
    $number = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');


    $profession = $_POST['profession'];
    $profession = htmlspecialchars($profession, ENT_QUOTES, 'UTF-8');



    $content = $_POST['content'];
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    $status = $_POST['status'];
    $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

    $update_employee = $conn->prepare("UPDATE `employee` SET name = ?, profession = ?, email = ?, number = ?, profile_dec = ?, status = ? WHERE id = ?");
    $update_employee->execute([$name,$profession, $email,$number, $content, $status, $employee_id]);

    $success_msg[]='service updated successfully';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='../uploaded_files/'.$image;

    $select_image=$conn->prepare("SELECT * FROM `employee` WHERE profile=?");
    $select_image->execute([$image]);

    if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[]='image size is too large';
        }elseif($select_image->rowCount()>0 AND $image!=''){
            $warning_msg[]='please rename your image';
        }else{
            $update_image=$conn->prepare("UPDATE `employee` SET profile=? WHERE id=?");
            $update_image->execute([$image,$employee_id]);
            
            move_uploaded_file($image_tmp_name, $image_folder);

            if($old_image !=$image AND $old_image !=''){
                unlink('../uploaded_files/'.$old_image);
            }

            $success_msg[]='image updated successfully';


        }
    }

}


if (isset($_POST['delete'])) {
    $emp_id = $_POST['employee_id'];
    $emp_id = htmlspecialchars($emp_id, ENT_QUOTES, 'UTF-8');

    // Önce silinecek kaydın resmini al
    $get_image = $conn->prepare("SELECT profile FROM `employee` WHERE id = ?");
    $get_image->execute([$emp_id]);
    $fetch_image = $get_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_image && $fetch_image['image'] != '') {
        $image_path = '../uploaded_files/' . $fetch_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // resmi sil
        }
    }

    // Sonra servisi sil
    $delete_employee = $conn->prepare("DELETE FROM `employee` WHERE id = ?");
    $delete_employee->execute([$emp_id]);

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

        <section class="post_editor">
            <div class="heading">
                <h1><img src="../uploaded_files/separator.png" alt=""> Edit Service <img src="../uploaded_files/separator.png" alt=""></h1>
            </div>
            <div class="container">
              <?php
                 $employee_id=$_GET['id'];

                 $select_employee=$conn->prepare("SELECT * FROM `employee` WHERE id=?");
                 $select_employee->execute([$employee_id]);

                 if($select_employee->rowCount()>0){
                     while($fetch_employee=$select_employee->fetch(PDO::FETCH_ASSOC)){

                  
                   
               ?>
               <div class="form-container" >
                <form action=""  method="post" enctype="multipart/form-data" class="register" >
                   <input type="hidden" name="old_image" value="<?=$fetch_employee['profile'] ?>">
                   <input type="hidden" name="employee_id" value="<?=$fetch_employee['id'] ?>">

                   
                   <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>employee name <span>*</span></p>
                        <input type="text" name="name" placeholder="<?=$fetch_employee['name'] ?>" class="box" >
                    </div>

                    <div class="input-field">
                        <p>employee email <span>*</span></p>
                        <input type="email" name="email" placeholder="<?=$fetch_employee['email'] ?>" class="box" >
                    </div>
                    <div class="input-fielad">
                    <p>employee status <span>*</span> </p>
                    <select name="status" class="box " >
                        <option selected value="<?=$fetch_employee['status'] ?>"></option>
                        <option value="active">active</option>
                        <option value="deactive">deactive</option>
                    </select>
                   </div>

                </div>

                <div class="col">
                    <div class="input-field">
                        <p>employee profession <span>*</span></p>
                        <input type="text" name="profession" placeholder="<?=$fetch_employee['profession'] ?>" class="box" >
                    </div>

                    <div class="input-field">
                        <p>employee number <span>*</span></p>
                        <input type="number" name="number" placeholder="<?=$fetch_employee['number'] ?>" class="box" >
                    </div>
                    <div class="input-field">
                   <p>employee image <span>*</span> </p>
                    <input type="file" name="image" accept="image/*" class="box">
                    
                </div>                    
                </div>
              </div>
              <div class="input-field">
                <p>profile decription <span>*</span></p>
                <textarea name="content" placeholder="" class="box" id=""><?=$fetch_employee['profile_dec'] ?></textarea>
              </div>
              <?php if($fetch_employee['profile'] != ''){?>
                        <img src="../uploaded_files/<?=$fetch_employee['profile'] ?>" class="image" alt="" style="width: 100%;">
                    <?php }?>

                   
                   
                <div class="flex-btn">
                    <button type="submit" class="btn" name="update">update employee</button>
                    <button type="submit" class="btn" name="delete" onclick="return confirm('delete this service ');">delete employee</button>
                    <a href="view_employee.php?post_id=<?= $fetch_employee['id'];?>" class="btn" style="text-align: center;">Go Back</a>

                    
                </div>



                </form>

               </div>
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