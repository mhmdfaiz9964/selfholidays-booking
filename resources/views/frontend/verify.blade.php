@extends('frontend.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900">Verify Mobile Number</h1>
        </div>
        <form id="verificationForm" class="space-y-4">
            @csrf
            <div class="flex flex-col sm:flex-row sm:space-x-4">
                <div class="flex-grow">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500" placeholder="Enter your phone number">
                </div>
            </div>
            <div id="recaptcha-container"></div>
            <div class="flex justify-center mt-4">
                <button type="button" onclick="sendOTP()" class="flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-md shadow hover:bg-blue-600 focus:outline-none focus:bg-blue-600 transition ease-in-out duration-150">
                    Send OTP
                </button>
            </div>
            <div class="flex flex-col sm:flex-row sm:space-x-4 mt-4">
                <div class="flex-grow">
                    <label for="otp" class="block text-sm font-medium text-gray-700">OTP</label>
                    <input type="text" id="otp" name="otp" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500" placeholder="Enter OTP">
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <button type="button" onclick="verifyOTP()" class="flex items-center px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow hover:bg-green-600 focus:outline-none focus:bg-green-600 transition ease-in-out duration-150">
                    Verify OTP
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>


<script>
    
    // Firebase configuration
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
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
        'callback': (response) => {
            // reCAPTCHA solved - will proceed with submit function
        }
    });

    window.sendOTP = () => {
        const phoneNumber = document.getElementById('phoneNumber').value;
        firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
            .then((confirmationResult) => {
                window.confirmationResult = confirmationResult;
                alert("OTP sent!");
            }).catch((error) => {
                console.error(error);
                alert("Failed to send OTP. Please try again.");
            });
    };

    window.verifyOTP = () => {
        const otp = document.getElementById('otp').value;
        window.confirmationResult.confirm(otp).then((result) => {
            const user = result.user;
            alert("Phone number verified!");
            window.location.href = "{{ route('hotels.index') }}"; // Redirect to the next page after successful verification
        }).catch((error) => {
            console.error(error);
            alert("Failed to verify OTP. Please try again.");
        });
    };
</script>
@endsection
