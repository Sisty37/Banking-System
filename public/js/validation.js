document.addEventListener('DOMContentLoaded', function() {

    // --- Registration Form Validation ---
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(span => span.textContent = '');

            // First Name validation
            const firstName = document.getElementById('first_name');
            if (firstName.value.trim() === '') {
                document.getElementById('first_name-error').textContent = 'First Name is required.';
                isValid = false;
            } else if (firstName.value.trim().length < 2) {
                document.getElementById('first_name-error').textContent = 'First Name must be at least 2 characters.';
                isValid = false;
            }

            // Last Name validation
            const lastName = document.getElementById('last_name');
            if (lastName.value.trim() === '') {
                document.getElementById('last_name-error').textContent = 'Last Name is required.';
                isValid = false;
            } else if (lastName.value.trim().length < 2) {
                document.getElementById('last_name-error').textContent = 'Last Name must be at least 2 characters.';
                isValid = false;
            }

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                document.getElementById('email-error').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                document.getElementById('email-error').textContent = 'Invalid email format.';
                isValid = false;
            }

            // Date of Birth validation
            const dob = document.getElementById('dob');
            if (dob.value.trim() === '') {
                document.getElementById('dob-error').textContent = 'Date of Birth is required.';
                isValid = false;
            } else {
                const birthDate = new Date(dob.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 18) { // Example: Minimum age of 1
                    document.getElementById('dob-error').textContent = 'You must be at least 18 years old.';
                    isValid = false;
                }
            }


            // Password validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; // Min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special char

            if (password.value === '') {
                document.getElementById('password-error').textContent = 'Password is required.';
                isValid = false;
            } else if (!passwordRegex.test(password.value)) {
                document.getElementById('password-error').textContent = 'Password must be at least 8 characters, include uppercase, lowercase, number, and special character.';
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                document.getElementById('confirm_password-error').textContent = 'Passwords do not match.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    }

    // --- Login Form Validation ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(span => span.textContent = '');

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                document.getElementById('email-error').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                document.getElementById('email-error').textContent = 'Invalid email format.';
                isValid = false;
            }

            // Password validation
            const password = document.getElementById('password');
            if (password.value === '') {
                document.getElementById('password-error').textContent = 'Password is required.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    }

    // --- Forgot Password Form Validation ---
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(span => span.textContent = '');

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                document.getElementById('email-error').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                document.getElementById('email-error').textContent = 'Invalid email format.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    }

});