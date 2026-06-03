document.addEventListener('DOMContentLoaded', () =>{
    const showUploadMenu = document.getElementById('btn-showUpload-menu');
    if(showUploadMenu){
        const fileUploadMenu = document.getElementById('img_menu');
        fileUploadMenu.style.display = 'none';
        showUploadMenu.addEventListener('click', () => {
            fileUploadMenu.style.display = 'block';
        });
    }

    const showUploadPlat = document.getElementById('btn-showUpload-plat');
    if(showUploadPlat){
        const fileUploadPlat = document.getElementById('chemin_photo');
        fileUploadPlat.style.display = 'none';
        showUploadPlat.addEventListener('click', () => {
            fileUploadPlat.style.display = 'block';
        });
    }
});