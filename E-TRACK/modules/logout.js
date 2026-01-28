document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.getElementById('logoutButton');
    logoutButton.addEventListener('click', function() {
        const confirmation = confirm("Are you sure you want to log out?");
        if (confirmation) {
            window.location.href = 'index.html';
        }
    });
});
