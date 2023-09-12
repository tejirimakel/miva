function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function handleScrollAnimation1() {
    const sections = document.querySelectorAll('.blk1');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__slideInRight');
        } else {
            section.classList.remove('animate__animated', 'animate__slideInRight');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation1);
window.addEventListener('load', handleScrollAnimation1);

function handleScrollAnimation2() {
    const sections = document.querySelectorAll('.bxs-box');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__fadeInUp');
        } else {
            section.classList.remove('animate__animated', 'animate__fadeInUp');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation2);
window.addEventListener('load', handleScrollAnimation2);

function handleScrollAnimation3() {
    const sections = document.querySelectorAll('.popcardbox');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__fadeInRight');
        } else {
            section.classList.remove('animate__animated', 'animate__fadeInRight');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation3);
window.addEventListener('load', handleScrollAnimation3);

function handleScrollAnimation4() {
    const sections = document.querySelectorAll('.card1');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__fadeInDown');
        } else {
            section.classList.remove('animate__animated', 'animate__fadeInDown');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation4);
window.addEventListener('load', handleScrollAnimation4);

function handleScrollAnimation5() {
    const sections = document.querySelectorAll('.card2');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__fadeInDown');
        } else {
            section.classList.remove('animate__animated', 'animate__fadeInDown');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation5);
window.addEventListener('load', handleScrollAnimation5);

function handleScrollAnimation6() {
    const sections = document.querySelectorAll('.card3');
    
    sections.forEach(section => {
        if (isElementInViewport(section)) {
            section.classList.add('animate__animated', 'animate__fadeInDown');
        } else {
            section.classList.remove('animate__animated', 'animate__fadeInDown');
        }
    });
}

window.addEventListener('scroll', handleScrollAnimation6);
window.addEventListener('load', handleScrollAnimation6);