document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('graphiqueCommandes');
    const commandesParMenu = JSON.parse(canvas.dataset.commandes);
    const labels = commandesParMenu.map(item => item._id);
    const data   = commandesParMenu.map(item => item.total);

    const ctx = document.getElementById('graphiqueCommandes');
    const estMobile = window.innerWidth < 768;
    new Chart(canvas, {
        type: 'bar',                    // type de graphique : barres
        data: {
            labels: labels,             // noms des menus
            datasets: [{
                label: 'Nombre de commandes',
                data: data,             // valeurs
                backgroundColor: '#1565C0' , // couleur de tes barres
                hoverBackgroundColor:'#2A3F6A'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: estMobile ? 'y' : 'x',
            scales: {
                y: {
                    ticks: {
                        autoSkip: false
                    }
                }
            }
        }
    });


    const formulaire = document.getElementById('formulaire-ca');
    const filtreMenu = document.getElementById('filtre-menu');
    const filtreMois = document.getElementById('filtre-mois');
    const tbody = document.getElementById('tbody-ca');
    const lienReset = document.querySelector('.lien-reset');
    const errorMessage = document.querySelector('.error-message');
    const filtreCa = document.querySelector('.filtre-ca');

    errorMessage.style.display = "none";

    async function chargerData(){
        const menu = filtreMenu.value;
        const mois = filtreMois.value;
        // Construit l'URL avec les paramètres GET
        const url = `/admin/stats-ca?menu=${encodeURIComponent(menu)}&mois=${encodeURIComponent(mois)}`;

        const response = await fetch(url);
        const data = await response.json();
        //vide le tableau 
        tbody.innerHTML = '';
        //rempli le tabelau avec les données
        data.forEach(ligne => {
            tbody.innerHTML += `
                <tr>
                    <td>${ligne.menu}</td>
                    <td>${ligne.ca.toFixed(2).replace('.', ',')} €</td>
                </tr>
            `;
        });
    }
    chargerData();
    filtreCa.addEventListener('click',(e) => {
        e.preventDefault(); 
        errorMessage.style.display = "none";
        const mois = filtreMois.value;
        if(mois.trim() === ''){
            errorMessage.style.display = "block";
            errorMessage.textContent = "Veillez remplir les champs du formulaire .";
            return;
        }
        
        chargerData();
    });


    lienReset.addEventListener('click', (e) => {
        e.preventDefault();
        filtreMenu.value = '';
        filtreMois.value = '';
        errorMessage.style.display = "none";
        chargerData();
    });

});