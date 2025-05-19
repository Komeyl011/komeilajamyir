import './bootstrap';

const toggleButton = document.getElementById('theme-toggle');
const root = document.documentElement;

if (localStorage.getItem('theme') === 'dark' ||
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    root.classList.add('dark');
    toggleButton.innerHTML = '<i class="fa-solid fa-moon text-white"></i>';
} else {
    toggleButton.innerHTML = '<i class="fa-solid fa-sun text-yellow-500"></i>';
    root.classList.remove('dark');
}

toggleButton.addEventListener('click', () => {
    const isDark = root.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    let moon = '<i class="fa-solid fa-moon text-white"></i>';
    let sun = '<i class="fa-solid fa-sun text-yellow-500"></i>';
    toggleButton.innerHTML = isDark ? moon : sun;
});