
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('.sidebar ul li a');
    const sections = document.querySelectorAll('.section');
    const logoutButton = document.getElementById('logoutButton');

    //show sections
    links.forEach(link => {
        link.addEventListener('click', function (event) {
            links.forEach(link => link.classList.remove('active'));
            link.classList.add('active');
            
            sections.forEach(section => section.classList.remove('active'));

            const targetSection = document.querySelector(link.getAttribute('href'));
            targetSection.classList.add('active');
        });
    });

    //logout
    logoutButton.addEventListener('click', function (e) {
        e.preventDefault(); 
        
        const userConfirmed = confirm("Are you sure you want to log out?");
        
        if (userConfirmed) {
            window.location.href = '../services/logout.php';
        } else {
            document.querySelector(link.getAttribute('href'));
            return;
        }
    });
});

