// Toggle sidebar when the button is clicked
document.getElementById('menu-icon')?.addEventListener('click', () => {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('active');
  
  // Adjust main content margin based on sidebar
  const mainWrapper = document.querySelector('.main-wrapper');
  if (sidebar.classList.contains('active')) {
    mainWrapper.style.marginLeft = '200px';
    mainWrapper.style.transition = 'margin-left 0.3s ease';
  } else {
    mainWrapper.style.marginLeft = '0';
  }
});

// Update price label as the range slider changes
const priceInput = document.getElementById('price-range');
const priceValue = document.getElementById('price-value');
if (priceInput && priceValue) {
  priceInput.addEventListener('input', () => {
    priceValue.textContent = '$' + priceInput.value;
  });
}

// Add to cart functionality
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const listingId = this.getAttribute('data-listing-id');
      
      fetch('add-to-cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `listing_id=${listingId}`
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if(data.success) {
          // Show message that indicates item was added to cart
          const notification = document.createElement('div');
          notification.className = 'cart-notification';
          notification.textContent = 'Added to cart!';
          document.body.appendChild(notification);
          
          // Remove the notification after 2 seconds
          setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
          }, 2000);
          
          // Update cart count if element exists
          const cartCount = document.querySelector('.cart-count');
          if (cartCount) {
            const currentCount = parseInt(cartCount.textContent) || 0;
            cartCount.textContent = currentCount + 1;
          }
        } else {
          // Directs users to login if they are not logged in
          alert('Please log in to add items to cart');
          window.location.href = 'login.php';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding to cart');
      });
    });
  });
});