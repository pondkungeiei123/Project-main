<?php

ob_start();
?>
<br>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fe9f6005">
    <h2> รายชื่อพนักงาน</h2>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    เพิ่มข้อมูล
                </button>
            </li>
        </ul>
    </div>
</nav>
<!-- Your page-specific content -->

<!-- Add a title here -->
<div class="container">
    <div class="row">
        <div class="col-md-12"> <br>
            <h3> </h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="40%">ชื่อ</th>
                        <th width="45%">นามสกุล</th>
                        <th width="5%">แก้ไข</th>
                        <th width="5%">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM admin_table");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>

                        <tr>
                            <td><?= $k['ad_id']; ?></td>
                            <td><?= $k['ad_name']; ?></td>
                            <td><?= $k['ad_lastname']; ?></td>
                            <td><a href="ad_formEdit.php?id=<?= $k['ad_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['ad_id'] ?>')" class="btn btn-danger btn-circle btn-sm">ลบ</>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                <input id="latitudeInput" type="text" placeholder="Latitude" readonly />
                <input id="longitudeInput" type="text" placeholder="Longitude" readonly />
                <button onclick="getLocation()">Get Marker Position</button>
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
    </div>
</div>
<script>
    function confirmDeletion(id) {
        // Use SweetAlert2 to create a confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            // If the user clicks "Yes, delete it!"
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/ad/deleteProcess.php",
                    // Ensure proper validation on the server for ad_id
                    data: {
                        ad_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        // Display a success message to the user
                        Swal.fire('Deleted!', 'Your data has been deleted.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Display a user-friendly error message
                        Swal.fire('Error', 'An error occurred while deleting data.', 'error');
                        console.error("Ajax request failed:", status, error);
                        console.log(xhr.responseText); // Log the entire response for debugging
                    }
                });

            } else {
                // If the user clicks "Cancel" or closes the dialog
                Swal.fire('Cancelled', 'Your data is safe :)', 'info');
            }
        });
    }

    function submitForm() {
        var formData = new FormData($('#addUserForm')[0]);

        $.ajax({
            method: 'POST',
            url: "http://localhost/Project-main/black_end/ad/insertProcess.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.success === true) {
                    Swal.fire({
                        title: "Success",
                        text: "User added successfully",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    // $('#addUserModal').modal('hide');
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Error: " + result.message,
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Ajax request failed:", status, error);
                console.log(xhr.responseText); // บันทึกการตอบสนองทั้งหมด
            }
        });
    }
</script>
<!-- ... -->
<?php
$content = ob_get_clean();
include '../template/master.php';
?>