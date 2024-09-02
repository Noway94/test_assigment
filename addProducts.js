function showAttributeField() {
    var type = document.getElementById('productType').value;
    document.getElementById('DVD').style.display = 'none';
    document.getElementById('Book').style.display = 'none';
    document.getElementById('Furniture').style.display = 'none';

    if (type === 'DVD') {
        document.getElementById('DVD').style.display = 'block';
    } else if (type === 'Book') {
        document.getElementById('Book').style.display = 'block';
    } else if (type === 'Furniture') {
        document.getElementById('Furniture').style.display = 'block';
    }
}

document.getElementById('product_form').addEventListener('submit', function(event) {
    var sku = document.getElementById('sku').value;
    var name = document.getElementById('name').value;
    var price = document.getElementById('price').value;
    var type = document.getElementById('productType').value;
    var size = document.getElementById('size').value;
    var weight = document.getElementById('weight').value;
    var height = document.getElementById('height').value;
    var width = document.getElementById('width').value;
    var length = document.getElementById('length').value;
    var notification = document.getElementById('notification');

    if (!sku || !name || !price || !type || (type === 'DVD' && !size) || (type === 'Book' && !weight) || (type === 'Furniture' && (!height || !width || !length))) {
        notification.textContent = "Please, submit required data";
        notification.style.display = 'block';
        event.preventDefault();
        return;
    }

    if (isNaN(price) || (type === 'DVD' && isNaN(size)) || (type === 'Book' && isNaN(weight)) || (type === 'Furniture' && (isNaN(height) || isNaN(width) || isNaN(length)))) {
        notification.textContent = "Please, provide the data of indicated type";
        notification.style.display = 'block';
        event.preventDefault();
        return;
    }

    notification.style.display = 'none';
});