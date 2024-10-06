<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="front-pages">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Welcome</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/pages/front-page-landing.css" />
    <style>
        .hero-image img {
            width: 500px; /* Adjust the width to a medium size */
            height: auto; /* Maintain aspect ratio */
        }
        .hero-text-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center text horizontally */
            text-align: center; /* Center text alignment */
        }
        .landing-hero {
            display: flex;
            align-items: center; /* Center content vertically */
            justify-content: center; /* Center content horizontally */
            height: 100vh; /* Full viewport height */
        }
    </style>
</head>

<body>
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <div class="container d-flex flex-row"> <!-- Flex container -->
                    <div class="hero-image me-4"> <!-- Image container -->
                        <img src="../../assets/img/front-pages/landing-page/boy-with-laptop-light.png" alt="hero dashboard" class="animation-img" data-app-light-img="front-pages/landing-page/boy-with-laptop-light.png" />
                    </div>
                    <div class="hero-text-box"> <!-- Text container -->
                        <h1 class="text-primary hero-title display-6 fw-bold">One dashboard to manage all your Documentations</h1>
                        <h2 class="hero-sub-title h6 mb-4 pb-1">
                            Organize your work with precision and <br class="d-none d-lg-block" />
                            Own Your Time.
                        </h2>
                        <div class="relative sm:flex sm:justify-center sm:items-center">
                            @if (Route::has('login'))
                                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                                    @else
                                        <div class="flex flex-col space-y-4">
                                            <a href="{{ route('login') }}" class="btn btn-primary font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="btn btn-secondary font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                            @endif
                                        </div>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero: End -->
    </div>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
</body>
</html>
