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

if(isset($_POST['send_msg'])){
    if($user_id !=''){
        $id=unique_id();

        $name=$_POST['name'];
        $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
        

        $email=$_POST['email'];
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        
        $subject=$_POST['subject'];
        $subject = htmlspecialchars(trim($_POST['subject']), ENT_QUOTES, 'UTF-8');
        

        $message=$_POST['message'];
        $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
        

        $verify_message=$conn->prepare("SELECT * FROM `message` WHERE user_id=? AND name=?  AND email=? AND subject=? AND message=?");
        $verify_message->execute([$user_id,$name,$email,$subject,$message]);

        if($verify_message->rowCount()>0){
            $warning_msg[]='message already send';
        }else{
            $insert_message=$conn->prepare("INSERT INTO `message` (id,user_id,name,email,subject,message) VALUES(?,?,?,?,?,?) ");
            $insert_message->execute([$id,$user_id,$name,$email,$subject,$message]);
            $success_msg[]='message send';
        }
    }else{
        $warning_msg[]='please login first';
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
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">

</head>

<body >

    <?php include 'components/user_header.php';?>

    <div class="banner">
    <div class="detail">
        <h1>contact us</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>contact us</span>
    </div>
   </div>
   
   <div class="contact">
    <div class="heading">
        <h1>contact DentiCare</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In, natus quos id
            quae consectetur cupiditate praesentium ea repellendus iure sequi nihil mollitia
        </p>
    </div>
        <div class="box-container">
            <div class="box">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-field">
                        <p>Your Name <span>*</span></p>
                        <input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your email <span>*</span></p>
                        <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Subject<span>*</span></p>
                        <input type="text" name="subject" placeholder="enter your reason" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your message <span>*</span></p>
                        <textarea name="message" class="box" id=""></textarea>
                    </div>
                    <button type="submit" name="send_msg" class="btn">send message </button>
                </form>
            </div>
            <div class="box">
                <img src="image/doctor.png" alt="">
            </div>
        </div>
</div>

<div class="services">
    <div class="heading">
        <h1>our contact details</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In, natus quos id
            quae consectetur cupiditate praesentium ea repellendus iure sequi nihil mollitia
        </p>
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/contact-icon (3).png" alt="">
            <div>
                <h4>emergency call</h4>
                <p>90990890098</p>
                <p>05454442727</p>
            </div>
        </div>
        <div class="box">
            <img src="image/contact-icon (1).png" alt="">
            <div>
                <h4>address</h4>
                <p>2727 Gaziantep Şehitkamil <br> Miami ,Florida,33169</p>
            </div>
        </div>
        <div class="box">
            <img src="image/contact-icon (2).png" alt="">
            <div>
                <h4>email</h4>
                <p>bozo@gmail.com</p>
                <p>bozo27@gmail.com</p>
            </div>
        </div>
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