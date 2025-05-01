const saveListing = document.getElementById('submit_listing');
const cancelBtn = document.getElementById('cancel_listing');

saveListing.addEventListener('click', async (e) => {
    e.preventDefault();

    const updatedData = {
        product_name: document.getElementById('product_name').value,
        product_description: document.getElementById('product_description').value,
        product_brand: document.getElementById('product_brand').value,
        product_condition: document.querySelector('input[name="product_condition"]:checked').value,
        product_image: document.getElementById('product_image').value,
        price: document.getElementById('price').value,
        quantity: document.getElementById('quantity')?.value || null,
        keywords: document.getElementById('keywords')?.value,
        category_id: document.getElementById('category_id')?.value,
        status: document.getElementById('status')?.value
    }

    console.log(updatedData);
  
    try {
      const response = await fetch('listing-process.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedData)
      });
  
      const result = await response.json();
  
      if(result.success) {
        alert('success');
    }
      else {
        alert('Failed to save changes: ' + result.message);
      }
    } catch (error) {
      console.error('Error:', error);
      alert('An error occurred while updating your listing.');
    }
  
    editForm.classList.add('hidden');
    displayView.classList.remove('hidden');
  });