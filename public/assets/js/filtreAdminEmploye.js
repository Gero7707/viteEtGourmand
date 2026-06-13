document.addEventListener('DOMContentLoaded', () =>{
    const type = document.getElementById('type');
    const cartesPlats = document.querySelectorAll('.carte-plat');

    function filtrerTypePlat(){
        let inputType = type.value;
        cartesPlats.forEach(carte =>{
            carte.style.display = "block";
            if( inputType !== '' && inputType !== carte.dataset.type){
                carte.style.display = "none";
            }
        })
    }
    type.addEventListener('change' , filtrerTypePlat);

});