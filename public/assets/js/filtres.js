document.addEventListener('DOMContentLoaded', () =>{
    const carteContainer = document.getElementById('carteContainer');

    if(!carteContainer){
        return;
    }
    


    const openFiltres = document.querySelector('.open-filtres');
    const slider = document.querySelector('.section-filtres');
    const closeFiltres = document.getElementById('close-filtres');
    if(!openFiltres || !closeFiltres) return;
    
    const btnFiltre = document.querySelectorAll('.btn-filtre');
    const btnInitFiltres = document.getElementById('init-filtres');
    const prixMax = document.getElementById('prixMax');
    const theme = document.getElementById('theme');
    const regime = document.getElementById('regime');
    const nbPersonne = document.getElementById('nombre');
    const messageBouton = document.getElementById('messageBouton');
    const messageInput = document.getElementById('messageInput');
    const cartes = document.querySelectorAll('.carte-menu');
    const messageFiltre = document.getElementById('messageFiltre');

    const modalAllergenes =document.querySelector('.modal-allergenes');

    cartes.forEach(carte =>{
        carte.querySelector('.liste-allergene').addEventListener('mouseenter' , async ()=>{
            menuId = carte.dataset.menuId;
            try{
                const response = await fetch('/fetch/menu-allergene/' + menuId)
                const data = await response.json();
                carte.querySelector('.modal-allergenes').textContent = data.map(allergene => allergene.libelle).join(', ');
            }catch(error){
                carte.querySelector('.modal-allergenes').textContent = "Allergènes non disponibles.";
            }
        })
    })

    openFiltres.addEventListener('click' , () =>{
        slider.classList.toggle('open');
    });

    closeFiltres.addEventListener('click' , () =>{
        slider.classList.toggle('open')
    })


    let fourchette = { min: null, max: null };

    function filtrer(){
        let inputPrix = prixMax.value.trim();
        let inputTheme = theme.value;
        let inputRegime = regime.value;
        let inputNombre = nbPersonne.value.trim();
        let compteur = 0;

        messageFiltre.textContent = "";
        cartes.forEach(carte  =>{
            carte.classList.remove('d-none');
            
            if(inputPrix !== '' && parseFloat(inputPrix) < parseFloat(carte.dataset.prix)){
                carte.classList.add('d-none');
            }

            if(inputRegime !== '' && inputRegime !== carte.dataset.regime){
                carte.classList.add('d-none');
            }

            if( inputTheme !== '' && inputTheme !== carte.dataset.theme){
                carte.classList.add('d-none');
            }
            if( inputNombre !== '' && parseFloat(inputNombre) < parseFloat(carte.dataset.nombre)){
                carte.classList.add('d-none');
            }

            if(fourchette.min !== null && (parseFloat(carte.dataset.prix) < parseFloat(fourchette.min) ||  parseFloat(carte.dataset.prix) > parseFloat(fourchette.max))){
                carte.classList.add('d-none');
                
            }

            if(!carte.classList.contains('d-none')){
                compteur ++;
            }

            
        });
        if(compteur === 0){
            messageFiltre.textContent = "Aucun menu ne correspond à ces critères .";
            messageFiltre.style.color = '#fafafa';
        }
    }

    let timerPrix;
    prixMax.addEventListener('input', () => {
        messageBouton.textContent = "Pour choisir une fourchette de prix veuillez réinitialiser les filtres"
        messageBouton.style.color = '#C62828';
        messageBouton.style.backgroundColor = '#d3a9a9';
        fourchette.min = null;
        fourchette.max = null;
        btnFiltre.forEach(btn =>{
            btn.disabled = true
        })
        clearTimeout(timerPrix);
        timerPrix = setTimeout(() => {
            filtrer();
        }, 1000);
    });

    let timerNombre;
    nbPersonne.addEventListener('input' , () =>{
        clearTimeout(timerNombre);
        timerNombre = setTimeout(() =>{
            filtrer();
        }, 1000)
    })
    theme.addEventListener('change' , filtrer);
    regime.addEventListener('change' , filtrer);
    

    btnInitFiltres.addEventListener('click' , () =>{
        messageFiltre.textContent = '';
        messageBouton.style.backgroundColor = '';
        messageInput.style.backgroundColor = '';
        messageInput.textContent = '';
        messageBouton.textContent = '';
        btnFiltre.forEach(btn =>{
            btn.disabled = false;
        })
        prixMax.disabled = false ;
        prixMax.value = '';
        theme.value = '';
        regime.value = '';
        nbPersonne.value = '';
        fourchette.min = null;
        fourchette.max = null;
        filtrer();
    })

    btnFiltre.forEach(btn =>{
        
        btn.addEventListener('click' , (e) =>{
            messageInput.textContent = "Pour entrer un prix max veuillez réinitialiser les filtres " 
            messageInput.style.color = '#C62828';
            messageInput.style.backgroundColor = '#d3a9a9';
            prixMax.disabled = true;
            fourchette.min = btn.dataset.min;
            fourchette.max = btn.dataset.max;
            filtrer();
        })
    })
});