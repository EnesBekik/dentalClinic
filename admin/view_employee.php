<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
}

if(isset($_POST['delete'])){

    if(!empty($_POST['employee_id'])) {
        
        $employee_id = trim($_POST['employee_id']);
        $employee_id = htmlspecialchars($employee_id, ENT_QUOTES, 'UTF-8');

        $delete_employee = $conn->prepare("DELETE FROM `employee` WHERE id = ?");
        $delete_result = $delete_employee->execute([$employee_id]);
        
        if($delete_result) {
            $success_msg[] = 'employee delete successfully';
        } else {
            $error_msg[] = 'employee does not delete';
        }

    } else {
        $error_msg[] = 'employee ID bilgisi eksik';
    }
}
if(isset($_POST['toggle_status'])){

    if(isset($_POST['employee_id'])) {
        $employee_id = trim($_POST['employee_id']);
        $employee_id = htmlspecialchars($employee_id, ENT_QUOTES, 'UTF-8');

        // Mevcut durumu al
        $get_status = $conn->prepare("SELECT status FROM `employee` WHERE id = ?");
        $get_status->execute([$employee_id]);

        if ($get_status->rowCount() > 0) {
            $current_status = $get_status->fetch(PDO::FETCH_ASSOC)['status'];

            // Yeni durum belirleniyor
            $new_status = ($current_status == 'active') ? 'deactive' : 'active';

            // Güncelle
            $update_status = $conn->prepare("UPDATE `employee` SET status = ? WHERE id = ?");
            $update_result = $update_status->execute([$new_status, $employee_id]);

            if($update_result) {
                $success_msg[] = 'Employee status updated successfully.';
            } else {
                $error_msg[] = 'Failed to update employee status.';
            }
        } else {
            $error_msg[] = 'Employee not found.';
        }
    } else {
        $error_msg[] = 'Employee ID is missing.';
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
        <h1>
            <img src="../uploaded_files/separator.png" alt="">
            Your Employee
            <img src="../uploaded_files/separator.png" alt="">
        </h1>
    </div>

    <div class="box-container">
        <?php
        $select_employee = $conn->prepare("SELECT * FROM `employee`");
        $select_employee->execute();

        if ($select_employee->rowCount() > 0) {
            while ($fetch_employee = $select_employee->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="box">
            <form action="" method="post" class="box">
                <input type="hidden" name="employee_id" value="<?= $fetch_employee['id']; ?>">
                
                <?php if ($fetch_employee['profile'] != '') { ?>
                    <img src="../uploaded_files/<?= $fetch_employee['profile']; ?>" class="image">
                <?php } ?>
                
                <div class="status" style="color: <?php 
                    if ($fetch_employee['status'] == 'active') {
                        echo "limegreen";
                    } else {
                        echo "red";
                    } ?>">
                    <?= $fetch_employee['status']; ?>
                </div>

              

                <div class="content">
                    <div class="title">
                        <?= $fetch_employee['name'];?>
                    </div>
                    <h2>profession <span><?= $fetch_employee['profession']; ?></span></h2>

                    <div class="flex-btn">
                        <a href="edit_employee.php?id=<?= $fetch_employee['id'];?>" class="btn">Edit</a>
                        <button type="submit" name="delete" class="btn" onclick="confirm('delete this employee')">Delete</button>
                        <a href="read_employee.php?post_id=<?= $fetch_employee['id'];?>" class="btn">Read</a>
                        <!-- Yeni aktif/deaktif butonu -->
                        <button type="submit" name="toggle_status" class="btn" onclick="return confirm('Change status of this employee?')">
                        <?= ($fetch_employee['status'] == 'active') ? 'Deactivate' : 'Activate'; ?>
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
                <p>no employee added yet! <br> 
                <a href="add_employee.php" class="btn" style="margin-top:1rem;">add employee</a></p>
            </div> ';
        }
        ?>
    </div>
</section>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="../js/admin_script.js"></script>

<?php include '../components/alert.php'; ?>

</body>
</html>
