// Initialize and add the map
function initMap() {
    // The location of fleet
    const fleet = { lat: 59.422, lng: 24.802 };
    // The map, centered at fleet
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: fleet,
    });
    // The marker, positioned at fleet
    const marker = new google.maps.Marker({
        position: fleet,
        map: map,
    });


}