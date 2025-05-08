<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
    $admin_id=$_COOKIE['admin_id'];
}else{
    $admin_id='';
    header('location:login.php');
}

if(isset($_POST['publish']))
{

    $id=unique_id();

    $name=$_POST['name'];
    $name= htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

    $price=$_POST['price'];
    $price= htmlspecialchars(trim($_POST['price']), ENT_QUOTES, 'UTF-8');

    $content=$_POST['content'];
    $content= htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8');

    $image=$_FILES['image']['name'];
    $image = htmlspecialchars(trim($_FILES['image']['name']), ENT_QUOTES, 'UTF-8');

    $ext=pathinfo($image,PATHINFO_EXTENSION);
    $rename=unique_id().'.'.$ext;
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='../uploaded_files/'.$rename;


    $status='active';

    $select_image=$conn->prepare("SELECT * FROM `services` WHERE image=?");
    $select_image->execute([$image]);

    if(isset($image)){
        if($select_image->rowCount()>0){
            $warning_msg[]='image name is repeated';
        }elseif($image_size >2000000){
            $warning_msg[]='iamge size too large';
        }else{
            move_uploaded_file($image_tmp_name,$image_folder);
        }
    }else{
        $image='';
    }
    if($select_image->rowCount()>0 AND $iamge !=''){
        $warning_msg[]='please rename your image';
    }else{
        $insert_service=$conn->prepare("INSERT INTO `services`(id,name,price,image,service_detail,status) VALUES(?,?,?,?,?,?)");
        $insert_service->execute([$id,$name,$price,$image,$content,$status]);
        $success_msg[]='service added successfully';
    }
}


    
if(isset($_POST['draft'])){

    $id=unique_id();

    $name=$_POST['name'];
    $name= htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

    $price=$_POST['price'];
    $price= htmlspecialchars(trim($_POST['price']), ENT_QUOTES, 'UTF-8');

    $content=$_POST['content'];
    $content= htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8');

    $image=$_FILES['image']['name'];
    $image = htmlspecialchars(trim($_FILES['image']['name']), ENT_QUOTES, 'UTF-8');

    $ext=pathinfo($image,PATHINFO_EXTENSION);
    $rename=unique_id().'.'.$ext;
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='../uploaded_files/'.$rename;

    $status='deactive';

    $select_image=$conn->prepare("SELECT * FROM `services` WHERE image=?");
    $select_image->execute([$image]);

    if(isset($image)){
        if($select_image->rowCount()>0){
            $warning_msg[]='image name is repeated';
        }elseif($image_size >2000000){
            $warning_msg[]='iamge size too large';
        }else{
            move_uploaded_file($image_tmp_name,$image_folder);
        }
    }else{
        $image='';
    }
    if($select_image->rowCount()>0 AND $iamge !=''){
        $warning_msg[]='please rename your image';
    }else{
        $insert_service=$conn->prepare("INSERT INTO `services`(id,name,price,image,service_detail,status) VALUES(?,?,?,?,?,?)");
        $insert_service->execute([$id,$name,$price,$image,$content,$status]);
        $success_msg[]='service added successfully';
    }
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

     <section class="dashboard">
        <div class="heading">
            <h1><img src="../uploaded_files/separator.png" alt="">Add Services<img src="../uploaded_files/separator.png" alt=""></h1>
        </div>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="input-field">
                    <p>service name <span>*</span></p>
                    <input type="text" name="name" placeholder="add service name " required class="box">
                </div>
                <div class="input-field">
                    <p>service charge <span>*</span></p>
                    <input type="number" name="price" placeholder="add service charge " required class="box">
                </div>
                <div class="input-field">
                    <p>service descrition <span>*</span></p>
                    <textarea name="content" class="box" required placeholder="service descrption"></textarea>
                </div>
                <div class="input-field">
                    <p>service thumbnail <span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">publish</button>
                    <button type="submit" name="draft" class="btn">save draft</button>
                </div>
            </form>
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