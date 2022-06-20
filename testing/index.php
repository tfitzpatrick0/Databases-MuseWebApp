<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Web API Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="testing.js"></script>
</head>

<body onload="onPageLoad()">
    <div class="container">

        <div id="tokenSection" class="row">
            <div class="col">
                <input class="btn btn-primary btn-lg" type="button" onclick="requestAuthorization()" value="Request Authorization"><br/>
            </div>
        </div>

        <div id="spotifySection" class="row">
            <div class="col">

                <div class="mb-3">
                    <label for="playlists" class="form-label">Playlists</label>
                    <select id="playlists" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshPlaylists()" value="Refresh Playlists">
                </div>

                <div class="mb-3">
                    <label for="songs" class="form-label">Songs</label>
                    <select id="songs" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="displaySongs()" value="Display Songs">
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="delSongFromPL()" value="Delete From Playlist">
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="showSimilarSongs()" value="Show Similar Songs">
                </div>

                <div class="mb-3">
                    <table id="simsongs"></table>
                </div>

                <div class="mb-3">
                    <label for="songAttrs" class="form-label">Song Attributes</label>
                    <select id="songAttrs" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="getSongAttr()" value="Get Song Attributes">
                </div>

                <div class="mb-3">
                    <label for="plName" class="form-label">Create Playlist</label>
                    <input type="text" class="form-control" id="plName" placeholder="">
                    <input type="text" class="form-control" id="plDesc" placeholder="">
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="createPL()" value="Create Playlist">
                </div>

                <div class="mb-3">
                    <label for="songId" class="form-label">Song ID</label>
                    <input type="text" class="form-control" id="songId" placeholder="">
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="addSongToPL()" value="Add To Playlist">
                </div>

                <div class="mb-3">
                    <label for="artistId" class="form-label">Follow Artist</label>
                    <input type="text" class="form-control" id="artistId" placeholder="">
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="followArtist()" value="Follow Artist">
                </div>

                <div class="mb-3">
                    <label for="devices" class="form-label">Devices</label>
                    <select id="devices" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshDevices()" value="Refresh Devices">
                </div>

                <div class="row">
                    <div class="col">
                        <input type="button" class="btn btn-dark" onclick="play()" value="Play">
                        <input type="button" class="btn btn-dark" onclick="pause()" value="Pause">
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>