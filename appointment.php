<?php
include 'components/connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// E-posta gönderme fonksiyonu
function sendAppointmentEmail($name, $email, $service, $date, $time, $employee_name, $price) {
    $mail = new PHPMailer(true);

    try {
        // Sunucu ayarları
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'enes.bekik1@gmail.com'; // Gönderen Gmail adresiniz
        $mail->Password = 'zeasstvaxkhqndzg'; // Gmail uygulama şifreniz
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL için
        $mail->Port = 465;

        // Gönderen ve alıcı bilgileri
        $mail->setFrom('enes.bekik1@gmail.com', 'Denti Care');
        $mail->addAddress($email, $name);

        // E-posta içeriği
        $mail->isHTML(true);
        $mail->Subject = 'Randevu Onayi - Denti Care';
        $mail->Body    = '
            <h2>Sayın '.$name.',</h2>
            <h3>Randevu Bilgileriniz</h3>
            <p><strong>Hizmet:</strong> '.$service.'</p>
            <p><strong>Doktor:</strong> '.$employee_name.'</p>
            <p><strong>Tarih:</strong> '.$date.'</p>
            <p><strong>Saat:</strong> '.$time.'</p>
            <p><strong>Ücret:</strong> $'.$price.'</p>
            <p>Randevunuz başarıyla oluşturulmuştur. Denti Care kliniğimizi tercih ettiğiniz için teşekkür ederiz.</p>
            <p>Randevunuzu iptal etmek veya değiştirmek için lütfen bizimle iletişime geçin.</p>
            <p>Saygılarımızla,<br>Denti Care Ekibi</p>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("E-posta gönderme hatası: {$mail->ErrorInfo}");
        return false;
    }
}

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['book_appointment'])){
    if($user_id != ''){
        $id = unique_id();
        $name = htmlspecialchars(trim($_POST['first_name'].' '.$_POST['last_name']), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $number = htmlspecialchars(trim($_POST['number']), ENT_QUOTES, 'UTF-8');
        $payment = htmlspecialchars(trim($_POST['payment']), ENT_QUOTES, 'UTF-8');
        $employee_id = htmlspecialchars(trim($_POST['employee']), ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars(trim($_POST['date']), ENT_QUOTES, 'UTF-8');
        $time = htmlspecialchars(trim($_POST['time']), ENT_QUOTES, 'UTF-8');

        if(isset($_GET['get_id'])){
            $get_service = $conn->prepare("SELECT * FROM `services` WHERE id = ? LIMIT 1");
            $get_service->execute([$_GET['get_id']]);

            if($get_service->rowCount() > 0){
                $fetch_s = $get_service->fetch(PDO::FETCH_ASSOC);
                
                $get_employee = $conn->prepare("SELECT name FROM `employee` WHERE id = ? LIMIT 1");
                $get_employee->execute([$employee_id]);
                $fetch_employee = $get_employee->fetch(PDO::FETCH_ASSOC);
                $employee_name = $fetch_employee['name'];

                $insert_appointment = $conn->prepare("INSERT INTO `appointments` (id, user_id, name, number, email, service_id, employee_id, date, time, price, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $insert_appointment->execute([$id, $user_id, $name, $number, $email, $fetch_s['id'], $employee_id, $date, $time, $fetch_s['price'], $payment]);

                $emailSent = sendAppointmentEmail(
                    $name,
                    $email,
                    $fetch_s['name'],
                    $date,
                    $time,
                    $employee_name,
                    $fetch_s['price']
                );

                if($emailSent){
                    $success_msg[] = 'Randevunuz oluşturuldu ve onay e-postası gönderildi.';
                } else {
                    $warning_msg[] = 'Randevunuz oluşturuldu ancak e-posta gönderilemedi.';
                }

                header('location:book_appointment.php');
            }
        }
    } else {
        $warning_msg[] = 'Lütfen önce giriş yapın!';
    }
}
?>

<!-- HTML kısmı aynı kalabilir -->
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
        <h1>book your appointment</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>book your appointment</span>
    </div>
   </div>
   
<div class="summary">
    <h3>book your appointment</h3>
    <div class="container">
        <?php
           $grand_total=0;
           if(isset($_GET['get_id'])){
              $select_get=$conn->prepare("SELECT * FROM `services` WHERE id=?");
              $select_get->execute([$_GET['get_id']]);

              while($fetch_get=$select_get->fetch(PDO::FETCH_ASSOC)){
                 $sub_total=$fetch_get['price'];
                 $grand_total+=$sub_total;        
        ?>
        <div class="flex">
            <img src="uploaded_files/<?= $fetch_get['image']; ?>" class="image" >
            <div>
                <h3 class="name"><?= $fetch_get['name']; ?></h3>
                <p class="price">$<?= $fetch_get['price']; ?>/-</p>
            </div>
        </div>
        <?php
            }
            }else{
                echo '
                
            <div class="empty">
                <p>no services added yet!</p>
            </div> ';
            }
        ?>
        <div class="grand-total"><span>total amount payable:</span> <p> $<?= $grand_total; ?>/-</p></div>
    </div>
<h3>fiil all input for appointment</h3>
</div>

<div class="form-container appointment">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>first name <span>*</span></p>
                    <input type="text" name="first_name" placeholder="enter your first name" required class="box">
                </div>
                <div class="input-field">
                    <p>last name <span>*</span></p>
                    <input type="text" name="last_name" placeholder="enter your last name" required class="box">
                </div>
                <div class="input-field">
                    <p>your number<span>*</span></p>
                    <input type="number" name="number" placeholder="enter your number" required class="box">
                </div>
                <div class="input-field">
                    <p>your email<span>*</span></p>
                    <input type="email" name="email" placeholder="enter your email" required class="box">
                </div>

            </div>
            <div class="col">
                <div class="input-field">
                    <p>payment method<span>*</span></p>
                    <select name="payment" class="box select">
                        <option selected disabled>select payment method</option>
                        <option value="paytm" >paytm</option>
                        <option value="credit card">credit card</option>
                        <option value="phone pay">phone pay</option>
                        <option value="G-pay">G-pay</option>
                    </select>
                </div>

                <div class="input-field">
                    <p>select employee<span>*</span></p>
                    <select name="employee" class="box select">
                        <?php
                           $select_employee=$conn->prepare("SELECT * FROM `employee` WHERE status=?");
                           $select_employee->execute(['active']);

                           if($select_employee->rowCount() > 0){
                            while($fetch_employee=$select_employee->fetch(PDO::FETCH_ASSOC)){
                             
                        ?>
                        <option value="<?= $fetch_employee['id']; ?>"><?= $fetch_employee['name']; ?></option>
                       <?php
                                    
                                }
                            }
                       ?>
                    </select>
                </div>
                <div class="input-field">
                    <p>select date<span>*</span></p>
                    <input type="date" name="date" placeholder="select date" required class="box">
                </div>
                <div class="input-field">
                    <p>select time<span>*</span></p>
                    <select name="time" class="box select">
                        <option selected disabled>select time</option>
                        <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                        <option value="9:30 AM - 10:30 AM">9:30 AM - 10:30 AM</option>
                        <option value="11:30 AM - 12:30 PM">11:30 AM - 12:30 PM</option>
                        <option value="12:00 AM - 1:00 PM">12:00 AM - 1:00 PM</option>
                        <option value="1:30 PM - 2:30 PM">1:30 PM - 2:30 PM</option>
                        <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                        <option value="3:30 PM - 4:30 PM">3:30 PM - 4:30 PM</option>
                        <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>

                    </select>
                </div>
            </div>
        </div>
        <button type="submit" name="book_appointment" class="btn">book appointment</button>
    </form>
</div>


    <?php include 'components/user_footer.php';?>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/user_script.js"></script>


    <?php include 'components/alert.php'; ?>

</body>

</html>