<?php
session_start();
require 'curl_helper.php';

if (!isset($_SESSION['album_id'])) {
    header("Location: index.php");
    exit();
}

$album_id = $_SESSION['album_id'];
$album_name = $_SESSION['album_name'];
$artist = $_SESSION['artist'];
$genre = $_SESSION['genre'];
$year_released = $_SESSION['year_released'];
?>

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
        .nd-back-link {
            position: absolute;
            top: 0;
            left: 1200px;
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
    <a href="index.php" class="back-link me-5"><i class="fa-solid fa-arrow-left fa-xl"></i> Back to Album Page</a>
    <a href="searchEngine.php" class="nd-back-link me-5"><i class="fa-brands fa-searchengin fa-xl"></i>Search</a>
   
    <h1 class="mb-4 mt-5">Add Songs</h1>
    <form class="form-floating" action="addSongs.php" method="POST">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="album" value="<?php echo htmlspecialchars($album_name); ?>" readonly>
            <label for="floatingInput">Album Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="artist" id="floatingArtists" value="<?php echo htmlspecialchars($artist); ?>" readonly>
            <label for="floatingArtists">Artists Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="genre" id="floatingSelect" value="<?php echo htmlspecialchars($genre); ?>" readonly>
            <label for="floatingSelect">Genre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="date" class="form-control" id="floatingdate" name="year" value="<?php echo htmlspecialchars($year_released); ?>" readonly>
            <label for="floatingdate">Date Released</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingTitle" name="title" placeholder="Title" required>
            <label for="floatingTitle">Title</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="audio" id="floatingAudio" placeholder="Audio File" required>
            <label for="floatingAudio">Audio File</label>
        </div>
        <input type="hidden" name="song_id" id="song_id">
        <div class="col-auto">
            <button type="submit" name="addSongs" id="addBtn" class="btn btn-primary w-100 p-3 my-5">Add Songs</button>
            <hr>
       
            </div>
    </form>
    
    <?php
    $url = "http://localhost/DARANG-LAB_ACTIVITY3/";
    $songs_response = curlCall($url, "GET", null, $album_id, 'songs');

    $songs = [];
    if ($songs_response && isset($songs_response->status) && $songs_response->status == 200) {
        $songs = $songs_response->data;
    }
    ?>
    <h2 class="mt-5">Songs in Album</h2>
    <table class="table table-striped mb-5">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Audio File</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($songs) > 0): ?>
                <?php foreach ($songs as $song): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($song->title); ?></td>
                        <td><?php echo htmlspecialchars($song->audio_file); ?></td>
                        <td>
                            <a href="#" class="me-3 edit-song" data-id="<?php echo $song->song_id; ?>" data-title="<?php echo htmlspecialchars($song->title); ?>" data-audio="<?php echo htmlspecialchars($song->audio_file); ?>">Edit</a>
                            <a href="#" class="delete-song" data-id="<?php echo $song->song_id; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No songs in this album.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/50d7261171.js" crossorigin="anonymous"></script>
<script>
document.querySelectorAll('.edit-song').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var songId = this.getAttribute('data-id');
        var title = this.getAttribute('data-title');
        var audio = this.getAttribute('data-audio');
        document.getElementById('floatingTitle').value = title;
        document.getElementById('floatingAudio').value = audio;
        document.getElementById('song_id').value = songId; 
        document.querySelector('button[name="addSongs"]').innerText = "Update Song";
        document.querySelector('button[name="addSongs"]').setAttribute('name', 'updateSongs');
    });
});

document.querySelectorAll('.delete-song').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var songId = this.getAttribute('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('deleteSong.php?id=' + songId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        Swal.fire('Success', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Failed to delete song.', 'error');
                });
            }
        });
    });
});
</script>



</body>
</html>

<?php
if (isset($_POST['addSongs'])) {
    $song_data = array(
        "album_id" => $album_id,
        "title" => $_POST['title'],
        "audio" => $_POST['audio']
    );

    $song_response = curlCall($url, "POST", $song_data, null, 'songs');

    if ($song_response && isset($song_response->status) && $song_response->status == 201) {
        echo "<script>
                Swal.fire('Success', '{$song_response->message}', 'success').then(function() {
                    window.location.href = 'addSongs.php';
                });
              </script>";
        exit();
    } else {
        echo "<script>Swal.fire('Error', 'Failed to add song.', 'error');</script>";
    }
} else if (isset($_POST['updateSongs'])) {
    if (isset($_POST['song_id']) && !empty($_POST['song_id']) && isset($_POST['title']) && isset($_POST['audio'])) {
        $song_data = array(
            "id" => $_POST['song_id'],
            "title" => $_POST['title'],
            "audio" => $_POST['audio']
        );

        //CALLING THE FUNCTION IN CURL_HELPER
        $song_response = curlCall($url, "PUT", $song_data, null, 'songs');

        //CHECK THE RESPONSE
        if ($song_response && isset($song_response->status)) {
            if ($song_response->status == 200) {
                echo "<script>
                    Swal.fire('Success', '{$song_response->message}', 'success').then(function() {
                            window.location.href = 'addSongs.php';
                    });
            </script>";
                exit();
            } else {
                echo "<script>Swal.fire('Error', '{$song_response->message}', 'error');</script>";
            }
        } else {
            echo "<script>Swal.fire('Error', 'Failed to update song.', 'error');</script>";
        }
    } else {
        echo "<script>Swal.fire('Error', 'Missing or empty data for updating song.', 'error');</script>";
    }
}

?>

