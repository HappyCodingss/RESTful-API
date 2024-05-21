<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <title>SoundNEXUS</title>
    <style>
         .back-link {
            position: absolute;
            top: 0;
            left: 600px;
            margin-top: 50px;
            margin-left: 10px;
        }
        .container {
            display: grid;
            place-items: center;
            margin-top: 50px;
            width: 700px;
        }
        form, .col-auto {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="addSongs.php" class="back-link"><i class="fa-solid fa-arrow-left fa-xl"></i>Back to Add Songs</a>
        <h1 class="mb-5 mt-5">Search Engine</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" class="me-2" name="input">
            <input type="checkbox" value="artist" id="artist" name="artist">
            <label for="artist" class="me-2">Artist</label>
            <input type="checkbox" value="genre" id="genre" name="genre">
            <label for="genre" class="me-2">Genre</label>
            <input type="checkbox" value="album" id="album" name="album">
            <label for="album" class="me-2">Album</label>
            <input type="submit" name="search" value="Search" class="btn btn-primary">
        </form>
        
        <?php 
        require 'api/dbconn.php';

        function getYouTubeEmbedUrl($url) {
            parse_str(parse_url($url, PHP_URL_QUERY), $urlParams);
            return isset($urlParams['v']) ? 'https://www.youtube.com/embed/' . $urlParams['v'] : null;
        }

        if(isset($_POST['search'])) {
            $input = $_POST['input'];
            $artistChecked = isset($_POST['artist']) ? true : false;
            $genreChecked = isset($_POST['genre']) ? true : false;
            $albumChecked = isset($_POST['album']) ? true : false;

            $sql = "SELECT album.*, songs.title AS song_title, songs.audio_file AS song_audio 
                    FROM `album` 
                    LEFT JOIN `songs` ON album.album_id = songs.album_id 
                    WHERE ";
            $conditions = [];

            if ($artistChecked) {
                $conditions[] = "album.artist LIKE '%$input%'";
            }

            if ($genreChecked) {
                $conditions[] = "album.genre LIKE '%$input%'";
            }

            if ($albumChecked) {
                $conditions[] = "album.album_name LIKE '%$input%'";
            }

            if (!empty($conditions)) {
                $sql .= implode(" OR ", $conditions);
            } else {
                $sql .= "1";
            }

            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($data = $result->fetch_assoc()){ 
                    $embedUrl = getYouTubeEmbedUrl($data["song_audio"]);
                    ?>
                    <div class="search mt-5 w-100 h-100">
                        <div class="row">
                            <div class="col ps-5 pt-3"><h6 class="">Album: <?php echo $data['album_name']; ?></h6></div>
                        </div>
                        <div class="row mt-4">
                            <div class="col ps-5"><h6 class="">Artist: <?php echo $data['artist']; ?></h6></div>
                            <div class="col"><h6 class="">Genre: <?php echo $data['genre']; ?></h6></div>
                            <div class="col"><h6 class="">Year Released: <?php echo $data['year_released']; ?></h6></div>
                        </div>
                        <div class="row mt-4">
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th class="text-center border border-dark p-3">Song Title</th>
                                        <th class="text-center border border-dark p-3">Stream Audio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-dark ps-2 fw-bold"><?php echo $data["song_title"]; ?></td>
                                        <td class="border border-dark text-center py-3">
                                            <?php if ($embedUrl): ?>
                                                <iframe width="400" height="300" src="<?php echo $embedUrl; ?>?autoplay=1&controls=1" onerror="this.onerror=null; this.parentElement.innerHTML='Audio not available.';"></iframe>
                                            <?php else: ?>
                                                <div>Audio not available.</div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    </div>
                <?php
                }
            } else {
                echo "<p>No results found.</p>";
            }
        }
        ?>
    </div>
    <script src="https://kit.fontawesome.com/50d7261171.js" crossorigin="anonymous"></script>
</body>
</html>
