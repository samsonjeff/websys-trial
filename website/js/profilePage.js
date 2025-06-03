function toggleLogoutConfirmation() {
    const confirmationDiv = document.getElementById('logoutConfirmation');
    confirmationDiv.style.display = confirmationDiv.style.display === 'none' ? 'block' : 'none';
}

function confirmCancelEnrollment(courseID) {
    if (confirm('Are you sure you want to cancel this enrollment?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'cancelEnrollment.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'courseID';
        input.value = courseID;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}