// Select carousel elements
const carouselSlide = document.querySelector('.carousel-slider');
const carouselItems = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.carousel-btn.prev');
const nextButton = document.querySelector('.carousel-btn.next');

// Set the initial index for the carousel
let counter = 0;
const totalItems = carouselItems.length;

// Function to update the carousel by changing the transform property
function updateCarousel() {
    // Update the carousel's transform property to slide
    carouselSlide.style.transition = "transform 0.5s ease-in-out";
    carouselSlide.style.transform = `translateX(${-counter * 100}%)`; // 100% is the width of one item
}

// Function to handle next button click
nextButton.addEventListener('click', () => {
    // If it's the last image, go back to the first image (reset counter)
    counter = (counter + 1) % totalItems;
    updateCarousel();
});

// Function to handle previous button click
prevButton.addEventListener('click', () => {
    // If it's the first image, go to the last image
    counter = (counter - 1 + totalItems) % totalItems;
    updateCarousel();
});

// Initialize the carousel
updateCarousel();
