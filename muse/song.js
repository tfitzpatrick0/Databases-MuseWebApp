var redirect_uri = "http://local.muse/";

// var client_id = "094baaf717e948fc8ea9796c36c98fb7";
// var client_secret = "f9bde4669bb549aba1eba857be63b783";
var client_id = "41a7eeddd27f4614ad05359d0043a201";
var client_secret = "41d4686cab51498f89c26b1aff0426e6";

var access_token = null;
var refresh_token = null;
var current_playlist = "";
var current_artist_id = "";
var user_id = "";

const AUTHORIZE = "https://accounts.spotify.com/authorize";
const TOKEN = "https://accounts.spotify.com/api/token";

const USER = "https://api.spotify.com/v1/me";
const ADDPLAYLIST = "https://api.spotify.com/v1/users/{{UserId}}/playlists";
const SEARCH = "https://api.spotify.com/v1/search";
const PLAYLISTS = "https://api.spotify.com/v1/me/playlists";
const TRACKS = "https://api.spotify.com/v1/playlists/{{PlaylistId}}/tracks";
const TRACKBYID = "https://api.spotify.com/v1/tracks/{{SongId}}";
const TOPTRACKS = "https://api.spotify.com/v1/artists/{{ArtistId}}/top-tracks";
const RELARTISTS =
  "https://api.spotify.com/v1/artists/{{ArtistId}}/related-artists";
const FOLLOWING = "https://api.spotify.com/v1/me/following";
const AUDIOFEATURES = "https://api.spotify.com/v1/audio-features/{{SongId}}";
const DEVICES = "https://api.spotify.com/v1/me/player/devices";
const PLAYER = "https://api.spotify.com/v1/me/player";
const PLAY = "https://api.spotify.com/v1/me/player/play";
const PAUSE = "https://api.spotify.com/v1/me/player/pause";

function onPageLoad(artist) {
  localStorage.setItem("client_id", client_id);
  localStorage.setItem("client_secret", client_secret);

  access_token = localStorage.getItem("access_token");
  refresh_token = localStorage.getItem("refresh_token");

  let song = document.getElementById("songName").value;

  // console.log(artist[0]);
  console.log(song);

  if (access_token != null) {
    getUserInfo();
    refreshPlaylists();
    getSongAttr();
    searchArtist(artist, "artist");
  }
}

function handleRedirect() {
  let code = getCode();
  fetchAccessToken(code);
  window.history.pushState("", "", redirect_uri); // remove param from url
}

function getCode() {
  let code = null;
  const queryString = window.location.search;
  if (queryString.length > 0) {
    const urlParams = new URLSearchParams(queryString);
    code = urlParams.get("code");
  }
  return code;
}

function requestAuthorization() {
  let url = AUTHORIZE;
  url += "?client_id=" + client_id;
  url += "&response_type=code";
  url += "&redirect_uri=" + encodeURI(redirect_uri);
  url += "&show_dialog=true";
  url +=
    "&scope=user-read-private user-read-email user-modify-playback-state user-read-playback-position user-library-read user-read-playback-state user-read-recently-played user-follow-modify playlist-read-private playlist-modify playlist-modify-private";
  window.location.href = url; // Show Spotify's authorization screen
}

function fetchAccessToken(code) {
  let body = "grant_type=authorization_code";
  body += "&code=" + code;
  body += "&redirect_uri=" + encodeURI(redirect_uri);
  body += "&client_id=" + client_id;
  body += "&client_secret=" + client_secret;
  callAuthorizationApi(body);
}

function refreshAccessToken() {
  refresh_token = localStorage.getItem("refresh_token");
  let body = "grant_type=refresh_token";
  body += "&refresh_token=" + refresh_token;
  body += "&client_id=" + client_id;
  callAuthorizationApi(body);
}

function callAuthorizationApi(body) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", TOKEN, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.setRequestHeader(
    "Authorization",
    "Basic " + btoa(client_id + ":" + client_secret)
  );
  xhr.send(body);
  xhr.onload = handleAuthorizationResponse;
}

function handleAuthorizationResponse() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    var data = JSON.parse(this.responseText);

    if (data.access_token != undefined) {
      access_token = data.access_token;
      localStorage.setItem("access_token", access_token);
    }
    if (data.refresh_token != undefined) {
      refresh_token = data.refresh_token;
      localStorage.setItem("refresh_token", refresh_token);
    }
    onPageLoad();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

/**********************************************************
/
/
/
/
/
/        HTTP request/response with Spotify API
/
/
/
/
/
**********************************************************/

// Call Spotify API

function callApi(method, url, body, callback) {
  let xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.setRequestHeader("Authorization", "Bearer " + access_token);
  xhr.send(body);
  xhr.onload = callback;
}

// Search functions

function searchArtist(param, t) {
  callApi(
    "GET",
    SEARCH + "?q=" + param + "&type=" + t,
    null,
    handleSearchArtist
  );
}

