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
        const statutsMasquesParDefaut = ['terminee', 'annulee'];
        commandes.forEach(commande =>{
            commande.style.display = "table-row";
            if(inputStatut === 'actives'){
                if(statutsMasquesParDefaut.includes(commande.dataset.statut)){
                    commande.style.display = "none";
                }
            }else if(inputStatut !== ''){
                if(inputStatut !== commande.dataset.statut){
                commande.style.display = "none";
                }
            }
        })
    }
    filtrerStatutCommande();
    statut.addEventListener('change' , filtrerStatutCommande);


    const formulairesStatut = document.querySelectorAll('.form-changer-statut');
    const successMessage = document.querySelector('.success-message');
    successMessage.style.display = "none";
    async function afficher(form) {
        successMessage.style.display = "none";
        const url = form.action;
        const formData = new FormData(form);
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        });
        const data = await response.json();
        // data contient { success: true, nouveauStatut: 'acceptee' }
        const tr = form.closest('tr');
        const celluleStatut = tr.querySelector('.statut-commande');
        const statutLabels = {
            'en_attente': 'En attente',
            'en_preparation': 'En préparation',
            'en_livraison': 'En livraison',
            'attente_retour_materiel': 'Attente retour matériel',
            'terminee': 'Terminée',
            'acceptee': 'Acceptée',
            'annulee': 'Annulée',
            'livree': 'Livrée'
        };

        celluleStatut.textContent = statutLabels[data.nouveauStatut];
        successMessage.style.display = "block";
        successMessage.textContent = `Le statut de la commande numéro  ${data.numeroCommande} est : ${statutLabels[data.nouveauStatut]} `
        if(data.nouveauStatut === 'terminee' || data.nouveauStatut === 'annulee') {
            form.remove();
        }
    }

    formulairesStatut.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            afficher(form);
        });
    });
});