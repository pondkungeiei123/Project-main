<!DOCTYPE html>
<html>

<head>
<title>Places Search Box</title>
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <style>
                #map {
                    height: 30vh;
                }

                html,
                body {
                    height: 100%;
                    margin: 0;
                    padding: 0;
                }

                #description {
                    font-family: Roboto;
                    font-size: 15px;
                    font-weight: 300;
                }

                #infowindow-content .title {
                    font-weight: bold;
                }

                #infowindow-content {
                    display: none;
                }

                #map #infowindow-content {
                    display: inline;
                }

                .pac-card {
                    background-color: #fff;
                    border: 0;
                    border-radius: 2px;
                    box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                    margin: 10px;
                    padding: 0 0.5em;
                    font: 400 18px Roboto, Arial, sans-serif;
                    overflow: hidden;
                    font-family: Roboto;
                    padding: 0;
                }

                #pac-container {
                    padding-bottom: 12px;
                    margin-right: 12px;
                }

                .pac-controls {
                    display: inline-block;
                    padding: 5px 11px;
                }

                .pac-controls label {
                    font-family: Roboto;
                    font-size: 13px;
                    font-weight: 300;
                }

                #pac-input {
                    background-color: #fff;
                    font-family: Roboto;
                    font-size: 15px;
                    font-weight: 300;
                    margin-left: 12px;
                    padding: 0 11px 0 13px;
                    text-overflow: ellipsis;
                    width: 400px;
                }

                #pac-input:focus {
                    border-color: #4d90fe;
                }

                #title {
                    color: #fff;
                    background-color: #4d90fe;
                    font-size: 25px;
                    font-weight: 500;
                    padding: 6px 12px;
                }

                #target {
                    width: 345px;
                }
            </style>
            </head>

            <body>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
                <div id="map"></div>
                <input id="latitudeInput" type="text" placeholder="Latitude" name="user_latitude" readonly />
                <input id="longitudeInput" type="text" placeholder="Longitude" name="user_longitude" readonly />

                <button onclick="getLocation()">ปักหมุด</button>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDELcj3pYg5wJLF_spRgzdz8EAjY-v85QY&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
                <script>
                    let map;
                    let marker;

                    function initAutocomplete() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: {
                                lat: -33.8688,
                                lng: 151.2195
                            },
                            zoom: 13,
                            mapTypeId: "roadmap",
                        });
                        const input = document.getElementById("pac-input");
                        const searchBox = new google.maps.places.SearchBox(input);

                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                        map.addListener("bounds_changed", () => {
                            searchBox.setBounds(map.getBounds());
                        });

                        searchBox.addListener("places_changed", () => {
                            const places = searchBox.getPlaces();

                            if (places.length == 0) {
                                return;
                            }

                            // Remove previous marker, if any
                            if (marker) {
                                marker.setMap(null);
                            }

                            const bounds = new google.maps.LatLngBounds();

                            places.forEach((place) => {
                                if (!place.geometry || !place.geometry.location) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }

                                marker = new google.maps.Marker({
                                    map,
                                    title: place.name,
                                    position: place.geometry.location,
                                    draggable: true, // Make the marker draggable
                                });

                                google.maps.event.addListener(marker, "dragend", function() {
                                    document.getElementById("latitudeInput").value =
                                        marker.getPosition().lat();
                                    document.getElementById("longitudeInput").value =
                                        marker.getPosition().lng();
                                });

                                google.maps.event.addListener(marker, "click", function() {
                                    document.getElementById("latitudeInput").value =
                                        marker.getPosition().lat();
                                    document.getElementById("longitudeInput").value =
                                        marker.getPosition().lng();
                                });

                                if (place.geometry.viewport) {
                                    bounds.union(place.geometry.viewport);
                                } else {
                                    bounds.extend(place.geometry.location);
                                }
                            });
                            map.fitBounds(bounds);
                        });
                    }

                    window.initAutocomplete = initAutocomplete;

                    function getLocation() {
                        if (marker) {
                            document.getElementById("latitudeInput").value =
                                marker.getPosition().lat();
                            document.getElementById("longitudeInput").value =
                                marker.getPosition().lng();
                        } else {
                            alert("No marker available.");
                        }
                    }
                </script>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-success" onclick="submitForm()">ส่งใบสมัคร</button>
        </div>
    </div>
</div>
</body>

</html>