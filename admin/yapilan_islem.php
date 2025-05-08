<?php
include '../components/connect.php';

if (isset($_POST['tooth_id'])) {
    $tooth_id = htmlspecialchars($_POST['tooth_id'], ENT_QUOTES, 'UTF-8');

    // Dişin işlem detayını al
    $get_process = $conn->prepare("SELECT * FROM islemler WHERE user_id = ? AND tooth_id = ? LIMIT 1");
    $get_process->execute([$user_id, $tooth_id]);
    $process = $get_process->fetch(PDO::FETCH_ASSOC);

    if ($process) {
        echo json_encode(['success' => true, 'detail' => $process['detail']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'İşlem bulunamadı']);
    }
}


if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
    exit;
}

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    header("location:appointments.php");
    exit;
}

$user_id = htmlspecialchars($_GET['user_id'], ENT_QUOTES, 'UTF-8');

if (isset($_POST['add_process'])) {
    $service_id = htmlspecialchars($_POST['service_id'], ENT_QUOTES, 'UTF-8');
    $process_detail = htmlspecialchars($_POST['process_detail'], ENT_QUOTES, 'UTF-8');
    $new_id = uniqid();

    // Get service name from services table
    $get_service = $conn->prepare("SELECT name FROM services WHERE id = ? LIMIT 1");
    $get_service->execute([$service_id]);
    $service = $get_service->fetch(PDO::FETCH_ASSOC);

    if ($service) {
        $full_detail = $service['name'] . ' - ' . $process_detail;
        // Resim yüklemeden önce kontrol et
        $image_name = '';
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $image_name = uniqid() . '_' . basename($image['name']);
            $image_tmp = $image['tmp_name'];
            $image_path = '../uploaded_files/' . $image_name;

            // Güvenlik için uzantı kontrolü yapılabilir
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_ext)) {
                if (move_uploaded_file($image_tmp, $image_path)) {
                    // Resim başarıyla yüklendi
                } else {
                    $error_msg[] = 'Resim yüklenirken bir hata oluştu.';
                    $image_name = '';
                }
            } else {
                $error_msg[] = 'Geçersiz dosya türü.';
                $image_name = '';
            }
        }

        // Resim yüklendiyse veritabanına kaydet
        $insert = $conn->prepare("INSERT INTO yapilan_islemler (id, user_id, detail, image) VALUES (?, ?, ?, ?)");
        $insert->execute([$new_id, $user_id, $full_detail, $image_name]);
        $success_msg[] = 'İşlem başarıyla eklendi.';
    } else {
        $error_msg[] = 'Seçilen servis bulunamadı.';
    }
}

$select_process = $conn->prepare("SELECT * FROM yapilan_islemler WHERE user_id = ? ORDER BY date DESC");
$select_process->execute([$user_id]);

$get_user = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$get_user->execute([$user_id]);
$user_data = $get_user->fetch(PDO::FETCH_ASSOC);

$select_services = $conn->prepare("SELECT * FROM services WHERE status = 'active'");
$select_services->execute();

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yapılan İşlemler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">
</head>

<body style="padding-left: 0;">

<div class="main-contaner">
    <?php include '../components/admin_header.php'; ?>

    <section class="appointment-container">
        <div class="heading">
            <h1><img src="../uploaded_files/separator.png" alt=""> <?= $user_data ? $user_data['name'] : 'Kullanıcı' ?> - Yapılan İşlemler <img src="../uploaded_files/separator.png" alt=""></h1>
        </div>

        <!-- İşlem ekleme formu -->
        <div class="box">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="box" style="display: flex; flex-direction: column; gap: 1rem;">
                 <div class="image_cene">

                 </div>
                  
                    
                  
                    
                    <div class="flex-btn" style="gap: 1rem; justify-content: center;">
                        <button type="submit" name="add_process" class="btn">İşlemi Kaydet</button>
                        <a href="admin_appointment.php" class="btn" style="margin-top: 1rem;">← Geri</a> 
                    </div>
                </div>
            </form>
        </div>

        <!-- Liste -->
        <div class="box-container">
            <?php if ($select_process->rowCount() > 0): ?>
                <?php while ($process = $select_process->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="box">
                        <p><strong>Tarih:</strong> <?= $process['date']; ?></p>
                        <p><strong>İşlem Detayı:</strong> <?= nl2br($process['detail']); ?></p>
                        <?php if (!empty($process['image'])): ?>
                            <div style="margin-top: 1rem;">
                                <img src="../uploaded_files/<?= $process['image'] ?>" width="100" style="border-radius:6px;">
                                <br>
                                <button onclick="openModal('../uploaded_files/<?= $process['image'] ?>')" class="view-image-btn">🔍 Resmi Görüntüle</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty">
                    <p>Bu kullanıcı için henüz işlem eklenmemiş.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Modal -->
<div id="imageModal" class="modal">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="">
</div>


<style>
    .modal {
    display: none;
    position: fixed;
    z-index: 99999;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background-color: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
}

.modal img {
    max-width: 90%; /* Resmi yatayda %90 genişliğe kadar büyüt */
    max-height: 80%; /* Resmi dikeyde %80 yüksekliğe kadar büyüt */
    border-radius: 12px;
    object-fit: contain; /* Resmin orijinal oranlarını korur ve boşluğu ortalar */
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 40px;
    font-size: 32px;
    color: #fff;
    cursor: pointer;
}

</style>



<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>

</body>
</html>
