var app = angular.module('app', []);
app.controller('appController', function ($http) {

    var vm = this;
    vm.objects = [];
    vm.objectsMarkers = [];
    vm.error = "";

    var bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();

    vm.getObjects = function (link) {
        $http.get(link).then(function(response){
            vm.jsonData = response.data.response;
            $http.post('ObjectsController.php', vm.jsonData).then(function (response) {
                if (response.data) {
                    vm.objects = response.data;
                    vm.objectsMarkers = vm.getObjectsMarkers(vm.objects);
                    vm.showMarkersOnMap(vm.objectsMarkers);
                }
            });
        });
    };

    $('#objectsTable').on('click', '.clickable-row', function(event) {
        if($(this).hasClass('info')){
            $(this).removeClass('info');
        } else {
            $(this).addClass('info').siblings().removeClass('info');
        }
    });

    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    vm.getObjectsMarkers = function(items) {
        var mapPoints = [];
        angular.forEach(items, function (item) {
            if (item.latitude && item.longitude) {
                obj = [item.latitude, item.longitude, item.objectName, item.driverName];
            }
            mapPoints.push(obj);
        });
        return mapPoints;
    };

    function initMap() {
        // The location of fleetComplete
        const fleetComplete = {lat: 59.422, lng: 24.802};
        // The map, centered at fleetComplete
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: fleetComplete,
        });
        // The marker, positioned at fleetComplete
        const marker = new google.maps.Marker({
            position: fleetComplete,
            map: map,
        });
    }

    vm.setSelectedObject = function (object) {
      vm.selectedObjectId = object.objectId;
    };

    vm.getObjectData = function () {
        vm.objectData = [];
        vm.error = "";
        var beginDate = window.document.getElementById("eventDate").value;
        var objectId = vm.selectedObjectId;

        if (objectId) {
            if (beginDate) {
                var endDate = new Date(beginDate);
                endDate = (endDate.setDate(endDate.getDate() + 1));
                endDate = new Date(endDate).toISOString().slice(0, 10);

                var link = 'https://app.ecofleet.com/seeme/Api/Vehicles/getRawData?objectId=' + objectId + '&begTimestamp=' + beginDate + '&endTimestamp=' + endDate + '&key=home.assignment.2-1230927&json';

                $http.get(link).then(function (response) {
                    vm.objectData = response.data.response;
                    vm.objectStops = vm.getObjectStops(vm.objectData);
                    vm.calculateTotalDistance(vm.objectStops);
                    var objectMarkers = vm.getObjectMarkers(vm.objectStops);
                    vm.showMarkersOnMap(objectMarkers, vm.objectData);
                    if (vm.objectStops.length > 0) {
                        vm.error = "";
                    } else {
                        vm.error = "No related object data to display available!";
                    }
                });
            } else {
                vm.error = "Please choose the date!";
            }
        } else {
            vm.error = "Please choose the object!";
        }
    };

    vm.getObjectStops = function (items) {
        var objectStops = [];
        var previousItemDistance = 0;
        angular.forEach(items, function (item) {
            if (item.EngineStatus !== '1' && (item.Distance > previousItemDistance)) {
                objectStops.push(item);
                previousItemDistance = item.Distance;
            }
        });
        return objectStops;
    };

    vm.calculateTotalDistance = function (array) {
        vm.totalDistance = 0;
        if (array.length > 0) {
            var firstArrayItem = array[0];
            var lastArrayItem = array.slice(-1)[0];
            vm.totalDistance = Math.round(lastArrayItem.Distance - firstArrayItem.Distance);
        }
    };

    vm.getObjectMarkers = function (items) {
        var mapPoints = [];
        angular.forEach(items, function (item) {
            if (item.Latitude && item.Longitude) {
                obj = [item.Latitude, item.Longitude];
            }
            mapPoints.push(obj);
        });
        return mapPoints;
    };

    vm.showMarkersOnMap = function (locations, polylinePoints) {
        const map = new google.maps.Map(document.getElementById("map"), {
        });

        if (map.getZoom() > 16) map.setZoom(16);

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng( locations[i][0], locations[i][1]),
                map: map,
            });

            bounds.extend(marker.position);

            google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                if (locations[i][2] || locations[i][3]) {
                    return function() {
                        infowindow.setContent(locations[i][2] + '<br/>' + locations[i][3]);
                        infowindow.open(map, marker);
                    }
                }
            })(marker, i));
        }

        map.fitBounds(bounds);

        var listener = google.maps.event.addListener(map, "idle", function () {
            if (map.getZoom() > 16) map.setZoom(16);
            google.maps.event.removeListener(listener);
        });

        if (polylinePoints) {
            var destinations = [];
            angular.forEach(polylinePoints, function (polylinePoint) {
                if (polylinePoint.Latitude && polylinePoint.Longitude) {
                    destinations.push(new google.maps.LatLng(polylinePoint.Latitude, polylinePoint.Longitude));
                }
            });

            var polylineOptions = {
                path:destinations,
                strokeColor:"#ffff00",
                strokeWeight:2
            };
            
            var polyline = new google.maps.Polyline(polylineOptions);
            polyline.setMap(map);
        }
    };

    init();

    function init() {
        initMap();
    }

});