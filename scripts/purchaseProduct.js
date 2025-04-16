var itemsInCart = 0;
const maxItems = 99;

function addToCart() {
    if (itemsInCart < maxItems) {
        var cartElement = document.getElementById('cart');
        var cartText = cartElement.innerHTML
        alert("Added Item to Cart!");
        itemsInCart++;
        cartElement.innerHTML = "Cart" + " (" + itemsInCart + ")";
    }

    else {
        alert("Max items in cart has been reached.")
    }

}

function purchase() {
    alert("Item purchased!");
}