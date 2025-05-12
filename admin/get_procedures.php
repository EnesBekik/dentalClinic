<?php
header('Content-Type: application/json');


$host = "localhost";
$port = "3306";
$dbname = "dental_db";
$user = "root";
$pass = "";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);

    // Hataları yakalayıp istisna fırlatması için ayar
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // JSON olarak hata mesajı döner
    die(json_encode([
        'success' => false,
        'message' => "Bağlantı hatası: " . $e->getMessage()
    ]));
}



try {
    // Kullanıcının ID'sini al (örnek olarak URL parametresinden)
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id <= 0) {
        echo json_encode(["success" => false, "message" => "Geçersiz kullanıcı ID."]);
        exit;
    }

    // SQL sorgusu: user_id eşleşen işlemleri çek
    $stmt = $conn->prepare("
        SELECT yi.*, u.ad_soyad 
        FROM yapilan_islem yi
        JOIN users u ON yi.user_id = u.id
        WHERE yi.user_id = :user_id
        ORDER BY yi.islem_tarihi DESC
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $veriler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $veriler]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Hata: " . $e->getMessage()]);
}
?>
