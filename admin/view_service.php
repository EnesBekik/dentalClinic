<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

if (isset($_POST['delete'])) {
    // 1. Önce service_id'nin gönderilip gönderilmediğini kontrol et
    if (!empty($_POST['service_id'])) {

        // 2. Değeri temizle ve boşsa hata ver
        $service_id = trim($_POST['service_id']);
        $service_id = htmlspecialchars($service_id, ENT_QUOTES, 'UTF-8');

        // 3. Sayısal bir ID mi diye kontrol et (ek güvenlik)


        // 4. Silme işlemini hazırla ve çalıştır
        $delete_service = $conn->prepare("DELETE FROM `services` WHERE id = ?");
        $delete_result = $delete_service->execute([$service_id]);

        if ($delete_result) {
            $success_msg[] = 'service delete successfully';
        } else {
            $error_msg[] = 'service does not delete';
        }
    } else {
        $error_msg[] = 'Servis ID bilgisi eksik';
    }
}

if (isset($_POST['toggle_status'])) {
    $service_id = htmlspecialchars($_POST['service_id'], ENT_QUOTES, 'UTF-8');

    // Servisin şu anki durumu nedir?
    $get_status = $conn->prepare("SELECT status FROM `services` WHERE id = ?");
    $get_status->execute([$service_id]);

    if ($get_status->rowCount() > 0) {
        $current_status = $get_status->fetch(PDO::FETCH_ASSOC)['status'];
        $new_status = ($current_status === 'active') ? 'deactive' : 'active';

        $update = $conn->prepare("UPDATE `services` SET status = ? WHERE id = ?");
        $update->execute([$new_status, $service_id]);

        $success_msg[] = "Service status changed to $new_status.";
    } else {
        $error_msg[] = 'Service not found.';
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
        <?php include '../components/admin_header.php'; ?>

        <section class="show-container">
            <div class="heading">
                <h1><img src="../uploaded_files/separator.png" alt="">Your Services<img src="../uploaded_files/separator.png" alt=""></h1>
            </div>
            <div class="box-container">
                <?php
                $select_services = $conn->prepare("SELECT * FROM `services`");
                $select_services->execute();

                if ($select_services->rowCount() > 0) {
                    while ($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)) {


                ?>
                        <div class="box">
                            <form action="" method="post" class="box">
                                <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                                <?php if ($fetch_services['image'] != '') {  ?>
                                    <img src="../uploaded_files/<?= $fetch_services['image']; ?>" class="image">

                                <?php
                                }

                                ?>
                                <div class="status" style="color: <?php if ($fetch_services['status'] == 'active') {
                                                                        echo "limegreen";
                                                                    } else {
                                                                        echo "red";
                                                                    } ?>;"><?= $fetch_services['status']; ?></div>
                                <p class="price"><?= $fetch_services['price']; ?>/-</p>
                                <div class="content">
                                    <div class="title">
                                        <?= $fetch_services['name']; ?>
                                    </div>
                                    <div class="flex-btn">
                                        <a href="edit_service.php?id=<?= $fetch_services['id']; ?>" class="btn">Edit</a>
                                        <button type="submit" name="delete" class="btn" onclick="return confirm('delete this service')">Delete</button>
                                        <a href="read_service.php?post_id=<?= $fetch_services['id']; ?>" class="btn">Read</a>
                                        <button type="submit" name="toggle_status" class="btn">
                                            <?= $fetch_services['status'] == 'active' ? 'Deactıve' : 'Actıve'; ?>
                                        </button>
                                    </div>


                                </div>
                            </form>
                        </div>
                <?php
                    }
                } else {
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