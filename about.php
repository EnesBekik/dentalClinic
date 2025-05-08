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




   <div class="banner">
    <div class="detail">
        <h1>about us</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus ut vel <br>
         repudiandae vero sed deleniti accusantium eligendi, placeat mollitia vitae!</p>
         <span><a href="index.php">home</a><i class="fa-solid fa-right-long"></i>about us</span>
    </div>
   </div>

   <div class="about">
    <div class="box-container">
        <div class="box">
            <span>about denticare</span>
            <h2>Where Expertise Meets Compassion Your Journey to Optimal Oral Health</h2>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae facere molestias adipisci eveniet eius at
                 dolore ut omnis consequuntur, a repellat veritatis veniam quo id, earum, ipsam quasi voluptates 
                 nam ratione itaque nobis!</p>
                 <p>Officiis sint expedita, alias nisi sequi blanditiis et molestiae tempora! 
                 Vitae quos excepturi culpa adipisci libero. Provident eos accusantium 
                 sint tempore et sapiente fuga eligendi rem ducimus!</p>
        </div>
        <div class="box">
            <img src="image/about.avif" alt="">
        </div>
    </div>
   </div>

   <div class="event">
    <div class="heading">
        <h1>the <span>dental & oral health</span>submit</h1>
        <p>innovative ideas in dentistry</p>
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/about.png" alt="">
        </div>
        <div class="box">
            <h2>Dental health current resarch </h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Animi unde saepe in, facere cupiditate 
                ea earum molestias assumenda corporis consequuntur? Deserunt ad a reprehenderit repudiandae porro dignissimos 
                quaerat accusantium nemo aspernatur repellat voluptatem totam, ratione architecto ipsam doloribus
                 modi placeat aliquid sunt possimus ullam. Iure a, velit soluta minima cupiditate, totam unde, inventore quam 
                 numquam in vitae nobis laborum beatae molestias fuga! Totam voluptatum quos possimus?</p>
        </div>
    </div>
    <div class="box-container">
        
        <div class="box">
            <h2>oral hygine - the role of moutwash</h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Animi unde saepe in, facere cupiditate 
                ea earum molestias assumenda corporis consequuntur? Deserunt ad a reprehenderit repudiandae porro dignissimos 
                quaerat accusantium nemo aspernatur repellat voluptatem totam, ratione architecto ipsam doloribus
                 modi placeat aliquid sunt possimus ullam. Iure a, velit soluta minima cupiditate, totam unde, inventore quam 
                 numquam in vitae nobis laborum beatae molestias fuga! Totam voluptatum quos possimus?</p>
        </div>
        <div class="box">
            <img src="image/about0.png" alt="">
        </div>
    </div>
   </div>

   <div class="role">
    <div class="box-container">
        <div class="box">
            <h1>The Role of Dental Implants</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque impedit
                fugit quisquam natus eveniet, aut enim repellendus pariatur quod,
                iusto unde voluptates fuga, officiis repudiandae ad illum itaque eius tempore!
                Libero nemo adipisci accusamus, odit, aspernatur quam quae 
                obcaecati ea facilis blanditiis maxime atque dolorum nihil molestias.
                Voluptates autem necessitatibus, optio ut fugit dolores ex. Dicta natus,
                umque suscipit libero beatae rem nostrum iste eveniet optio modi blanditiis
                perferendis vitae molestiae odio laudantium dolore, doloremque magni dolor.</p>
        </div>
        <div class="box">
            <img src="image/about1.jpg" alt="">

        </div>
    </div>

    <div class="box-container">
    <div class="box">
            <img src="image/about2.jpg" alt="">

        </div>
        <div class="box">
            <h1>Dental Implant in Dentistry </h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque impedit
                fugit quisquam natus eveniet, aut enim repellendus pariatur quod,
                iusto unde voluptates fuga, officiis repudiandae ad illum itaque eius tempore!
                Libero nemo adipisci accusamus, odit, aspernatur quam quae 
                obcaecati ea facilis blanditiis maxime atque dolorum nihil molestias.
                Voluptates autem necessitatibus, optio ut fugit dolores ex. Dicta natus,
                umque suscipit libero beatae rem nostrum iste eveniet optio modi blanditiis
                perferendis vitae molestiae odio laudantium dolore, doloremque magni dolor.</p>
        </div>
       
    </div>
   </div>



   <div class="skill-container">
    <div class="heading">
        <span>oun dental sevices</span>
        <h1>in numbers</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel earum vitae, dolorum ipsa <br> 
            voluptatum nobis dignissimos cupiditate eveniet iusto doloribus voluptas dolor pariatur.
        </p>
    </div>
    <div class="container">
    <!-- progress bar  start -->
        <div class="progress-bar">
            <div class="progress">
                <span class="title timer" data-form="0" data-to="99" data-speed="1800"><img src="image/counter (1).png" alt=""></span>
                <div class="overlay"></div>
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <h1>99%</h1>
            <h4>client satisfaction</h4>
        </div>
    <!-- progress bar end -->

     <!-- progress bar  start -->
     <div class="progress-bar">
            <div class="progress">
                <span class="title timer" data-form="0" data-to="70" data-speed="1500"><img src="image/icon (7).png" alt=""></span>
                <div class="overlay"></div>
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <h1>97%</h1>
            <h4>intervention success</h4>
        </div>
    <!-- progress bar end -->

     <!-- progress bar  start -->
     <div class="progress-bar">
            <div class="progress">
                <span class="title timer" data-form="0" data-to="100" data-speed="1500"><img src="image/counter (3).png" alt=""></span>
                <div class="overlay"></div>
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <h1>100%</h1>
            <h4>happy with staff</h4>
        </div>
    <!-- progress bar end -->

     <!-- progress bar  start -->
     <div class="progress-bar">
            <div class="progress">
                <span class="title timer" data-form="0" data-to="85" data-speed="1800"><img src="image/counter (2).png" alt=""></span>
                <div class="overlay"></div>
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <h1>97%</h1>
            <h4>quick recovery</h4>
        </div>
    <!-- progress bar end -->

    </div>
   </div>

