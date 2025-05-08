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

    $email=$_POST['email'];
    $email= htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $profession=$_POST['profession'];
    $profession= htmlspecialchars(trim($_POST['profession']), ENT_QUOTES, 'UTF-8');

    $number=$_POST['number'];
    $number= htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8');


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

    $select_image=$conn->prepare("SELECT * FROM `employee` WHERE profile=?");
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
        $insert_employee=$conn->prepare("INSERT INTO `employee`(id,name,profession,email,number,profile_dec,profile,status) VALUES(?,?,?,?,?,?,?,?)");
        $insert_employee->execute([$id,$name,$profession,$email,$number,$content,$image,$status]);
        $success_msg[]='employee added successfully';
    }
}

    
if(isset($_POST['draft'])){
    $id=unique_id();

    $name=$_POST['name'];
    $name= htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

    $email=$_POST['email'];
    $email= htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $profession=$_POST['profession'];
    $profession= htmlspecialchars(trim($_POST['profession']), ENT_QUOTES, 'UTF-8');

    $number=$_POST['number'];
    $number= htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8');


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

    $select_image=$conn->prepare("SELECT * FROM `employee` WHERE profile=?");
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
        $insert_employee=$conn->prepare("INSERT INTO `employee`(id,name,profession,email,number,profile_dec,profile,status) VALUES(?,?,?,?,?,?,?,?)");
        $insert_employee->execute([$id,$name,$profession,$email,$number,$content,$image,$status]);
        $success_msg[]='employee save as draft successfully';
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
            <h1><img src="../uploaded_files/separator.png" alt="">Add Employee<img src="../uploaded_files/separator.png" alt=""></h1>
        </div>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" class="register">
              <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>employee name <span>*</span></p>
                        <input type="text" name="name" placeholder="add employee name" class="box" required>
                    </div>

                    <div class="input-field">
                        <p>employee email <span>*</span></p>
                        <input type="email" name="email" placeholder="add employee email" class="box" required>
                    </div>

                </div>

                <div class="col">
                    <div class="input-field">
                        <p>employee profession <span>*</span></p>
                        <input type="text" name="profession" placeholder="add employee profession" class="box" required>
                    </div>

                    <div class="input-field">
                        <p>employee number <span>*</span></p>
                        <input type="number" name="number" placeholder="add employee number" class="box" required>
                    </div>
                </div>
              </div>
              <div class="input-field">
                <p>profile description <span>*</span></p>
                <textarea name="content" placeholder="employee profile description" class="box">

                </textarea>
              </div>

              <div class="input-field">
                <p>select description <span>*</span></p>
                <input type="file" name="image" accept="image/*" class="box" required>
              </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">add employee</button>
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