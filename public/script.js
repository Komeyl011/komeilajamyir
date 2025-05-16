// Example: Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Example: Dynamically update progress bars
document.addEventListener('DOMContentLoaded', () => {
    const skills = [
        { selector: '.skill-1', percentage: 90 },
        { selector: '.skill-2', percentage: 75 }
    ];

    skills.forEach(skill => {
        const skillElement = document.querySelector(skill.selector);
        const fillElement = skillElement.querySelector('.progress-bar-fill');
        const percentageElement = skillElement.querySelector('.percentage');

        fillElement.style.width = `${skill.percentage}%`;
        percentageElement.textContent = `${skill.percentage}%`;
    });
});
