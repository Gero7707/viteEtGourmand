

window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        window.location.reload();
    }
});


const form = document.querySelector('form')
const errorMessage = document.querySelector('.error-message');
const successMessage = document.querySelector('.success-message');

const inputs = document.querySelectorAll('input , select , textarea');

const btnMenu = document.querySelector('.btn-menu');


btnMenu.addEventListener('click' , (e) =>{
    e.preventDefault();
    let isValid = true;
    inputs.forEach(input =>{
        if(!input.value.trim()){
        isValid = false ;
        input.style.border = '1px solid var(--bs-danger)';
        input.style.background = 'var(--bs-warning)';
    }
    })
    if(!isValid){
        errorMessage.style.display = 'block';
        errorMessage.textContent = "Veuillez remplir tous les champs du formulaire ."
    }else if (isValid){
        fomr.submit();
        return;
    }
});
