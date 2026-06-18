document.addEventListener('DOMContentLoaded', () =>{

    // Filtre sur les types de plats
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
    if(type) {
        type.addEventListener('change', filtrerTypePlat);
    }


    //Filtres sur le staut des commandes
    const statut = document.getElementById('statut');
    const commandes = document.querySelectorAll('.ligne-commande');
    if(!statut  || !commandes)return;

    function filtrerStatutCommande(){
        let inputStatut = statut.value;
        commandes.forEach(commande =>{
            commande.style.display = "table-row";
            if(inputStatut !== '' && inputStatut !== commande.dataset.statut){
                commande.style.display = "none";
            }
        })
    }

    statut.addEventListener('change' , filtrerStatutCommande);
});