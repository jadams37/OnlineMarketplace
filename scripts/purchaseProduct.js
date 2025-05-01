// To track how many items are currently in the cart
var itemsInCart = 0;
// Limit the number of items a user can add to their cart
const maxItems = 99;

function updateCartCount() {
    const cartElement = document.getElementById('cart');
    cartElement.innerHTML = `Cart (${itemsInCart})`;
}

// Called when a user clicks "Add to Cart" on a product and sends the product ID to the server
function addToCart(listingId) {
    if (itemsInCart < maxItems) {
        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `listing_id=${listingId}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                itemsInCart++;
                updateCartCount();
                alert("Added Item to Cart!");
            } else {
                //error message from server if error occured in adding product to cart
                alert(data.message || "Failed to add to cart");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while adding to cart");
        });
    } else {
        alert("Max items in cart has been reached.");
    }
}

function purchase() {
    alert("Item purchased!");
}