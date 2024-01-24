// Function to handle the sidebar toggle
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hide');

    // Store the sidebar state in local storage
    const isSidebarHidden = sidebar.classList.contains('hide');
    localStorage.setItem('sidebarState', isSidebarHidden ? 'hidden' : 'visible');
}

// Function to apply sidebar state from local storage
function applySidebarState() {
    const sidebar = document.getElementById('sidebar');
    const storedSidebarState = localStorage.getItem('sidebarState');

    if (storedSidebarState === 'hidden') {
        sidebar.classList.add('hide');
    } else {
        sidebar.classList.remove('hide');
    }
}

// Add event listener for menu click
const menuBar = document.querySelector('#content nav .bx.bx-menu');
menuBar.addEventListener('click', toggleSidebar);

// Apply sidebar state on page load
window.addEventListener('load', applySidebarState);

// Rest of your existing code
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});


/*DARK MODE*/
const applyDarkMode = () => {
    const switchMode = document.getElementById('switch-mode');
    const isDarkMode = localStorage.getItem('darkMode') === 'true';

    if (isDarkMode) {
        switchMode.checked = true;
        document.body.classList.add('dark');
    } else {
        switchMode.checked = false;
        document.body.classList.remove('dark');
    }

    switchMode.addEventListener('change', function () {
        if (this.checked) {
            document.body.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.body.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        }
    });
};

if (window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});

applyDarkMode(); // Call the function to apply dark mode based on local storage