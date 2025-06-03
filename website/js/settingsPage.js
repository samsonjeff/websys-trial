function enableEditing() {
    document.getElementById('firstName').disabled = false;
    document.getElementById('lastName').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('confirmPassword').disabled = false;
    document.getElementById('updateButton').disabled = false;
}

function confirmUpdate() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match. Please try again.');
        return false;
    }

    // Enable all fields before submission
    document.getElementById('firstName').disabled = false;
    document.getElementById('lastName').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('confirmPassword').disabled = false;

    return confirm('Are you sure you want to update your information?');
}