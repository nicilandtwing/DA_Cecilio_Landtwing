// Array of image URLs
const backgroundImages = [
    '../images/background1.jpg',
    '../images/background2.jpg',
    '../images/background3.jpg',
    '../images/background4.jpg',
    '../images/background5.jpg',
    '../images/background6.jpg',
];

// Function to set a random background image for the specific section
function setRandomBackground() {
    const randomIndex = Math.floor(Math.random() * backgroundImages.length);
    const randomImage = backgroundImages[randomIndex];
    const backgroundSection = document.getElementById('random-image');
    backgroundSection.style.backgroundImage = `url(${randomImage})`;
}

// Call the function to set a random background when the page loads
window.onload = setRandomBackground;
