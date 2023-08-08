<?php
session_start();
include('database/condb.php');

if (!isset($_SESSION["id"])) {
    header('Location:home.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/all_page.css">
    <link rel="icon" type="image/x-icon" href="img brand/anelogo.jpg">
    <title>ANE - Edit User</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

</head>

<body>

    <!-- navbar-->
    <?php

    include('bar/topbar_invisible.php');

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM member WHERE m_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $jsonobj = $row['m_add'];

    if ($jsonobj) {
        $obj = json_decode($jsonobj);

        if ($obj !== null && property_exists($obj, 'province') && property_exists($obj, 'district') && property_exists($obj, 'sub_district')) {
            $sql_p = "SELECT provinces.name_en, amphures.name_en, districts.name_en
            FROM provinces
            LEFT JOIN amphures ON provinces.id = amphures.province_id
            LEFT JOIN districts ON amphures.id = districts.amphure_id
            WHERE provinces.id = '$obj->province' AND amphures.id = '$obj->district' AND districts.id = '$obj->sub_district';";
            $result_p = mysqli_query($conn, $sql_p);
            $row_p = mysqli_fetch_array($result_p);
        }
    }
    ?>
    <!-- end navbar-->

    <!-- <div class="background"></div> -->

    <div class="pt-5 edit">
        <h1 class="pt-5 text-center">แก้ไขข้อมูล</h1>
        <br>
        <form id="edit_user" action="action/edit_user.php" method="POST">
            <div class="container">
                <div class="row g-3">
                    <div class="col-md-6" id="bounce-item">
                        <label for="exampleFormControlInput1" class="form-label fw-bold">ชื่อ</label>
                        <input type="text" class="form-control " id="exampleFormControlInput1" name="fname" value="<?= $row['m_fname'] ?>">
                    </div>
                    <div class="col-md-6" id="bounce-item">
                        <label for="exampleFormControlInput1" class="form-label fw-bold">นามสกุล</label>
                        <input type="text" class="form-control " id="exampleFormControlInput1" name="lname" value="<?= $row['m_lname'] ?>">
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <div class="col-md-6" id="bounce-item">
                        <label for="exampleFormControlInput1" class="form-label fw-bold">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control " id="exampleFormControlInput1" name="tel" value="<?= $row['m_tel'] ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <!-- <label for="exampleFormControlTextarea1" class="form-label fw-bold">ที่อยู่</label>
          <textarea class="form-control address" id="exampleFormControlTextarea1" name="address"><?= $row['m_add'] ?></textarea> -->
                    <div class="mb-3" id="old_address">
                        <label for="exampleFormControlTextarea1" class="form-label fw-bold">รายละเอียดข้อมูลการติดต่อ</label>
                        <br>
                        <?php if ($row['m_add'] != NULL) {
                        ?>
                            <div class="row">
                                <div class="col-4" id="bounce-item">
                                    <label for="exampleFormControlTextarea1" class="col-form-label">จังหวัด :</label>
                                    <input type="text" class="form-control" value="<?= $row_p[0] ?>" placeholder="กรุณาเลือกจังหวัดที่ต้องการ" readonly>
                                </div>
                                <div class="col-4" id="bounce-item">
                                    <label for="exampleFormControlTextarea1" class="col-form-label">อำเภอ :</label>
                                    <input type="text" class="form-control" value="<?= $row_p[1] ?>" placeholder="กรุณาเลือกอำเภอที่ต้องการ" readonly>
                                </div>
                                <div class="col-4" id="bounce-item">
                                    <label for="exampleFormControlTextarea1" class="col-form-label">ตำบล :</label>
                                    <input type="text" class="form-control" value="<?= $row_p[2] ?>" placeholder="กรุณาเลือกตำบลที่ต้องการ" readonly>
                                </div>
                            </div>
                            <br>
                            <label for="exampleFormControlTextarea1" class="col-form-label" id="bounce-item">รายละเอียดเพิ่มเติม :</label>
                            <textarea class="form-control" id="bounce-item" rows="3" disabled="disabled" required>
                                <?php
                                if ($obj->description == NULL) {
                                    echo "ไม่มีข้อมูล";
                                } else {
                                    echo $obj->description;
                                }
                                ?>
                    </textarea>
                        <?php
                        } else {
                        ?>
                            <center>
                                <h5>ไม่มีข้อมูลที่อยู่</h5>
                            </center>
                        <?php
                        }
                        ?>
                    </div>

                    <?php
                    mysqli_query($conn, "SET NAMES 'utf8' ");
                    error_reporting(error_reporting() & ~E_NOTICE);
                    date_default_timezone_set('Asia/Bangkok');

                    $sql_provinces = "SELECT * FROM provinces";
                    $query = mysqli_query($conn, $sql_provinces);

                    ?>
                    <center>
                        <button class="btn btn-primary" onclick="New_address()" id="button_new_address" style="display: block;">ต้องการใช้ที่อยู่ใหม่</button>
                    </center>
                    <div id="address" style="display:none">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

                        <label for="exampleFormControlTextarea1" class="form-label fw-bold">รายละเอียดข้อมูลการติดต่อ</label>
                        <br>
                        <label for="sel1">จังหวัด:</label>
                        <select class="form-control" name="Ref_prov_id" id="provinces" required>
                            <option value="" selected disabled>กรุณาเลือกจังหวัด</option>
                            <?php foreach ($query as $value) { ?>
                                <option value="<?= $value['id'] ?>"><?= $value['name_th'] ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="sel1">อำเภอ:</label>
                        <select class="form-control" name="Ref_dist_id" id="amphures" required>
                            <option value="" selected disabled>กรุณาเลือกอำเภอ</option>
                        </select>
                        <br>

                        <label for="sel1">ตำบล:</label>
                        <select class="form-control" name="Ref_subdist_id" id="districts" required>
                            <option value="" selected disabled>กรุณาเลือกตำบล</option>
                        </select>
                        <br>

                        <label for="sel1">รหัสไปรษณีย์:</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control" required>
                        <br>

                        <label for="exampleFormControlTextarea1" class="form-label">กรุณากรอกที่อยู่ที่ต้องการจัดส่ง</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required></textarea>

                        <div class="text-center py-4">
                            <a class="btn btn_custom" name="submit" onclick="validateForm()">ยืนยัน</a>
                        </div>
                    </div>

                    <script>
                        let provinceSelect = document.getElementById("provinces");
                        let amphurSelect = document.getElementById("amphures");
                        let districtSelect = document.getElementById("districts");

                        // Event listener for province select change
                        provinceSelect.addEventListener("change", function() {
                            let provinceId = this.value;
                            resetSelectOptions(amphurSelect);
                            resetSelectOptions(districtSelect);
                            if (provinceId) {
                                loadAmphurData(provinceId);
                            }
                        });

                        // Event listener for amphur select change
                        amphurSelect.addEventListener("change", function() {
                            let amphurId = this.value;
                            resetSelectOptions(districtSelect);
                            if (amphurId) {
                                loadDistrictData(amphurId);
                            }
                        });

                        // Event listener for district select change
                        districtSelect.addEventListener("change", function() {
                            let districtId = this.value;
                            let selectedDistrict = response.find(district => district.id === districtId);
                            if (selectedDistrict) {
                                document.getElementById("zip_code").value = selectedDistrict.zip_code;
                            }
                        });

                        // Function to reset select options
                        function resetSelectOptions(selectElement) {
                            selectElement.innerHTML = '<option value="" selected disabled>-กรุณาเลือก-</option>';
                        }

                        // Function to load amphur data
                        function loadAmphurData(provinceId) {
                            // Perform an AJAX request to fetch the amphur data
                            $.ajax({
                                url: "get_amphures.php",
                                method: "POST",
                                data: {
                                    province_id: provinceId
                                }, // เพิ่มการส่งค่า province_id
                                dataType: "json",
                                success: function(response) {
                                    // Populate the amphur select options
                                    response.forEach(function(amphur) {
                                        let option = document.createElement("option");
                                        option.value = amphur.id;
                                        option.textContent = amphur.name_th;
                                        amphurSelect.appendChild(option);
                                    });
                                }
                            });
                        }

                        // Function to load district data
                        function loadDistrictData(amphurId) {
                            // Perform an AJAX request to fetch the district data
                            $.ajax({
                                url: "get_districts.php",
                                method: "POST",
                                data: {
                                    amphur_id: amphurId
                                }, // เพิ่มการส่งค่า amphur_id
                                dataType: "json",
                                success: function(response) {
                                    // Reset district select options
                                    resetSelectOptions(districtSelect);

                                    // Populate the district select options
                                    response.forEach(function(district) {
                                        let option = document.createElement("option");
                                        option.value = district.id;
                                        option.textContent = district.name_th;
                                        districtSelect.appendChild(option);
                                    });

                                    // Set the zip code based on the first district
                                    if (response.length > 0) {
                                        document.getElementById("zip_code").value = response[0].zip_code;
                                    }
                                }
                            });
                        }

                        // Function to validate the form before submission
                        function validateForm() {
                            // Check if all required fields have values
                            let provinceValue = provinceSelect.value;
                            let amphurValue = amphurSelect.value;
                            let districtValue = districtSelect.value;
                            let zipCodeValue = document.getElementById("zip_code").value;
                            let descriptionValue = document.getElementById("exampleFormControlTextarea1").value;

                            if (provinceValue && amphurValue && districtValue && zipCodeValue && descriptionValue) {
                                // All required fields have values, proceed with submission
                                showConfirmation();
                            } else {
                                // Missing required fields, display an error message or take appropriate action
                                incompleteInformation();
                            }
                        }
                    </script>
                    <!-- <center>
                    <br>
                    <a class="btn btn-warning" onclick="New_address()" href="">ต้องการใช้ที่อยู่เดิม</a>
                </center> -->
                    <br>
                </div>
            </div>

            <?php include('script.php'); ?>

            <script>
                function showConfirmation() {
                    Swal.fire({
                        title: "ยืนยันการแก้ไขข้อมูล",
                        text: "คุณต้องการที่จะยืนยันการแก้ไขข้อมูลหรือไม่?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ใช่, ยืนยัน!",
                        cancelButtonText: "ยกเลิก"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, proceed with form submission
                            document.getElementById("edit_user").submit();
                        }
                    });
                }

                function incompleteInformation() {
                    Swal.fire({
                        title: "ข้อมูลของคุณยังไม่ครบ",
                        text: "กรุณากรอกข้อมูลให้ครบถ้วน",
                        icon: "warning",
                        confirmButtonText: "ตกลง!",
                    })
                }
            </script>
    </div>
    </form>
    </div>

    <!-- footer-->
    <?php
    // include('footer/footer.php') 
    ?>
    <!-- end footer-->

    <script>
        // Show full page LoadingOverlay
        $.LoadingOverlay("show");

        // Hide it after 3 seconds
        setTimeout(function() {
            $.LoadingOverlay("hide");
        }, 10);

        function New_address() {
            document.getElementById('address').style.display = 'block';
            document.getElementById('old_address').style.display = 'none';
            document.getElementById('button_new_address').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>