function handleSearchArtist() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    addArtistId(data);

    handle = "searched";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function addArtistId(data) {
  artist_id = data.artists.items[0].id;
  console.log(artist_id);
  element = document.getElementById("artistId");
  element.value = artist_id;
}

function searchAlbum(param, t) {
  callApi(
    "GET",
    SEARCH + "?q=" + param + "&type=" + t,
    null,
    handleSearchAlbum
  );
}

function handleSearchAlbum() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    addAlbumId(data);

    handle = "searched";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function addAlbumId(data) {
  album_id = data.albums.items[0].id;
  console.log(album_id);
  element = document.getElementById("albumId");
  element.value = album_id;
}

// Remove all items from dropdown field

function removeAllItems(elementId) {
  let node = document.getElementById(elementId);
  while (node.firstChild) {
    node.removeChild(node.firstChild);
  }
}

// Create table header

function tableHeader() {
  removeAllItems("simsongs");

  let th_row = document.createElement("tr");
  let song_heading = document.createElement("th");
  let artist_heading = document.createElement("th");

  song_heading.innerHTML = "Song";
  artist_heading.innerHTML = "Artist";

  th_row.appendChild(song_heading);
  th_row.appendChild(artist_heading);

  document.getElementById("simsongs").appendChild(th_row);
}

function tableBody(song, artist) {
  let th_row = document.createElement("tr");
  let song_body = document.createElement("td");
  let artist_body = document.createElement("td");

  song_body.innerHTML = song;
  artist_body.innerHTML = artist;

  th_row.appendChild(song_body);
  th_row.appendChild(artist_body);

  document.getElementById("simsongs").appendChild(th_row);
}

// Get current user info

function getUserInfo() {
  callApi("GET", USER, null, handleGetUserInfo);
}

function handleGetUserInfo() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data.id);
    user_id = data.id;

    handle = "got user info";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Display playlists

function refreshPlaylists() {
  callApi("GET", PLAYLISTS, null, handleRefreshPlaylists);
}

function handleRefreshPlaylists() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    removeAllItems("playlists");
    data.items.forEach((item) => dropdownPlaylists(item));

    handle = "playlists in dropdown";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function dropdownPlaylists(item) {
  let node = document.createElement("option");
  node.value = item.id;
  node.innerHTML = item.name + " [" + item.tracks.total + " songs]";
  document.getElementById("playlists").appendChild(node);
}

// Display songs in selected playlist

function displaySongs() {
  let playlist_id = document.getElementById("playlists").value;
  if (playlist_id.length > 0) {
    let url = TRACKS.replace("{{PlaylistId}}", playlist_id);
    callApi("GET", url, null, handleDisplaySongs);
  }
}

function handleDisplaySongs() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    removeAllItems("songs");
    data.items.forEach((item) => dropdownSongs(item));

    handle = "songs in dropdown";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function dropdownSongs(item) {
  let node = document.createElement("option");
  node.value = item.track.id;
  node.innerHTML = item.track.name + " | " + item.track.artists[0].name;
  document.getElementById("songs").appendChild(node);
}

// Show similar songs to the selected song

function showSimilarSongs() {
  artist_id = document.getElementById("artistId").value;
  let url = RELARTISTS.replace("{{ArtistId}}", artist_id);

  callApi("GET", url, null, handleSimSongs);
}

function handleSimSongs() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    tableHeader();

    for (let i = 0; i < 5; i++) {
      //console.log(data.artists[i].name);
      //console.log(data.artists[i].id);
      topSong(data.artists[i]);
    }

    handle = "showing similar songs";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Get song name

function getArtistId() {
  let song_id = document.getElementById("songs").value;

  if (song_id.length > 0) {
    let url = TRACKBYID.replace("{{SongId}}", song_id);
    callApi("GET", url, null, handleGetArtistId);
  }
}

function handleGetArtistId() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    current_artist_id = data.artists[0].id;

    handle = "got artist ID from song ID";
    console.log(data.artists[0].name);
    console.log(current_artist_id);
    console.log(handle);

    showSimilarSongs();
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Get top song from artist

function topSong(artist) {
  let artist_id = artist.id;

  if (artist_id.length > 0) {
    let url = TOPTRACKS.replace("{{ArtistId}}", artist_id);
    callApi("GET", url + "?market=US", null, handleTopSong);
  }
}

function handleTopSong() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);

    let song = data.tracks[0].name;
    let artist = data.tracks[0].artists[0].name;
    tableBody(song, artist);

    handle = "got artist top song";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Add song to selected playlist

function addSongToPL() {
  let playlist_id = document.getElementById("playlists").value;

  if (playlist_id.length > 0) {
    let url = TRACKS.replace("{{PlaylistId}}", playlist_id);
    let song_id = document.getElementById("songId").value;

    if (song_id.length > 0) {
      callApi(
        "POST",
        url + "?uris=spotify:track:" + song_id,
        null,
        handleAddSong
      );
    }
  }
}

