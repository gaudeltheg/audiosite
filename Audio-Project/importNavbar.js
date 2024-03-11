// main.js
document.addEventListener("DOMContentLoaded", function() {
    // Load Navbar
    fetch('navbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbarContainer').innerHTML = data;
    });
});
