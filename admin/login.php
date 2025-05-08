<?php

include '../components/connect.php';

if(isset($_POST['login'])){
  
    $email=$_POST['email'];
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    $pass = sha1($_POST['pass']);
    $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');

    $select_admin=$conn->prepare("SELECT * FROM `admin` WHERE email=? AND password=? LIMIT 1");
    $select_admin->execute([$email,$pass]);
    $row=$select_admin->fetch(PdO::FETCH_ASSOC);

    if($select_admin->rowCount()>0){
        setcookie('admin_id',$row['id'],time()+60*60*24*30,'/');
        header('location:index.php');
    }
    else{
        $warning_msg[]='incorrect email or password';
    }

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denti Care - Dental clinic website template</title>


    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
 
<body style="padding-left: 0;">
    <!-- register section starts -->
    <div class="form-container form">
        <form action="" method="post" enctype="multipart/form-data" class="login" >
            <h3>login now</h3>
            
            <div class="input-field">
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
            </div>

            <div class="input-field">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="50" required class="box">
            </div>
            <p class="link"> do not have  an account <a href="register.php">register now</a></p>
            <button type="submit" name="login" class="btn">login now</button>
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