<?php ob_start(); ?>
<style>
    /* Your existing CSS */
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

    .pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
        z-index: 10000;
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
        z-index: 10000;
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

    #map {
        z-index: 9999;
    }
</style>

<br>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fe9f6005">
    <h2> รายชื่อช่างตัดผม</h2>
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
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
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM user_table");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['user_id']; ?></td>
                            <td><?= $k['user_name']; ?></td>
                            <td><?= $k['user_lastname']; ?></td>
                            <td><a href="hs_formEdit.php?id=<?= $k['user_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['user_id'] ?>')" class="btn btn-danger btn-sm">ลบ</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">เพิ่มข้อมูลช่างตัดผม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="max-height: 5000px; overflow-y: auto;">
                <form id="resumeForm" action="/black_end/hs/insertProcess.php" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_name">ชื่อ:</label>
                                <input type="text" class="form-control " id="user_name" name="user_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_lastname">นามสกุล:</label>
                                <input type="text" class="form-control " id="user_lastname" name="user_lastname" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_idcard">หมายเลขบัตรประชาชน:</label>
                                <input type="text" class="form-control" id="user_idcard" name="user_idcard" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_email">Email:</label>
                                <input type="email" class="form-control " id="user_email" name="user_email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_password">password:</label>
                                <input type="password" class="form-control " id="user_password" name="user_password" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_phone">เบอร์ติดต่อ:</label>
                                <input type="text" class="form-control" id="user_phone" name="user_phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_Certificate">ส่งใบเซอร์:</label>
                                <input type="file" class="form-control" id="user_Certificate" name="user_Certificate" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
                            <div id="map"></div>
                        </div>
                        <div class="col-md-3">
                        <label for="user_latitude">ละติจูด :</label>
                        <input type="text" id="latitudeInput" name="user_latitude">
                        </div>
                        <div class="col-md-3">
                        <label for="user_longitude">ลองจิจูด:</label>
                        <input type="text" id="longitudeInput" name="user_longitude">
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="getLocation()"> ยืนยันตำแหน่ง</button>
                        </div>

                </form>
            </div>


        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-success" onclick="submitForm()">ส่งใบสมัคร</button>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDELcj3pYg5wJLF_spRgzdz8EAjY-v85QY&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

<script>
    let map;
    let marker;

    function confirmDeletion(id) {
        Swal.fire({
            title: 'ต้องการลบหรือไม่!',
            text: 'คุณต้องการที่จะลบหรือไปไม่!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่ ต้องการลบ',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/hs/deleteProcess.php",
                    data: {
                        user_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        Swal.fire('Deleted!', 'Your data has been deleted.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'An error occurred while deleting data.', 'error');
                        console.error("Ajax request failed:", status, error);
                        console.log(xhr.responseText);
                    }
                });
            } else {
                Swal.fire('ยกเลิกสำเร็จ');
            }
        });
    }

    // Function to handle the form submission for adding a new user
    function submitForm() {
        var formData = new FormData($('#resumeForm')[0]);

        $.ajax({
            method: 'POST',
            url: "http://localhost/Project-main/black_end/hs/insertProcess.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result); // 
                if (result.success === true) {
                    Swal.fire({
                        title: "เพิ่มสำเร็จ",
                        text: "เพิ่มผู้ใช้เรียบร้อยแล้ว",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "เพิ่มไม่สำเร็จ",
                        text: "เพิ่มผู้ใช้ไม่เรียบร้อยแล้ว: " + result.message,
                        icon: "error"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        };
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Ajax request failed:", status, error);
                console.log(xhr.responseText);
            }
        });
    }


    function initAutocomplete() {
        map = new google.maps.Map($("#map").get(0), {
            center: {
                lat: 13.7563, // Latitude of Thailand
                lng: 100.5018 // Longitude of Thailand
            },
            zoom: 13,
            mapTypeId: "roadmap",
        });

        const input = $("#pac-input").get(0);
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

            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                marker = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    position: place.geometry.location,
                    draggable: true, // Make the marker draggable
                });

                google.maps.event.addListener(marker, "dragend", function() {
                    $("#latitudeInput").val(marker.getPosition().lat());
                    $("#longitudeInput").val(marker.getPosition().lng());
                });

                google.maps.event.addListener(marker, "click", function() {
                    $("#latitudeInput").val(marker.getPosition().lat());
                    $("#longitudeInput").val(marker.getPosition().lng());
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

    function getLocation() {
        if (marker) {
            $("#latitudeInput").val(marker.getPosition().lat());
            $("#longitudeInput").val(marker.getPosition().lng());
        } else {
            alert("กรุณาเลือกตำแหน่ง");
        }
    }
</script>
<!-- ... -->
<?php
$content = ob_get_clean();
include '../template/master.php';
?>