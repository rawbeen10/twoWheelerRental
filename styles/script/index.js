const carouselSlide = document.querySelector('.carousel-slider');
const carouselItems = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.carousel-btn.prev');
const nextButton = document.querySelector('.carousel-btn.next');

let counter = 0;
const totalItems = carouselItems.length;

function updateCarousel() {
    carouselSlide.style.transition = "transform 0.5s ease-in-out";
    carouselSlide.style.transform = `translateX(${-counter * 100}%)`; 
}

nextButton.addEventListener('click', () => {
    counter = (counter + 1) % totalItems;
    updateCarousel();
});

prevButton.addEventListener('click', () => {
    counter = (counter - 1 + totalItems) % totalItems;
    updateCarousel();
});

updateCarousel();
