<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body {
            /* overflow: hidden; */
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
        }

        th {
            background: gray;
        }

        tr {
            background: white;
        }

        #butn {
            margin-top: 20px;
        }

        .bbutt {
            display: flex;
        }
    </style>
</head>

<body>
    <video id="video1" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vod.mp4') }}" type="video/mp4">
    </video>

    <video id="video2" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vidf.mp4') }}" type="video/mp4">
    </video>
    <video id="video3" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vidt.mp4') }}" type="video/mp4">
    </video>
    <video id="video4" autoplay muted loop>
        <source src="{{ url_for('static', filename='videos/vod.mp4') }}" type="video/mp4">
    </video>

    <div class="container mt-5">
        <h1 class="text-3xl font-bold mb-5">Final Results with Tax</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Year</th>
                    <th>Value</th>
                    <th>Tax</th>
                    <th>Forecast</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through results and display table rows -->
                {% for result in results %}
                <tr class="animate__animated animate__fadeInUp">
                    <td>{{ result['country'] }}</td>
                    <td>{{ result['year'] }}</td>
                    <td>{{ result['value'] }}</td>
                    <td>{{ result['tax'] }}</td>
                    <td>{{ result['forecast'] }}</td>
                </tr>
                {% endfor %}
            </tbody>
        </table>

        <h2 class="text-2xl font-bold mt-5">Graph for past trends for selected countries</h2>

        <div class="mt-3">
            <!-- Update the image source to include the correct path -->
            <img src="{{ url_for('static', filename='imgs/forecast_' + results[0]['year']|string + '.png') }}"
                alt="Emissions Trend for Selected Countries">

        </div>

        <div class="ton">
            <div class="bbutt">
                <a href="http://127.0.0.1:5004/"><button class="btn btn-primary" id="butn">Return to Calculator </button></a>
            </div>
        </div>
    </div>

    <!-- Anime.js Script for Animation -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script>
        // Animation for the table rows
        anime({
            targets: '.animate__fadeInUp',
            translateY: [50, 0],
            opacity: [0, 1],
            duration: 1000,
            delay: anime.stagger(100),
            easing: 'easeInOutQuad'
        });

        // Video swapping script
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
