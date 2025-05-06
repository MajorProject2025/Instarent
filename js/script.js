// Get the buttons and containers
const signInButton = document.getElementById('signInButton');
const signUpButton = document.getElementById('signup-form');
const signInContainer = document.getElementById('signIn');
const signUpContainer = document.getElementById('signup');

// Add click event for Sign In button
signInButton.addEventListener('click', function(e) {
    e.preventDefault();
    signUpContainer.style.display = 'none';
    signInContainer.style.display = 'block';
});

// Add click event for Sign Up button
signUpButton.addEventListener('click', function(e) {
    e.preventDefault();
    signInContainer.style.display = 'none';
    signUpContainer.style.display = 'block';
});