<div class="testimonial-container">
    <div class="heading">
        <span>clients with</span>
        <h1>reason to smile</h1>
        <div class="container">
            <div class="testimonial-item active">
                <i class="fa-solid fa-quote-right" id="quote"></i>
                <img src="image/h1-img-team-single-2.jpg">
                <h1>Fatih Bozoğlu</h1>
                Lorem ipsum dolor, sit amet  consectetur adipisicing elit.
                Mollitia a tempora natus iste quod eos dolores nobis, 
                deleniti aliquam accusantium! Repellat odit voluptatum minus
                suscipit ullam. Explicabo pariatur veritatis assumenda? Officia,
                explicabo reiciendis laudantium in esse dolorum illo nemo.
                Facilis eum minima impedit. Soluta aspernatur quas architecto ratione
            </div>

            <div class="testimonial-item ">
                <i class="fa-solid fa-quote-right" id="quote"></i>
                <img src="image/h1-img-team-single-4.jpg">
                <h1>Muhammed Eren</h1>
                Lorem ipsum dolor, sit amet  consectetur adipisicing elit.
                Mollitia a tempora natus iste quod eos dolores nobis, 
                deleniti aliquam accusantium! Repellat odit voluptatum minus
                suscipit ullam. Explicabo pariatur veritatis assumenda? Officia,
                explicabo reiciendis laudantium in esse dolorum illo nemo.
                Facilis eum minima impedit. Soluta aspernatur quas architecto ratione
            </div>

            <div class="testimonial-item ">
                <i class="fa-solid fa-quote-right" id="quote"></i>
                <img src="image/hero-img.png">
                <h1>Sedat Tokuss</h1>
                Lorem ipsum dolor, sit amet  consectetur adipisicing elit.
                Mollitia a tempora natus iste quod eos dolores nobis, 
                deleniti aliquam accusantium! Repellat odit voluptatum minus
                suscipit ullam. Explicabo pariatur veritatis assumenda? Officia,
                explicabo reiciendis laudantium in esse dolorum illo nemo.
                Facilis eum minima impedit. Soluta aspernatur quas architecto ratione
            </div>

            <div class="left-arrow" onclick="rightSlide()"><i class="fa-solid fa-left-long"></i></div>
            <div class="right-arrow" onclick="leftSlide()"><i class="fa-solid fa-right-long"></i></div>



        </div>
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