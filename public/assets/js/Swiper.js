const swiper = new Swiper(".swiper" , {
    grabCursor: true,
    slidePerView: 1.5,
    centeredSlides: true,
    initialSlide: 2,
    speed: 900,
    parallax: true,
    spaceBetween: 40,
    // mousewheel: {
    //     thresholdDelta: 50,
    //     releaseOnEdges: true,
    // },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

const arrowLeft = document.querySelector('.swiper-button-prev');
const arrowRight = document.querySelector('.swiper-button-next');



arrowLeft.innerHTML = "<i class=\"fa-solid fa-caret-left\"></i>";
arrowRight.innerHTML = "<i class=\"fa-solid fa-caret-right\"></i>";