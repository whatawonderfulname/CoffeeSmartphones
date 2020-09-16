let map;

// initialize a google maps map
function initializeMap() {
  let ourLocation = {
    lat: 48.209478,
    lng: 16.369461
  };

  let map = new google.maps.Map(document.getElementById("map"), {
    center: ourLocation,
    zoom: 18
  });

  let pinpoint = new google.maps.Marker({
    position: ourLocation,
    map: map
  });
}