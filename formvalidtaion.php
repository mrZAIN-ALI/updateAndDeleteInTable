[5/13/2024 10:02 PM] : const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

form.addEventListener('submit', e => {
    e.preventDefault();

    validateInputs();
});

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success')
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};

const isValidEmail = email => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

const validateInputs = () => {
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    if(usernameValue === '') {
        setError(username, 'Username is required');
    } else {
        setSuccess(username);
    }

    if(emailValue === '') {
        setError(email, 'Email is required');
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
    }

    if(passwordValue === '') {
        setError(password, 'Password is required');
    } else if (passwordValue.length < 8 ) {
        setError(password, 'Password must be at least 8 character.')
    } else {
        setSuccess(password);
    }

    if(password2Value === '') {
        setError(password2, 'Please confirm your password');
    } else if (password2Value !== passwordValue) {
        setError(password2, "Passwords doesn't match");
    } else {
        setSuccess(password2);
    }

};
[5/13/2024 10:03 PM] : const isValidEmail = email => {
    // Split the email address into local part and domain part
    const [localPart, domainPart] = email.split('@');

    // Check if both local part and domain part exist
    if (!localPart || !domainPart) {
        return false;
    }

    // Check if local part contains at least one character
    if (localPart.length < 1) {
        return false;
    }

    // Check if domain part contains at least one character
    if (domainPart.length < 1) {
        return false;
    }

    // Check if domain part contains at least one dot ('.')
    if (!domainPart.includes('.')) {
        return false;
    }

    // Check if there are no consecutive dots ('..') in domain part
    if (domainPart.includes('..')) {
        return false;
    }

    // Check if domain part does not start or end with a dot ('.')
    if (domainPart.startsWith('.') || domainPart.endsWith('.')) {
        return false;
    }

    // Check if domain part does not contain spaces
    if (domainPart.includes(' ')) {
        return false;
    }

    return true;
}
[5/13/2024 10:03 PM] : const setError = (inputElement, errorMessage) => {
    inputElement.parentElement.classList.add('error');
    inputElement.parentElement.classList.remove('success');
    inputElement.parentElement.querySelector('.error').innerText = errorMessage;
};