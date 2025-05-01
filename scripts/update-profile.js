const editBtn = document.getElementById('edit-btn');
const saveBtn = document.getElementById('save-btn');
const cancelBtn = document.getElementById('cancel-btn');

const displayView = document.getElementById('display-view');
const editForm = document.getElementById('edit-form');

editBtn.addEventListener('click', () => {
  displayView.classList.add('hidden');
  editForm.classList.remove('hidden');
});

cancelBtn.addEventListener('click', () => {
  editForm.classList.add('hidden');
  displayView.classList.remove('hidden');
});

saveBtn.addEventListener('click', async () => {

  const updatedData = {
    name: document.getElementById('input-name').value,
    fname: document.getElementById('input-fname').value,
    lname: document.getElementById('input-lname').value,
    location: document.getElementById('input-location').value,
    email: document.getElementById('input-email').value,
    phone: document.getElementById('input-phone').value,
    role: document.querySelector('input[name="input-role"]:checked')?.value || null
  }

  try {
    const response = await fetch('update-profile.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(updatedData)
    });

    const result = await response.json();

    if(result.success) {
      document.getElementById('display-name').textContent = updatedData.name;
      document.getElementById('display-fname').textContent = updatedData.fname;
      document.getElementById('display-lname').textContent = updatedData.lname;
      document.getElementById('display-location').textContent = updatedData.location;
      document.getElementById('display-email').textContent = updatedData.email;
      document.getElementById('display-phone').textContent = updatedData.phone;
      document.getElementById('display-role').textContent = updatedData.role == 1 ? 'Seller' : 'Buyer';
    }
    else {
      alert('Failed to save changes: ' + result.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while updating your profile.');
  }

  editForm.classList.add('hidden');
  displayView.classList.remove('hidden');
});