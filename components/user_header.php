<header class="header">
    <section class="flex">
        <a href="index.php" class="logo"><img src="image/resimlogo.png" width="130px" alt=""></a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="service.php">Services</a>
            <a href="team.php">Our Team</a>
            <a href="book_appointment.php">Appointment</a>
            <a href="contact.php">Contact</a>

        </nav>
        <form action="search_service.php" method="post" class="search-form">
            <input type="text" name="search_service" placeholder="search serivce..." required maxlength="100">
            <button type="submit" class="fa-solid fa-magnifying-glass" name="search_service_btn"></button>
        </form>
        <div class="icons">
            <div id="menu-btn" class="fa-solid fa-bars"></div>
            <div id="search-btn" class="fa-solid fa-magnifying-glass"></div>
            <div id="user-btn" class="fa-solid fa-user"></div>
            <div class="profile" style="background-image: none;">
                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id=?");
                $select_profile->execute([$user_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);


                ?>
                    <img src="/Dental%20Clinic/uploaded_files/<?= $fetch_profile['image']; ?>" alt="User Profile">
                    <h3 style="margin-bottom: 1rem;"><?= $fetch_profile['name']; ?></h3>
                    <div class="flex-btn">
                        <a href="profile.php" class="btn">view profile</a>
                        <a href="components/user_logout.php" class="btn" onclick="return confirm('logout from this website');">logout</a>

                    </div>
                <?php
                } else {


                ?>
                    <img src="image/örnek_kisi.png" alt="">
                    <h3 style="margin-bottom: 1rem;">please login or register</h3>
                    <div class="flex-btn">
                        <a href="login.php" class="btn">login</a>
                        <a href="register.php" class="btn">register</a>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </section>

</header>