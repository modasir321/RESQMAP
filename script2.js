document.addEventListener('DOMContentLoaded', function() {
    const backgroundContainer = document.getElementById('background-container');

    const images = ['pic1.jpg', 'pic2.jpg', 'pic3.jpg'];
    let currentIndex = 0;

    backgroundContainer.addEventListener('mouseover', function() {
        backgroundContainer.style.backgroundImage = `url(${images[currentIndex]})`;
        currentIndex = (currentIndex + 1) % images.length;
    });
});