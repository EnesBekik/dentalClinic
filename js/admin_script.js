const userBtn=document.querySelector('#user-btn');
userBtn.addEventListener('click',function(){
    const  userBox=document.querySelector('.profile-detail');
    userBox.classList.toggle('active');
})


const toggleBtn=document.querySelector('#toggle-btn');
toggleBtn.addEventListener('click',function(){
    const  sideBar=document.querySelector('.sidebar');
    sideBar.classList.toggle('active');
})

// Modal kısmına bir js 

// Butona tıklanırsa modal açılacak
document.querySelector('.view-image-btn').addEventListener('click', function() {
    var modal = document.getElementById("imageModal");
    var modalImage = document.getElementById("modalImage");
    var imgSrc = this.previousElementSibling.src;  // Küçük resmin kaynağını al
    modal.style.display = "block";  // Modal'ı aç
    modalImage.src = imgSrc; // Modalda resmi göster

    // Kapatma butonuna tıklanırsa modal kapanacak
    document.querySelector('.close-btn').addEventListener('click', function() {
        modal.style.display = "none";  // Modal'ı kapat
    });

    // Modal dışına tıklanırsa modal kapanacak
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = "none";  // Modal'ı kapat
        }
    });
});
