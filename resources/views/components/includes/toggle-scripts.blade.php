<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglerButton = document.getElementById('menu-toggler');
        const togglerMobileButton = document.getElementById('menu-toggler-btn');
        const togglerMobileMenu = document.getElementById('mobile-menu');
        const toggleSection = document.getElementById('toggle-section');
    
        togglerButton.addEventListener('click', function () {
        toggleSection.classList.toggle('hidden');
        });

        togglerMobileButton.addEventListener('click', function () {
        togglerMobileMenu.classList.toggle('hidden');
        });
    });
</script>