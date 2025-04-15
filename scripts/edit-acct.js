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

saveBtn.addEventListener('click', () => {

  document.getElementById('display-name').textContent = document.getElementById('input-name').value;
  document.getElementById('display-location').textContent = document.getElementById('input-location').value;
  document.getElementById('display-email').textContent = document.getElementById('input-email').value;
  document.getElementById('display-phone').textContent = document.getElementById('input-phone').value;


  const selectedRole = document.querySelector('input[name="input-role"]:checked');
  if (selectedRole) {
    document.getElementById('display-role').textContent = selectedRole.value;
  }

  editForm.classList.add('hidden');
  displayView.classList.remove('hidden');
});