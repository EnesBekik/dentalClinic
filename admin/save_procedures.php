<?php
// save_procedures.php
// Bu script birden fazla hastanın işlemlerini ayrı ayrı kaydeder.

// Database connection
$host = "localhost:3306";
$user = "root";
$pass = "";
$dbname = "dental_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => "Connection failed: " . $conn->connect_error
    ]));
}

// Get POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

file_put_contents("debug.json", json_encode($data, JSON_PRETTY_PRINT));


if (!isset($data['procedures']) || empty($data['procedures'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No procedure data received'
    ]);
    exit;
}

// Hastalara göre grupla
$proceduresByUser = [];

foreach ($data['procedures'] as $procedure) {
    $userId = $procedure['user_id'];
    if (!isset($proceduresByUser[$userId])) {
        $proceduresByUser[$userId] = [];
    }
    $proceduresByUser[$userId][] = $procedure;
}

// İşlemleri kayıt et
$conn->begin_transaction();

try {
    foreach ($proceduresByUser as $userId => $userProcedures) {
        $currentDate = date('Y-m-d H:i:s');

        // islem tablosuna ekle
        $islemStmt = $conn->prepare("INSERT INTO islem (user_id, islem_tarihi) VALUES (?, ?)");
        if (!$islemStmt) throw new Exception("İşlem prepare hatası: " . $conn->error);

        $islemStmt->bind_param("ss", $userId, $currentDate);
        if (!$islemStmt->execute()) throw new Exception("İşlem insert hatası: " . $islemStmt->error);

        $islemId = $conn->insert_id;
        $islemStmt->close();

        // yapilan_islem tablosuna işlemleri ekle
        $stmt = $conn->prepare("INSERT INTO yapilan_islem (islem_id, user_id, dis_id, yapilan_islem, doktor_ad, islem_tarihi, ucret)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) throw new Exception("yapilan_islem prepare hatası: " . $conn->error);

        foreach ($userProcedures as $procedure) {
            $stmt->bind_param(
                "isssssd",
                $islemId,
                $procedure['user_id'],
                $procedure['dis_id'],
                $procedure['yapilan_islem'],
                $procedure['doktor_ad'],
                $procedure['islem_tarihi'],
                $procedure['ucret']
            );

            if (!$stmt->execute()) {
                throw new Exception("Yapılan işlem insert hatası: " . $stmt->error);
            }
        }

        $stmt->close();
    }

    $conn->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Tüm işlemler başarıyla kaydedildi.'
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Hata: ' . $e->getMessage()
    ]);
}

$conn->close();
