const etoiles = document.querySelectorAll('.etoiles');
const noteContainer = document.getElementById('noteContainer');
etoiles.forEach(etoile => {
    etoile.addEventListener('click' , () =>{
        noteContainer.innerHTML = '';
        index = [...etoiles].indexOf(etoile);
        
        const note = document.getElementById('note');
        note.value = index + 1 ;
        
        etoiles.forEach(star => {
            star.classList.remove('fa-solid');
            star.classList.add('fa-regular');
        });    
        
        for(i = 0 ; i <= index ; i ++ ){
            etoiles[i].classList.remove('fa-regular');
            etoiles[i].classList.add('fa-solid');
        }
        vueNote = document.createElement('p');
        vueNote.textContent = `${note.value}/5`;
        noteContainer.appendChild(vueNote);
    })
});

