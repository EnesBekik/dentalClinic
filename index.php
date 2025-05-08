<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
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

    <!-- home slider start -->

    <div class="slider-container">
        <div class="slide">
            <!-- slide start-->
            <div class="slideBox active">
                <div class="textBox">
                    <span>commited to exellence</span>
                    <h1>personallizes and <br> comfortable</h1>
                    <div class="card">
                        <div class="box">
                            <div><img src="image/icon (11).png" alt=""></div>
                            <div>
                                <h2>full protection</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio nostrum, architecto obcaecati aliquam quis. 
                                    Temporibus ratione vitae quis mollitia.</p>
                            </div>
                        </div>
                        <div class="box">
                            <div><img src="image/icon (12).png" alt=""></div>
                            <div>
                                <h2>complete service </h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio .
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-btn">
                        <a href="service.php" class="btn" >view our service</a>
                        <a href="service.php" class="btn" >book appointment</a>
                        
                    </div>

                </div>
            </div>
             <!-- slide end -->

               <!-- slide start-->
            <div class="slideBox">
                <div class="textBox">
                    <span>commited to exellence</span>
                    <h1>personallizes and <br> comfortable</h1>
                    <div class="card">
                        <div class="box">
                            <div><img src="image/icon (4).png" alt=""></div>
                            <div>
                                <h2>full protection</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio nostrum, architecto obcaecati aliquam quis. 
                                    Temporibus ratione vitae quis mollitia.</p>
                            </div>
                        </div>
                        <div class="box">
                            <div><img src="image/icon (5).png" alt=""></div>
                            <div>
                                <h2>complete service </h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio .
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-btn">
                        <a href="service.php" class="btn" >view our service</a>
                        <a href="service.php" class="btn" >book appointment</a>
                        
                    </div>

                </div>
            </div>
             <!-- slide end -->
                <!-- slide start-->
            <div class="slideBox">
                <div class="textBox">
                    <span>commited to exellence</span>
                    <h1>personallizes and <br> comfortable</h1>
                    <div class="card">
                        <div class="box">
                            <div><img src="image/icon (1).png" alt=""></div>
                            <div>
                                <h2>full protection</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio nostrum, architecto obcaecati aliquam quis. 
                                    Temporibus ratione vitae quis mollitia.</p>
                            </div>
                        </div>
                        <div class="box">
                            <div><img src="image/icon (2).png" alt=""></div>
                            <div>
                                <h2>complete service </h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                     Optio odio .
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-btn">
                        <a href="service.php" class="btn" >view our service</a>
                        <a href="service.php" class="btn" >book appointment</a>
                        
                    </div>

                </div>
            </div>
             <!-- slide end -->
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"><i class="fa-solid fa-right-long"></i></li>
            <li onclick="prevSlide();" class="prev"><i class="fa-solid fa-left-long"></i></li>

        </ul>
    </div>



    <!-- home slider end -->

    <div class="about-us">
        <div class="box-container">
            <div class="box">
                <div class="container">
                    <div class="card">
                        <img src="image/ab-icon.png" alt="">
                        <h2>easy booking</h2>
                        <p>Get an appointment in a few clicks</p>
                    </div>
                    <div class="card">
                        <img src="image/ab-icon0.png" alt="">
                        <h2>easy booking</h2>
                        <p>Get an appointment in a few clicks</p>
                    </div>
                    <div class="card">
                        <img src="image/ab-icon1.png" alt="">
                        <h2>easy booking</h2>
                        <p>Get an appointment in a few clicks</p>
                    </div>
                    <div class="card">
                        <img src="image/ab-icon2.png" alt="">
                        <h2>easy booking</h2>
                        <p>Get an appointment in a few clicks</p>
                    </div>
                </div>
            </div>
            <div class="box">
                <h1>about or clinic</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit,  dicta esse minima unde nihil nostrum doloribus .
                    dicta esse minima unde nihil nostrum doloribus .
                </p>
                <div class="box-card">
                   <img src="image/about-us.jpg" alt="">
                   <div class="detail">
                    <h2>Dr.Baran Bozo</h2>
                    <span>Head Doctor,Orthodontist</span>
                    <p>I am aa dedicated specialist with 20 years of experience trained in 
                        diagnosing and treating othodontal and periodontal issues.
                    </p>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relax-container">
        <div class="detail">
            <h1>Relax...your Dentist Knows Best</h1>
            <div class="box">
                <div class="img-box">
                    <img src="image/icon (8).png" alt="">
                </div>
                <div>
                    <h2>dental hygine never forget!</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque libero vitae modi quod. 
                    Cumque libero vitae modi quod.</p>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/icon (9).png" alt="">
                </div>
                <div>
                    <h2>Don't rush when you brush </h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque libero vitae modi quod. 
                    Cumque libero vitae modi quod.</p>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/icon (10).png" alt="">
                </div>
                <div>
                    <h2>visit your dentist once in 6 months</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque libero vitae modi quod. 
                    Cumque libero vitae modi quod.</p>
                </div>
            </div>
            
        </div>
    </div>

    <div class="kids">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <h1>kids oral care</h1>
                    <p>Efficiently enabled sources and cost effective products.Complety
                        synthesize principle-centered information.
                    </p>
                </div>
                <div class="box-card">
                    <div class="card">
                        <img src="image/dental.png" alt="">
                        <h2>brushing</h2>
                        <p>Dynamically target high payoff capital for technologies</p>
                    </div>
                    <div class="card">
                        <img src="image/nutrition.png" alt="">
                        <h2>nutrition</h2>
                        <p>Dynamically target high payoff capital for technologies</p>
                    </div>
                    <div class="card">
                        <img src="image/ab-icon2.png" alt="">
                        <h2>checkup</h2>
                        <p>Dynamically target high payoff capital for technologies</p>
                    </div>
                </div>
            </div>
            <img src="image/kid.png" class="img" alt="">
            
        </div>
    </div>

    <div class="service">
        <div class="box-container">
            <div class="box">
                <div><img src="image/contact-icon (4).png" alt=""></div>
                <div class="detail">
                    <h1>general Dentistry</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon2.png" alt=""></div>
                <div class="detail">
                    <h1>Dental filling</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon6.png" alt=""></div>
                <div class="detail">
                    <h1>Dental implants</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon.png" alt=""></div>
                <div class="detail">
                    <h1>Dental surgeru</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon0.png" alt=""></div>
                <div class="detail">
                    <h1>Dental alignment</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon5.png" alt=""></div>
                <div class="detail">
                    <h1>Dental whitening</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon1.png" alt=""></div>
                <div class="detail">
                    <h1>teeth braces</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon4.png" alt=""></div>
                <div class="detail">
                    <h1>teeth protection</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>

            <div class="box">
                <div><img src="image/service-icon3.png" alt=""></div>
                <div class="detail">
                    <h1>prothesis</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="care-container">
        <div class="detail">
            <h1>take care of your teeeth & gums </h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Cumque libero vitae modi quod.
            </p>
            <p><i class="fa-regular fa-circle"></i>Anean posuere sem imprediet</p>
            <p><i class="fa-regular fa-circle"></i>Lorem ipsum dolor sit amet.</p>
            <p><i class="fa-regular fa-circle"></i>Lorem, ipsum dolor.</p>
            <p><i class="fa-regular fa-circle"></i>Lorem ipsum dolor sit amet.</p>
            <p><i class="fa-regular fa-circle"></i>Lorem ipsum dolor sit.</p>
            <p><i class="fa-regular fa-circle"></i>Anean posuere sem imprediet, viverra quam</p>

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