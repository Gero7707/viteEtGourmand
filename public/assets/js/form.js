window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        window.location.reload();
    }
});


const forms = document.querySelectorAll('.validate-form');

forms.forEach(form =>{
    const errorMessage = form.querySelector('.error-message') || document.querySelector('.error-message');
    const successMessage = form.querySelector('.success-message') || document.querySelector('.success-message');
    const inputs = form.querySelectorAll('input , select , textarea ,input[type="checkbox"] ');
    form.addEventListener('submit' , (e) =>{
        let isValid = true;
        inputs.forEach(input =>{
            if(input.type === 'file') return;
            if(!input.value.trim()){
            isValid = false ;
            input.style.border = '1px solid #C62828';
            input.style.background = '#eeb7b7';
        }
        })
        if(!isValid){
            e.preventDefault();
            errorMessage.style.display = 'block';
            errorMessage.textContent = "Veuillez remplir tous les champs du formulaire ."
        }
    });
});



const btnPassword = document.querySelectorAll('.btn-password');

btnPassword.forEach(btn =>{
    btn.addEventListener('click' , () =>{
        const input = document.getElementById(btn.dataset.target);
        if(input.type === "password"){
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            btn.setAttribute('aria-label', 'Masquer le mot de passe');
            input.type = "text";
        }else if(input.type === "text"){
            btn.innerHTML = '<i class="fa-regular fa-eye"></i>';
            btn.setAttribute('aria-label', 'Voir le mot de passe');
            input.type = "password";
        }
    });
});
