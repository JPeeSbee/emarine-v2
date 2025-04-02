<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('default-modal');
        const openModalButtons = document.querySelectorAll('[data-modal-toggle]');
        const closeModalButtons = document.querySelectorAll('[data-modal-hide]');

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.toggle('hidden');
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
</script>