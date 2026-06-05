document.addEventListener('DOMContentLoaded', () =>{
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if(entry.isIntersecting){
                entry.target.classList.add('visible');
            }
        });
    });

    const elements = document.querySelectorAll('.observer');
    elements.forEach((el) => observer.observe(el));
});