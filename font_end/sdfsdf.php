<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDELcj3pYg5wJLF_spRgzdz8EAjY-v85QY&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

<script>
    let map;
    let marker;

    function confirmDeletion(id) {
        Swal.fire({
            title: 'ต้องการลบจริงมั้ย?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/hs/deleteProcess.php",
                    data: {
                        ba_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        Swal.fire('ลบข้อสำเร็จ!', 'ข้อมูลถูกลบแล้ว', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('ไม่สามารถลบได้', 'เกิดข้อผิดพลาดขณะลบข้อมูล.', 'error');
                        console.error("Ajax request failed:", status, error);
                        console.log(xhr.responseText);
                    }
                });
            } else {
                Swal.fire('ยกเลิก', 'ยกเลิกการลบแล้ว', 'info');
            }
        });
    }

    // Function to handle the form submission for adding a new ba
    function submitForm() {
        var formData = new FormData($('#resumeForm')[0]);

        // Validate form data
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var phonePattern = /^\d{10}$/;
        var idcardPattern = /^\d{13}$/;

        if (!$('#ba_name').val() || !$('#ba_lastname').val() || !$('#ba_idcard').val() || !$('#ba_email').val() || !$('#ba_password').val() || !$('#ba_phone').val()) {
            Swal.fire({
                title: "ข้อมูลไม่ครบถ้วน",
                text: "กรุณากรอกข้อมูลให้ครบทุกช่อง",
                icon: "error"
            });
            return;
        }

        if (!emailPattern.test($('#ba_email').val())) {
            Swal.fire({
                title: "อีเมลไม่ถูกต้อง",
                text: "กรุณากรอกอีเมลให้ถูกต้อง",
                icon: "error"
            });
            return;
        }

        if (!phonePattern.test($('#ba_phone').val())) {
            Swal.fire({
                title: "เบอร์โทรไม่ถูกต้อง",
                text: "กรุณากรอกเบอร์โทรให้ถูกต้อง",
                icon: "error"
            });
            return;
        }

        if (!idcardPattern.test($('#ba_idcard').val())) {
            Swal.fire({
                title: "หมายเลขบัตรประชาชนไม่ถูกต้อง",
                text: "กรุณากรอกหมายเลขบัตรประชาชนให้ถูกต้อง",
                icon: "error"
            });
            return;
        }

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
                        text: "เพิ่มผู้ใช้ไม่สำเร็จ: " + result.message,
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

                // Set the value of the input field with id "namelocation" to the name of the place
                $("#namelocation").val(place.name);

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