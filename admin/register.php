<?php

include '../components/connect.php';

if(isset($_POST['register'])){
    $id=unique_id();

    $name = $_POST['name'];
    $name = htmlspecialchars(trim($name), ENT_QUOTES, 'UTF-8');

    $email=$_POST['email'];
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $pass = sha1($_POST['pass']);
    $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
    
    $cpass = sha1($_POST['cpass']);
    $cpass = htmlspecialchars($cpass, ENT_QUOTES, 'UTF-8');
   
    $image=$_FILES['image']['name'];
    $image = htmlspecialchars(trim($_FILES['image']['name']), ENT_QUOTES, 'UTF-8');

    $ext=pathinfo($image,PATHINFO_EXTENSION);
    $rename=unique_id().'.'.$ext;
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='../uploaded_files/'.$rename;

    $select_admin=$conn->prepare("SELECT * FROM `admin` WHERE email=?");
    $select_admin->execute([$email]);

    if($select_admin->rowCount()>0){
        $warning_msg[]='email already taken!';
    
    }else{
        if($pass!=$cpass){
        $warning_msg[]='confirm password not matched';
        }
        else{
            $insert_admin=$conn->prepare("INSERT INTO `admin`(id,name,email,password,image) VALUES(?,?,?,?,?)");
            $insert_admin->execute([$id,$name,$email,$cpass,$rename]);

            move_uploaded_file($image_tmp_name,$image_folder);
        
            $success_msg[]='new admin registered! please login now';
        }
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
    <!-- register section starts -->
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register" >
            <h3>register now</h3>
            <div class="flex">
                <div class="col">
                    <p>your name <span>*</span></p>
                    <input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
                    <p>your email <span>*</span></p>
                    <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">

                </div>
                <div class="col">
                    <p>your password <span>*</span></p>
                    <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
                    <p>confirm your password<span>*</span></p>
                    <input type="password" name="cpass" placeholder="confirm your password" maxlength="50" required class="box">

                </div>
            </div>
            <div class="input-field">
                <p>select profile <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link"> already have an account <a href="login.php">login now</a></p>
            <button type="submit" name="register" class="btn">register now</button>
        </form>
    </div>

    <!-- registion section ends -->


    <!-- sweetalert cdn link -->

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="../js/admin_script.js"></script>


    <?php include '../components/alert.php'; ?>

</body>

</html>