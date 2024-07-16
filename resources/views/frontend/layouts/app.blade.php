<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Custom styles for the Book Now button */
        .book-now-btn {
            background-color: #36171A;
            color: white;
        }
        .book-now-btn:hover {
            background-color: #521b20;
        }
    </style>
</head>
<body class="bg-gray-100">

{{-- <!-- Header -->
<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="#" class="flex items-center">
                    <span class="ml-3 text-xl font-bold text-gray-900">Self Holidays</span>
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <!-- Mobile menu button -->
                <button type="button" onclick="toggleMenu()" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Main menu" aria-expanded="false">
                    <!-- Hamburger icon -->
                    <i class="fas fa-bars"></i> <!-- Font Awesome bars icon -->
                </button>
            </div>
            <nav class="hidden md:flex space-x-10">
                <a href="#" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">Home</a>
                <a href="#" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">Hotels</a>
                <a href="#" class="book-now-btn text-base leading-6 font-medium py-2 px-4 rounded-md shadow">
                    <i class="fas fa-hotel"></i> Book Now <!-- Font Awesome hotel icon -->
                </a>
            </nav>
        </div>
    </div>
</header>
<!-- End Header -->

<!-- Mobile Menu (Hidden by default) -->
<div id="mobile-menu" class="hidden md:hidden bg-white shadow-md">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition ease-in-out duration-150">Home</a>
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition ease-in-out duration-150">Hotels</a>
        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150">
            <i class="fas fa-book"></i> Book Now <!-- Font Awesome book icon -->
        </a>
    </div>
</div>
<!-- End Mobile Menu --> --}}


<!-- Content Area -->
{{-- <div class="py-10"> --}}
    @yield('content')
{{-- </div> --}}
<!-- End Content Area -->

<!-- Footer -->
{{-- <footer class="bg-gray-800 pt-10">
    <div class="max-w-7xl mx-auto">
        <div class="mt-10 border-t-2 border-gray-700 pt-6 flex justify-center items-center mb-20 py-5"> <!-- Increased margin-bottom to mb-20 -->
            <p class="text-center text-gray-400 footer-text">&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </div>
</footer> --}}

<!-- End Footer -->

<!-- JavaScript to toggle mobile menu -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>

</body>
</html>
