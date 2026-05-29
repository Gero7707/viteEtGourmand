document.addEventListener('DOMContentLoaded', () =>{
    const btnCalculerPrix = document.getElementById('calcul_frais');
    const adresse = document.getElementById('adresse');
    const codePostal = document.getElementById('code_postal');
    const ville = document.getElementById('ville');
    const gsm = document.getElementById('gsm');
    const nbPersonne = document.getElementById('nombre_personne');
    const datePrestation = document.getElementById('date_prestation');
    const heureLivraison = document.getElementById('heure_livraison');
    const fraisDiv = document.getElementById('resultatCalculFrais');
    const errorMessage = document.getElementById("errorMessage");
    const menuId = document.getElementById("menu_id");
    const btnValider = document.getElementById("btnValider");


    btnCalculerPrix.addEventListener('click' , async () =>{
        if(!adresse.value || !codePostal.value || !ville.value || !gsm.value || !nbPersonne.value || !datePrestation.value || !heureLivraison.value){
            errorMessage.textContent = "Veuillez remplir tous les champs ! ";
            return;
        }
        if(parseInt(nbPersonne.value) < 0){
            errorMessage.textContent = "Vous ne pouvez pas entrer un nombre négatif";
            return;
        }

        try {
            btnCalculerPrix.disabled = true;
            const response = await fetch('/commandes/calcul-frais', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    menu_id: menuId.value,
                    adresse: adresse.value,
                    code_postal: codePostal.value,
                    ville: ville.value,
                    nombre_personne: nbPersonne.value
                })
            });
            const data = await response.json();
            
            if(data.success) {
                btnValider.disabled = false;
                fraisDiv.innerHTML = '';
                const prixTotal = document.createElement('p');
                prixTotal.textContent = `Prix total : ${data.prix_total.toFixed(2)} euros`;
                fraisDiv.appendChild(prixTotal);
                const fraisLivraison = document.createElement('p');
                fraisLivraison.textContent =`Frais de livraison : ${data.frais_livraison.toFixed(2)} euros` ;
                fraisDiv.appendChild(fraisLivraison);
            } else {
                fraisDiv.innerHTML = '';
                const message = document.createElement('p');
                message.textContent = data.message ;
                fraisDiv.appendChild(message);
            }
        } catch(error) {
            errorMessage.textContent = "Une erreur est survenue, veuillez réessayer.";
        }
        finally{
            btnCalculerPrix.disabled = false;
        }
    })
});