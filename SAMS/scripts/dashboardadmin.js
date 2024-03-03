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


// ----------Function to handle theme change---------------------------------------------
// Function to handle theme change
function changeTheme(themeColor,themeColor1,themeSidebartxt,themeIcons) {
    
    // LEFTSIDE COLOR
    document.body.style.setProperty('--leftside', themeColor);
    document.body.style.setProperty('--active', themeColor);
    document.body.style.setProperty('--sidebartxt', themeSidebartxt);

    // THEME 
    document.body.style.setProperty('--theme', themeColor);

    // CONTENT
    document.body.style.setProperty('--topsearch', themeIcons);

    // DROPDOWN
    document.body.style.setProperty('--dropdown1', themeColor);
    

    // CONTENT CENTER DASHBOARD
    document.body.style.setProperty('--dashcontent2', themeIcons);
    
    document.body.style.setProperty('--tablethbx', themeColor);
    document.body.style.setProperty('--clear', themeColor);
    document.body.style.setProperty('--icon', themeColor);


    document.body.style.setProperty('--gap', themeColor1);
    document.body.style.setProperty('--employee', themeColor);
    document.body.style.setProperty('--modalbtn', themeColor);

    
    // document.body.style.setProperty('--employee1', themeColor1);



    // Save the selected theme to local storage
    localStorage.setItem('selectedTheme', themeColor);
    localStorage.setItem('selectedTheme1', themeColor1);
    localStorage.setItem('selectedTheme2', themeSidebartxt);
    localStorage.setItem('selectedTheme3', themeIcons);
}

// Function to apply the stored theme on page load
function applyStoredTheme() {
    const storedTheme = localStorage.getItem('selectedTheme');
    const storedTheme1 = localStorage.getItem('selectedTheme1');
    const storedTheme2 = localStorage.getItem('selectedTheme2');
    const storedTheme3 = localStorage.getItem('selectedTheme3');
    if (storedTheme && storedTheme1 && storedTheme2 && storedTheme3) {
        changeTheme(storedTheme,storedTheme1,storedTheme2,storedTheme3);
    }
}

//  theme switcher click
const themeSwitcher = document.getElementById('themeSwitcher');
const themeOptions = document.querySelector('.theme-options');

themeSwitcher.addEventListener('click', function () {
    // display of theme options
    themeOptions.classList.toggle('active');
});


// theme change when an option is clicked
const themeOptionItems = document.querySelectorAll('.theme-options li');

themeOptionItems.forEach(option => {
    option.addEventListener('click', function() {

        const selectedTheme = option.getAttribute('data-theme');
        switch (selectedTheme) {

            // THEMES       Main Color
            //              Tints            
            //              Sidebartxt
            //              Icons

            // Default Theme Black
            case 'option1':
                changeTheme('#0e0e0e', 
                            '#4f4d4d81',
                            'var(--theme-sidebartxt)',
                            'var(--theme-icon)');
                break;
            // Navy blue Theme

            case 'option2':
                changeTheme('#14299f', 
                            '#14299f81', 
                            'var(--theme-sidebartxt1)',
                            'var(--theme-icon1)'); 
                break;
            // Sakura Theme
            case 'option3':
                changeTheme('#fc6db5', 
                            '#fc6db581',
                            'var(--theme-sidebartxt2)',
                            'var(--theme-icon2)'); 
        }

        // Hide the theme options after selection
        themeOptions.classList.remove('active');
    });
});


// close theme options when clicking outside
document.addEventListener('click', function (event) {
    if (!themeSwitcher.contains(event.target) && !themeOptions.contains(event.target)) {
        themeOptions.classList.remove('active');
    }
});

// Apply stored theme on page load
window.addEventListener('load', applyStoredTheme);