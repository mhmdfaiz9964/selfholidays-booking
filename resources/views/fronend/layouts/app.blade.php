<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Your custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="#" class="flex items-center">
                    <img class="h-8 w-auto sm:h-10" src="/logo.png" alt="Logo">
                    <span class="ml-3 text-xl font-bold text-gray-900">Your Website</span>
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Main menu" aria-expanded="false">
                    <!-- Hamburger icon -->
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <nav class="hidden md:flex space-x-10">
                <a href="#" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">Home</a>
                <a href="#" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">Hotels</a>
            </nav>
        </div>
    </div>
</header>
<!-- End Header -->

<!-- Mobile Menu (Hidden by default) -->
<div class="md:hidden bg-white shadow-md">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition ease-in-out duration-150">Home</a>
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition ease-in-out duration-150">Hotels</a>
    </div>
</div>
<!-- End Mobile Menu -->

<!-- Content Area -->
<div class="py-10">
    @yield('content')
</div>
<!-- End Content Area -->

<!-- Footer -->
<footer class="bg-gray-800 pt-10 sm:mt-10 pt-10">
    <div class="max-w-7xl mx-auto md:grid md:grid-cols-2 lg:grid-cols-4">
        <div class="px-8 sm:w-1/2 md:w-1/4 lg:w-full">
            <h3 class="text-gray-200 font-bold mb-3">About Us</h3>
            <ul class="list-none leading-normal">
                <li><a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Company</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Team</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Careers</a></li>
            </ul>
        </div>
        <div class="px-8 sm:w-1/2 md:w-1/4 lg:w-full">
            <h3 class="text-gray-200 font-bold mb-3">Legal</h3>
            <ul class="list-none leading-normal">
                <li><a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Terms & Conditions</a></li>
            </ul>
        </div>
    </div>
    <div class="mt-10 border-t-2 border-gray-700 pt-6 md:flex md:items-center md:justify-between">
        <div class="flex space-x-6 md:order-2">
            <a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Privacy</a>
            <a href="#" class="text-gray-400 hover:text-white transition ease-in-out duration-150">Terms</a>
        </div>
        <p class="mt-8 text-center md:mt-0 md:order-1 text-gray-400">&copy; 2024 Your Company. All rights reserved.</p>
    </div>
</footer>
<!-- End Footer -->

</body>
</html>
