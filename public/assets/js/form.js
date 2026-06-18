

window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        window.location.reload();
    }
});


const form = document.querySelector('form')
const errorMessage = document.querySelector('.error-message');
const successMessage = document.querySelector('.success-message');

const inputs = document.querySelectorAll('input , select , textarea ,input[type="checkbox"] ');

const btnSubmitForm = document.querySelector('.btn-form');


btnSubmitForm.addEventListener('click' , (e) =>{
    e.preventDefault();
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
        errorMessage.style.display = 'block';
        errorMessage.textContent = "Veuillez remplir tous les champs du formulaire ."
    }else if (isValid){
        form.submit();
        return;
    }
});
