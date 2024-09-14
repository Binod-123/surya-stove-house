function updateCartCount() {
    $.ajax({
        url: 'cart_ajax.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('.cart-counter').text(response.cart_count);
           
            var cartJson = JSON.stringify(response.cart_product); // Convert cart data to JSON string
            $('.cart_data').attr('data-cart', cartJson);
        },

        error: function () {
            alert('Failed to fetch cart count.');
        }
    });
}

function addToCart() {
    const button = document.getElementById('myButton');
    const productId = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const image = button.getAttribute('data-image');
    const price = button.getAttribute('data-price');
    const quantity = 1;
    //alert(productId);
    $.ajax({
        url: 'cart_ajax.php',
        method: 'POST',
        data: { action: "add", product_id: productId, quantity: quantity, name: name, price: price, image: image },
        dataType: 'json',
        success: function (response) {
            // alert(response);
            if (response.success) {
              //  alert(response.message);
                updateCartCount();
            } else {
               // alert(response.message);
            }
            //console.log(response.product);
        },
        error: function () {
            alert('Failed to add product to cart.');
        }
    });
}
function updateQuantity(change, button) {
   // alert('Quantity');
    const row = $(button).closest('tr');
    const productId_2 = row.data('product-id');
    const quantityInput = row.find('input[type="text"]');

    let quantity = parseInt(quantityInput.val(), 10) + change;
    if (quantity < 1) {
        quantity = 1; 
    }

   
    quantityInput.val(quantity);

    
    $.ajax({
        url: 'cart_ajax.php',
        method: 'POST',
        data: {
            action: 'update_quantity',
            product_id: productId_2,
            quantity: quantity
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Update total price
                const price = parseFloat(row.find('.price').text().replace('₹ ', ''));
                const totalPrice = price * quantity;
                row.find('.total-price').text('₹ ' + totalPrice.toFixed(2));

                // Also update the hidden input field for the row
                row.find('.total-price-hidden').val(totalPrice.toFixed(2));
                calculateSummary();
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert('Failed to update quantity.');
        }
    });
}
function calculateSummary() {
    let subtotal = 0;

    // Iterate over each product row to calculate the subtotal
    $('tr[data-product-id]').each(function () {
        const price = parseFloat($(this).find('.price').text().replace('₹ ', ''));
        const quantity = parseInt($(this).find('input[type="text"]').val(), 10);
        subtotal += price * quantity;
    });

    const gst = subtotal * 0.18; // 18% GST
    const total = subtotal + gst;

    // Update the summary in the DOM
    $('#subtotal').text('₹ ' + subtotal.toFixed(2));
    $('#gst').text('₹ ' + gst.toFixed(2));
    $('#grandtotal').text('₹ ' + total.toFixed(2));
}
// Update cart count when the page loads
$(document).ready(function () {
    calculateSummary()
    updateCartCount();
});