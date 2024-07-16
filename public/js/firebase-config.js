// public/js/firebase-config.js

// Import the necessary Firebase modules
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyC6s7yHkBqwI5JGmdTrMwKpHybM0jQo9zI",
    authDomain: "selfholidays-51ef5.firebaseapp.com",
    projectId: "selfholidays-51ef5",
    storageBucket: "selfholidays-51ef5.appspot.com",
    messagingSenderId: "159413662554",
    appId: "1:159413662554:web:c828cb2906161200303963",
    measurementId: "G-P00ZYGD87S"
  };

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

window.recaptchaVerifier = new RecaptchaVerifier('recaptcha-container', {
    'size': 'invisible',
    'callback': (response) => {
        // reCAPTCHA solved - will proceed with submit function
    }
}, auth);

window.sendOTP = (phoneNumber) => {
    signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
        .then((confirmationResult) => {
            window.confirmationResult = confirmationResult;
            alert("OTP sent!");
        }).catch((error) => {
            console.error(error);
            alert("Failed to send OTP. Please try again.");
        });
};

window.verifyOTP = (otp) => {
    confirmationResult.confirm(otp).then((result) => {
        const user = result.user;
        alert("Phone number verified!");
        window.location.href = "/next-page"; // Redirect to the next page after successful verification
    }).catch((error) => {
        console.error(error);
        alert("Failed to verify OTP. Please try again.");
    });
};
