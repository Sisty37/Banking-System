
function savePermissions() {
    const dashboardAccess = document.getElementById('dashboard').value;
    const manageUsersAccess = document.getElementById('manage-users').value;
    const settingsAccess = document.getElementById('settings').value;
    console.log('Saving Permissions:');
    console.log('Dashboard Access:', dashboardAccess);
    console.log('Manage Users:', manageUsersAccess);
    console.log('Settings Access:', settingsAccess);
    alert('Permissions Saved Successfully!');
  }
  function saveRoles() {
    const selects = document.querySelectorAll('tbody select');
    selects.forEach((select, index) => {
      const user = select.closest('tr').querySelector('td').innerText;
      const selectedRole = select.value;
      console.log(`Saving Role for ${user}: ${selectedRole}`);
    });
    alert('Roles Assigned Successfully!');
  }
  