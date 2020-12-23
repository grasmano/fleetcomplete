<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="css/googleMaps.css"/>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/99a385c1/markerclustererplus/src/markerclusterer.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="js/appController.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<div ng-app="app">
    <div ng-controller="appController as vm">
        <div class="row justify-content-lg" style="display: flex; justify-content: center;">
            <div class="col-md-10">
                <div class="portlet portlet-boxed">
                    <div class="portlet-header">
                        <h3 class="portlet-title" style="display: flex; justify-content: center;">Test task for the
                            software developer candidate in Fleet Complete</h3>
                        <h3 class="portlet-title" style="display: flex; justify-content: center;">(developed by Oleg
                            Grasman)</h3>
                    </div>
                    <br/>
                    <div class="portlet-body">
                        <div class="row form-group">
                            <label class="control-label col-md-1">API key:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control input-sm" ng-model="vm.apiLink"
                                       placeholder="(api key goes here)">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-secondary btn-sm pull-right" type="button"
                                        ng-click="vm.getObjects(vm.apiLink)">Go
                                </button>
                            </div>
                        </div>
                        <hr/>
                        <div class="row form-group">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="objectsTable" class="table table-bordered table-hover table-striped">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Speed</th>
                                                <th>Last update</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="object in vm.objects track by $index"
                                                ng-if="vm.objects.length > 0" class="clickable-row"
                                                id="object_{{index}}" ng-click="vm.setSelectedObject(object)" ;>
                                                <td>{{object.objectName}}</td>
                                                <td>{{object.speed}} km/h</td>
                                                <td>{{object.lastUpdate}} ago</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>&nbsp;
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <label class="control-label col-md-2">Date:</label>
                                            <div class="col-md-6">
                                                <div class="input-group" id="datetimepicker">
                                                    <input type="text" class="form-control" ng-model="vm.eventDate"
                                                           id="eventDate"/>
                                                    <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-secondary btn-sm pull-right" type="button"
                                                        ng-click="vm.getObjectData();">Go
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <td>Total distance</td>
                                                <td width="150px">{{vm.totalDistance}} km</td>
                                            </tr>
                                            <tr>
                                                <td>Number of stops</td>
                                                <td width="150px">{{vm.objectStops.length}}</td>
                                            </tr>
                                            <tr>
                                                <td>Shortest possible distance</td>
                                                <td width="150px"> km</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <div class="col-md-12 bg-danger" ng-if="vm.error"><h4 class="portlet-title" style="display: flex; justify-content: center;">{{vm.error}}</h4></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5QUN_u_crl7j6avm-EDzmgxD-yb5P9o4&callback=initMap&libraries=drawing,geometry&v=weekly" defer></script>
</body>
</html>
