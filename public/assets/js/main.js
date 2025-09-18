document.addEventListener('DOMContentLoaded', () => {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        if (toggle.title === 'Settings') {
            const icon = toggle.querySelector('.material-symbols-outlined:last-child');
            const content = toggle.nextElementSibling;
            toggle.classList.add('open');
            icon.classList.add('rotate-180');
            content.style.maxHeight = content.scrollHeight + "px";
        }
        toggle.addEventListener('click', () => {
            const icon = toggle.querySelector('.material-symbols-outlined:last-child');
            const content = toggle.nextElementSibling;
            toggle.classList.toggle('open');
            icon.classList.toggle('rotate-180');
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuToggle.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('flex');
    });
    mobileMenuClose.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('flex');
    });
});