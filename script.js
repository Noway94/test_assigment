document.addEventListener('DOMContentLoaded', function() {
    const massDeleteBtn = document.getElementById('mass-delete-btn');

    // Function to handle mass delete action
    massDeleteBtn.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.delete-checkbox');
        const selectedProducts = [];

        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                selectedProducts.push(checkbox.parentElement.querySelector('span').textContent);
            }
        });

        if (selectedProducts.length > 0) {
            fetch('delete_products.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ skus: selectedProducts })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Error deleting products');
                }
            });
        }
    });
});