function handleAddSong() {
  if (this.status == 201) {
    handle = "song added";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Delete song from selected playlist
// body format: { "tracks": [{ "uri": "song_id" }] }

function delSongFromPL() {
  let playlist_id = document.getElementById("playlists").value;

  if (playlist_id.length > 0) {
    let url = TRACKS.replace("{{PlaylistId}}", playlist_id);
    let song_id = document.getElementById("songId").value;

    if (song_id.length > 0) {
      let body = '{"tracks": [{"uri": "spotify:track:' + song_id + '"}]}';
      callApi("DELETE", url, body, handleDelSong);
    }
  }
}

function handleDelSong() {
  if (this.status == 200) {
    handle = "song deleted";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Get Song Attributes

function getSongAttr() {
  let song_id = document.getElementById("songId").value;

  if (song_id.length > 0) {
    let url = AUDIOFEATURES.replace("{{SongId}}", song_id);
    callApi("GET", url, null, handleGetSongAttr);
  }
}

function handleGetSongAttr() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    removeAllItems("songAttrs");
    Object.entries(data).forEach((item, index) =>
      dropdownAttributes(item, index)
    );

    handle = "got song attributes";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function dropdownAttributes(item, index) {
  let node = document.createElement("option");
  node.value = index;
  const [key, value] = item;
  node.innerHTML = `${key}: ${value}`;
  document.getElementById("songAttrs").appendChild(node);

  let attr = document.createElement("input");
  attr.type = "hidden";
  attr.id = `${key}`;
  attr.value = `${value}`;
  document.getElementById("songAttrs").append(attr);
}

// Create new playlist

function createPL() {
  let pl_name = document.getElementById("plName").value;
  let pl_desc = document.getElementById("plDesc").value;

  if (pl_name.length > 0 && pl_desc.length > 0) {
    let url = ADDPLAYLIST.replace("{{UserId}}", user_id);
    let body =
      '{"name": "' +
      pl_name +
      '", "description": "' +
      pl_desc +
      '", "public": false}';
    callApi("POST", url, body, handleCreatePL);
  }
}

function handleCreatePL() {
  if (this.status == 200) {
    handle = "playlist created";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Follow artist

function followArtist() {
  let artist_id = document.getElementById("artistId").value;

  if (artist_id.length > 0) {
    callApi(
      "PUT",
      FOLLOWING + "?type=artist&ids=" + artist_id,
      null,
      handleFllwArtist
    );
  }
}

function handleFllwArtist() {
  if (this.status == 204) {
    handle = "artist followed";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

// Display devices

function refreshDevices() {
  callApi("GET", DEVICES, null, handleRefreshDevices);
}

function handleRefreshDevices() {
  if (this.status == 200) {
    var data = JSON.parse(this.responseText);
    console.log(data);
    removeAllItems("devices");
    data.devices.forEach((item) => addDevice(item));

    handle = "devices refreshed";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}

function addDevice(item) {
  let node = document.createElement("option");
  node.value = item.id;
  node.innerHTML = item.name;
  document.getElementById("devices").appendChild(node);
}

// Play and pause a song

function getDeviceId() {
  return document.getElementById("devices").value;
}

function play() {
  // play song
  let album_id = document.getElementById("albumId").value;
  let position = document.getElementById("trackNum").value;

  let body = {};
  body.context_uri = "spotify:album:" + album_id;
  body.offset = {};
  body.offset.position = position - 1;
  body.position_ms = 0;

  console.log(body);

  callApi(
    "PUT",
    PLAY + "?device_id=" + getDeviceId(),
    JSON.stringify(body),
    handleAudio
  );
}

function playFromPL() {
  // play song from playlist
  let album_id = document.getElementById("albumId").value;
  let song_id = document.getElementById("songId").value;
  let song_index = 0;

  for (var i = 0; i < songs.length; i++) {
    if (songs.options[i].value == song_id) {
      song_index = songs.options[i].index;
      break;
    }
  }

  let body = {};
  body.context_uri = "spotify:album:" + album_id;
  body.offset = {};
  body.offset.position = song_index;
  body.position_ms = 0;

  console.log(body);

  callApi(
    "PUT",
    PLAY + "?device_id=" + getDeviceId(),
    JSON.stringify(body),
    handleAudio
  );
}

function pause() {
  // pause song
  callApi("PUT", PAUSE + "?device_id=" + getDeviceId(), null, handleAudio);
}

function handleAudio() {
  if (this.status == 200 || this.status == 204) {
    handle = "audio";
    console.log(handle);
  } else if (this.status == 401) {
    refreshAccessToken();
  } else {
    console.log(this.responseText);
    alert(this.responseText);
  }
}
