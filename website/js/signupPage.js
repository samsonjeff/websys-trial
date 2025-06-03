
function validateForm() {
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("pass").value.trim();

    if (!firstName || !lastName || !username || !email || !password) {
        alert("All fields are required.");
        return false;
    }
    return true;
}
