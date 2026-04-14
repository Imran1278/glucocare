function moveSlider(direction) {
    const wrapper = document.querySelector('.spec-slider-wrapper');
    const scrollAmount = 250;
    wrapper.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}

function moveDocs(direction) {
    const slider = document.getElementById('docsSlider');
    const cardWidth = 280; // Card width + gap
    slider.scrollBy({
        left: direction * cardWidth,
        behavior: 'smooth'
    });
}



