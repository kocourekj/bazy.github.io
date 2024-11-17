
const sectionImages = {
    about: 'url("kocourekj.github.io/img/mountain.jpg")',
    projects: 'url("kocourekj.github.io/img/mountain2.jpg")',
    contact: 'url("kocourekj.github.io/img/lake.jpg")',
    tasks: 'url("kocourekj.github.io/img/lake2.jpg")'
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
