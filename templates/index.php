<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login.php');
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header('Location: /login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Tax Calculator</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
            color: white; /* Set text color to white */
        }

        .car{
            justify-content: space-around;
            display: grid;
            width: 100%;


        }

        form {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .glass-effect {
            transform: scale(1.05);
        }

        .carousel-item.active {
            width: 800px;
            justify-content: space-around;
        }

        .carousel-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Carbon Tax Calculator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <!-- Logout Button -->
        <form action="/templates/logout.php" method="GET"> <!-- Changed to GET method and updated the path -->
    <button type="submit" name="logout" class="btn btn-danger mt-3">Logout</button>
</form>




        </div>
    </nav>

    <!-- Video placeholders -->
    <video id="video1" autoplay muted loop class="hidden">
        <source src="{{ url_for('static', filename='videos/vod.mp4') }}" type="video/mp4">
    </video>
    <video id="video2" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vidf.mp4') }}" type="video/mp4">
    </video>
    <video id="video3" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vidt.mp4') }}" type="video/mp4">
    </video>
    <video id="video4" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vidth.mp4') }}" type="video/mp4">
    </video>

    <div class="container mt-5">
        <h1 class="text-3xl font-bold mb-4">Carbon Tax Calculator</h1>

        <form action="/calculate_tax" method="POST">
            <div class="form-group">
                <label for="countries">Enter country names separated by commas:</label>
                <input type="text" class="form-control" id="countries" name="countries" required>
            </div>

            <div class="form-group">
                <label for="year">Enter the specific year:</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>

            <button type="submit" class="btn btn-primary">Calculate Tax</button>
        </form>

        <!-- Cards with glass effect -->
        <div class="row">
            <div class="col-md-6">
                <div class="card glass-effect">
                    <h2>Carbon Emissions Information</h2>
                    <p>Learn more about carbon emissions and their impact on the environment.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card glass-effect ml-5">
                    <h2>Donate for a Greener Earth</h2>
                    <p>Click below to contribute to environmental initiatives and support a sustainable future.</p>
                    <button class="btn btn-success">Donate</button>
                </div>
            </div>
        </div>

        <!-- Photo Carousel -->
        <div class="car">
        <div id="photoCarousel" class="carousel slide mt-5" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Photo 1 -->
                <div class="carousel-item active">
                    <img src="{{ url_for('static', filename='imgs/dan-meyers-vouoK_daWL8-unsplash.jpg') }}"
                        alt="Photo 1">
                </div>
                <!-- Photo 2 -->
                <div class="carousel-item">
                    <img src="{{ url_for('static', filename='imgs/icebear-4443364_1280.jpg') }}" alt="Photo 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ url_for('static', filename='imgs/tyler-casey-ficbiwfOPSo-unsplash.jpg') }}"
                        alt="Photo 3">
                </div>

                <!-- Add more photos as needed -->

            </div>
            <a class="carousel-control-prev" href="#photoCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel
            -control-next" href="#photoCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        </div>
       
    </div>

    <!-- Bootstrap and Tailwind JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <!-- Anime.js Script for Animation -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const videos = document.querySelectorAll('video');
            let currentVideoIndex = 0;

            function hideAllVideos() {
                videos.forEach(video => {
                    video.classList.add('hidden');
                });
            }

            function showCurrentVideo() {
                videos[currentVideoIndex].classList.remove('hidden');
            }

            function swapVideos() {
                hideAllVideos();
                currentVideoIndex = (currentVideoIndex + 1) % videos.length;
                showCurrentVideo();
            }

            // Initial setup
            hideAllVideos();
            showCurrentVideo();

            // Interval to swap videos every 5000ms (5 seconds)
            setInterval(swapVideos, 5000);

            // Animation for the form
            anime({
                targets: 'form',
                translateY: [50, 0],
                opacity: [0, 1],
                duration: 1000,
                easing: 'easeInOutQuad'
            });
        });
    </script>

</body>

</html>
