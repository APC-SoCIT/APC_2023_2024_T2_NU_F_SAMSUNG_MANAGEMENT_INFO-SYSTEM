document.addEventListener('DOMContentLoaded', () => {


    // Function to save checkbox state
    function saveCheckboxState() {
        var keepLoggedIn = document.getElementById('keepLoggedIn');
        localStorage.setItem('keepLoggedInState', keepLoggedIn.checked);
    }

    // Function to load checkbox state
    function loadCheckboxState() {
        var keepLoggedIn = document.getElementById('keepLoggedIn');
        var savedState = localStorage.getItem('keepLoggedInState');
        if (savedState === 'true') {
            keepLoggedIn.checked = true;
        } else if (savedState === 'false') {
            keepLoggedIn.checked = false;
        }
    }

    // Event listener for checkbox click

    const keepLoginBtn = document.querySelector('#keepLoggedIn');

    keepLoginBtn.addEventListener('click', saveCheckboxState);

    // Load the saved state when the page loads
    window.addEventListener('load', loadCheckboxState);

});