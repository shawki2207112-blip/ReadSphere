'use strict';

/*
 * Elements used to control the responsive dashboard sidebar.
 * The button ID must match the ID used in dashboard-topbar.blade.php.
 */
const sidebar = document.getElementById('sidebar');
const menuButton = document.getElementById('menuToggle');

/**
 * Close the sidebar and reset its accessibility state.
 */
function closeSidebar() {
    if (!sidebar || !menuButton) {
        return;
    }

    sidebar.classList.remove('open');
    menuButton.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('sidebar-open');
}

/*
 * Enable sidebar controls only when both required elements exist.
 */
if (sidebar && menuButton) {
    // Open or close the sidebar when the menu button is clicked.
    menuButton.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('open');

        menuButton.setAttribute('aria-expanded', String(isOpen));
        document.body.classList.toggle('sidebar-open', isOpen);
    });

    // Close the sidebar after selecting a link on smaller screens.
    sidebar.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 780) {
                closeSidebar();
            }
        });
    });

    // Allow users to close the sidebar with the Escape key.
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    // Reset the mobile sidebar when the screen becomes wider.
    window.addEventListener('resize', () => {
        if (window.innerWidth > 780) {
            closeSidebar();
        }
    });
}

/*
 * Show a confirmation message before submitting forms
 * that contain the data-confirm attribute.
 */
document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const message = form.dataset.confirm || 'Are you sure?';

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
});