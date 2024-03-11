// main.js
document.addEventListener("DOMContentLoaded", function() {
    // Load Navbar
    fetch('footer.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('footerContainer').innerHTML = data;
    });
});
