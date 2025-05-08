<header>
<div class="logo">
    <img src="../image/resimlogo.png" width="100" height="82" alt="">
</div>
<div class="right">
    <div class="fa-solid fa-user" id="user-btn"></div>
    <div id="toggle-btn" class="fa-solid fa-bars"></div>
</div>
<div class="profile-detail">
    <?php
    $select_profile=$conn->prepare("SELECT * FROM `admin` WHERE id=?");
    $select_profile->execute([$admin_id]);

    if($select_profile->rowCount()>0){
        $fetch_profile=$select_profile->fetch(PDO::FETCH_ASSOC);
    
    


    ?>
    <div class="profile">
        <img  src="../uploaded_files/<?=$fetch_profile['image'];?>"  class="logo-img">
        <p><?=$fetch_profile['name'];?></p>
    </div>
    <div class="flex-btn">
        <a href="profile.php" class="btn" >Profile</a>
        <a href="../components/admin_logout.php" onclick="return confirm('logout from this website');" class="btn" >logout</a>
    </div>
    <?php
    }
    ?>
</div>
</header>
<div class="side-container">
    <div class="sidebar">
    <?php
    $select_profile=$conn->prepare("SELECT * FROM `admin` WHERE id=?");
    $select_profile->execute([$admin_id]);

    if($select_profile->rowCount()>0){
        $fetch_profile=$select_profile->fetch(PDO::FETCH_ASSOC);
    
    


    ?>
    <div class="profile">
        <img src="../uploaded_files/<?=$fetch_profile['image'];?>" class="logo-img">
        <p><?=$fetch_profile['name'];?></p>
    </div>
   
    
    <?php
    }
    ?>
    <h5>Menu</h5>
    <div class="navbar">
        <ul>
            <li><a href="index.php"><i class="fa-solid fa-arrow-right"></i></i>Dashboard</a></li>
            <li><a href="add_service.php">  <i class="fa-solid fa-arrow-right"></i>add service</a></li>
            <li><a href="view_service.php"> <i class="fa-solid fa-arrow-right"></i>view service</a></li>
            <li><a href="add_employee.php"> <i class="fa-solid fa-arrow-right"></i>add employee</a></li>
            <li><a href="view_employee.php"><i class="fa-solid fa-arrow-right"></i>view employee</a></li>
            <li><a href="user_account.php"> <i class="fa-solid fa-arrow-right"></i>user account</a></li>
            <li><a href="../components/admin_logout.php" onclick="return confirm('logout from this wesite')"><i class="fa-solid fa-arrow-right"></i>logout</a></li>

        </ul>
    </div>
    </div>

</div>