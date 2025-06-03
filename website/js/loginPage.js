    const form = document.getElementById('loginForm');
    const spinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); 
        spinner.classList.remove('d-none');

        setTimeout(() => {
            form.submit(); // Submit the form after 3 seconds
        }, 3000); // 3 sec delay
    });