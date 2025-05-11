<?php
// save_procedures.php
// This script receives dental procedure data and saves it to the database

// Database connection
$host = "localhost:3306"; // Update with your actual host:port
$user = "root";          // Update with your actual database username
$pass = "";             // Update with your actual database password
$dbname = "dental_db";  // Your database name from the SQL dump

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => "Connection failed: " . $conn->connect_error
    ]));
}

// Get POST data as JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['procedures']) || empty($data['procedures'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No procedure data received'
    ]);
    exit;
}

// Start transaction for multiple inserts
$conn->begin_transaction();

try {
    // Önce islem tablosuna yeni bir işlem kaydı oluştur
    // Böylece tüm dişler aynı işlem ID'sini kullanacak
    $currentDate = date('Y-m-d H:i:s');
    $userId = $data['procedures'][0]['user_id']; // İlk kayıttaki kullanıcı ID'sini al
    
    // islem tablosuna kayıt ekle
    $islemStmt = $conn->prepare("INSERT INTO islem (user_id, islem_tarihi) VALUES (?, ?)");
    
    if (!$islemStmt) {
        throw new Exception("İşlem prepared statement hatası: " . $conn->error);
    }
    
    $islemStmt->bind_param("ss", $userId, $currentDate);
    
    if (!$islemStmt->execute()) {
        throw new Exception("İşlem kaydı hatası: " . $islemStmt->error);
    }
    
    // Eklenen işlemin ID'sini al
    $islemId = $conn->insert_id;
    $islemStmt->close();
    
    // Şimdi yapilan_islem tablosuna dişleri ekleyelim
    $stmt = $conn->prepare("INSERT INTO yapilan_islem (islem_id, user_id, dis_id, yapilan_islem, doktor_ad, islem_tarihi, ucret) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Check if prepared statement was created
    if (!$stmt) {
        throw new Exception("Prepared statement error: " . $conn->error);
    }
    
    $success = true;
    $errorMessage = '';
    
    foreach ($data['procedures'] as $procedure) {
        // Bind parameters and execute
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
            $success = false;
            $errorMessage = $stmt->error;
            break;
        }
    }
    
    if ($success) {
        // If all inserts were successful, commit transaction
        $conn->commit();
        echo json_encode([
            'success' => true,
            'message' => 'All procedures saved successfully',
            'islem_id' => $islemId
        ]);
    } else {
        // If any insert failed, rollback the transaction
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Error saving procedures: ' . $errorMessage
        ]);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    // If an exception occurred, rollback the transaction
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage()
    ]);
}

$conn->close();
?>