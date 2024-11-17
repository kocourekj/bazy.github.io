
const sectionImages = {
    about: 'url("img/mountain.jpg")',
    projects: 'url("img/mountain2.jpg")',
    contact: 'url("img/lake.jpg")',
    tasks: 'url("img/lake2.jpg")'
};

// Změna obrázku při posunu nebo kliknutí
const imageContainer = document.getElementById('image-container');
const sections = document.querySelectorAll('section');

function changeBackground() {
    sections.forEach((section) => {
        const rect = section.getBoundingClientRect();
        if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
            const id = section.id;
            imageContainer.style.backgroundImage = sectionImages[id] || '';
        }
    });
}

// Eventy
document.addEventListener('scroll', changeBackground);
document.addEventListener('DOMContentLoaded', changeBackground);
