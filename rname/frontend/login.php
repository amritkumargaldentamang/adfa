<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EverSales</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1>EverSales</h1>
            
            <div id="message" class="message"></div>
            
            <!-- Form Toggle -->
            <div class="form-toggle">
                <button id="loginBtn" class="active" onclick="toggleForm('login')">Login</button>
                <button id="registerBtn" onclick="toggleForm('register')">Register</button>
            </div>
            
            <!-- Login Form -->
            <form id="loginForm" class="auth-form" onsubmit="handleLogin(event)">
                <h2>Login to your Account</h2>
                
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Login</button>
            </form>
            
            <!-- Register Form -->
            <form id="registerForm" class="auth-form hidden" onsubmit="handleRegister(event)">
                <h2>Create New Account</h2>
                
                <div class="form-group">
                    <label for="registerFullName">Full Name</label>
                    <input type="text" id="registerFullName" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="registerPhone">Phone Number</label>
                    <input type="tel" id="registerPhone" name="phone_number">
                </div>
                
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                
                <button type="submit" class="btn-primary">Register</button>
            </form>
        </div>
    </div>
    <script>
        /**
         * Toggle between login and register forms
         */
        function toggleForm(form) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginBtn = document.getElementById('loginBtn');
            const registerBtn = document.getElementById('registerBtn');
            const messageDiv = document.getElementById('message');
            
            // Clear messages
            messageDiv.textContent = '';
            messageDiv.style.display = 'none';
            
            if (form === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginBtn.classList.add('active');
                registerBtn.classList.remove('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginBtn.classList.remove('active');
                registerBtn.classList.add('active');
            }
        }
        
        /**
         * Handle login form submission
         */
        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            login(email, password);
        }
        
        /**
         * Handle register form submission
         */
        function handleRegister(event) {
            event.preventDefault();
            const fullName = document.getElementById('registerFullName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const phoneNumber = document.getElementById('registerPhone').value;
            
            if (password !== confirmPassword) {
                showMessage('Passwords do not match', 'error');
                return;
            }
            
            register(fullName, email, password, phoneNumber);
        }
        
        /**
         * Show message to user
         */
        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = 'message ' + type;
            messageDiv.style.display = 'block';
        }
        
        /**
         * Login function
         */
        function login(email, password) {
            const formData = new FormData();
            formData.append('login', '1');
            formData.append('email', email);
            formData.append('password', password);
            
            fetch('../backend/auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('login_success')) {
                    window.location.href = 'index.php';
                } else {
                    showMessage(data, 'error');
                }
            })
            .catch(error => {
                showMessage('An error occurred', 'error');
            });
        }
        
        /**
         * Register function
         */
        function register(fullName, email, password, phoneNumber) {
            const formData = new FormData();
            formData.append('register', '1');
            formData.append('full_name', fullName);
            formData.append('email', email);
            formData.append('password', password);
            if (phoneNumber) {
                formData.append('phone_number', phoneNumber);
            }
            
            fetch('../backend/auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'registration_successful') {
                    showMessage('Registration successful! You can now login.', 'success');
                    setTimeout(() => {
                        toggleForm('login');
                    }, 2000);
                } else {
                    showMessage(data, 'error');
                }
            })
            .catch(error => {
                showMessage('An error occurred', 'error');
            });
        }
        
        /**
         * Check if already logged in on page load
         */
        async function isLoggedIn() {
            // For now, assume not logged in
            return false;
        }
        
        /**
         * Check if already logged in on page load
         */
        document.addEventListener('DOMContentLoaded', async () => {
            const loggedIn = await isLoggedIn();
            if (loggedIn) {
                window.location.href = '../frontend/index.php';
            }
        });
    </script>
</body>
</html>
