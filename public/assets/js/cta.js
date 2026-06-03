document.addEventListener('DOMContentLoaded', () =>{
    const showUpload = document.getElementById('btn-showUpload');
    const fileUpload =document.getElementById('img_menu');
    fileUpload.style.display = 'none' ;
    showUpload.addEventListener('click' , (e) =>{
        fileUpload.style.display = 'block' ;
    })
});