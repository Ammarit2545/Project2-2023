<?php
session_start();
include('database/condb.php');

if (isset($_GET['get_r_id'])) {
    $get_r_id_session = $_GET['get_r_id'];
}

if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
}

if (isset($_GET['p_id']) && isset($_GET['get_r_id'])) {

    $count_session = 1;
    while (isset($_SESSION[$get_r_id_session . '_' . $count_session])) {
        if ($_SESSION[$get_r_id_session . '_' . $count_session] ==  $p_id) {
            $_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session] += 1;
            break;
        }
        $count_session++;
    }

    if (!isset($_SESSION[$get_r_id_session . '_' . $count_session]) || $_SESSION[$get_r_id_session . '_' . $count_session] !=  $p_id) {
        $_SESSION[$get_r_id_session . '_' . $count_session] = $p_id;
        $_SESSION[$get_r_id_session . '_' . 'get' . '_' .  $count_session] = $get_r_id_session;
        $_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session] = 1;
?>
        <script>
            let timerInterval
            Swal.fire({
                title: 'Auto close alert!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        </script>
<?php
    }
}

// You can add additional code here if needed.
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* Custom CSS for styling */
        .search-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
            margin-bottom: 20px;
        }

        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            width: 18rem;
        }

        /* Fix the navigation bar to the top */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
    </style>
</head>
<script>
    const products = [
        <?php
        $sql_get_co = "SELECT parts.p_id,parts.p_pic, parts.p_brand, parts.p_model, parts_type.p_type_name 
                                            FROM parts 
                                            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
                                            WHERE parts.del_flg = 0";

        $result_get_co = mysqli_query($conn, $sql_get_co);

        while ($row_get_co = mysqli_fetch_array($result_get_co)) { ?> {
                p_id: <?= json_encode($row_get_co['p_id']) ?>,
                p_pic: <?= json_encode($row_get_co['p_pic']) ?>,
                p_brand: <?= json_encode($row_get_co['p_brand']) ?>,
                p_model: <?= json_encode($row_get_co['p_model']) ?>,
                p_type_name: <?= json_encode($row_get_co['p_type_name']) ?>
            },
        <?php } ?>
    ];
</script>
<?php
$get_r_id = 213;
$count = 1;
?>

<body>
    <div class="search-container">
        <div>
            <center>
                <h1 class="mb-4">ค้นหาอะไหล่</h1>
            </center>
            <div class="container">

                <div class="row">
                    <div class="col-md-9">
                        <input type="text" id="searchInput<?= $get_r_id ?>" class="search-bar mb-4" placeholder="ค้นหา ยี่ห้อ ,โมเดล" onkeyup="searchProducts<?= $get_r_id ?>()">
                    </div>
                    <div class="col-md-3  d-flex flex-column align-items-end">
                        <?php
                        $count_session = 1;
                        while (isset($_SESSION[$get_r_id_session . '_' . $count_session])) {
                            $count_session++;
                        }
                        $count_session -= 1;
                        ?>
                        <button type="button" class="btn btn-primary search-bar mb-4" data-bs-toggle="modal" data-bs-target="#cart<?= $get_r_id ?>">
                            <i class="fa fa-shopping-cart" style="display: inline;"></i><?php if ($count_session > 0) {
                                                                                        ?><p style="display: inline; " class="badge bg-danger"><?= $count_session ?></p><?php
                                                                                                                                                                    } ?>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="cart<?= $get_r_id ?>" tabindex="-1" aria-labelledby="cartLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cartLabel">Shopping Cart</h5>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">รหัส</th> -->
                                                    <th scope="col">รูปภาพ</th>
                                                    <th scope="col">ชื่อ</th>
                                                    <th scope="col">จำนวน</th>
                                                    <th scope="col">
                                                        <center>
                                                            ลบ
                                                        </center>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $p_price = 0;
                                                $count_session = 1;
                                                while (isset($_SESSION[$get_r_id_session . '_' . $count_session])) {
                                                    $parts_id = $_SESSION[$get_r_id_session . '_' . $count_session];
                                                    $sql_r = "SELECT p_name,p_pic ,p_price FROM parts WHERE del_flg = 0 AND p_id = '$parts_id'";
                                                    $result_r = mysqli_query($conn, $sql_r);
                                                    $row_r = mysqli_fetch_array($result_r);
                                                    $p_price += $row_r['p_price'];

                                                ?>
                                                    <tr>
                                                        <th scope="row"><?= $count_session ?></th>

                                                        <!-- <td><?= $_SESSION[$get_r_id_session . '_' . $count_session] ?></td> -->
                                                        <td><img src="<?= $row_r['p_pic'] ?>" alt="" width="40px"></td>
                                                        <td><?= '(' . $_SESSION[$get_r_id_session . '_' . $count_session] . ')  ' . $row_r['p_name'] ?></td>
                                                        <td>
                                                            <!-- <span id="sessionValue<?= $count_session ?>">
                                                                <?= $_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session] ?>
                                                            </span> -->
                                                            <!-- <input id="editSessionValue<?= $count_session ?>" type="text" value="<?= $_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session] ?>" style="display: none;" onblur="updateSessionValue(<?= $get_r_id_session ?>, <?= $count_session ?>)">
                                                            <button id="editButton<?= $count_session ?>" class="btn btn-sm btn-outline-primary" onclick="enableSessionValueEdit(<?= $count_session ?>)">
                                                                Edit
                                                            </button> -->
                                                            <input type="text" name="<?= $get_r_id_session . '_' . 'value' . '_' . $count_session ?>" id="titleInput" class="invisible-input form-control mb-0 mr-1 text-center" placeholder="* กรุณาใส่จำนวนที่ต้องการ" value="<?php if (isset($_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session])) {
                                                                                                                                                                                                                                                                                    echo $_SESSION[$get_r_id_session . '_' . 'value' . '_' . $count_session];
                                                                                                                                                                                                                                                                                } ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="หัวข้อหลัก" required>
                                                        </td>
                                                        <td>

                                                            <!-- Your HTML link -->
                                                            <center>
                                                                <a href="admin/action/delete_parts_session.php?get_r_id=<?= $get_r_id_session ?>&count=<?= $count_session ?>" class="btn btn-danger" id="deleteLink<?= $count_session ?>">ลบ</a>
                                                            </center>

                                                            <script>
                                                                // Add a click event listener to the link
                                                                document.getElementById('deleteLink<?= $count_session ?>').addEventListener('click', function(event) {
                                                                    event.preventDefault(); // Prevent the link from navigating

                                                                    Swal.fire({
                                                                        title: 'คุณแน่ใจหรือไม่?',
                                                                        text: 'คุณต้องการลบรายการนี้หรือไม่?',
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#3085d6',
                                                                        cancelButtonColor: '#d33',
                                                                        confirmButtonText: 'ใช่, ลบ!',
                                                                        cancelButtonText: 'ยกเลิก'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            // If the user confirms, navigate to the link
                                                                            window.location.href = event.target.href;
                                                                        }
                                                                    });
                                                                });
                                                            </script>

                                                        </td>
                                                        <script>
                                                            const inputs = document.querySelectorAll('.invisible-input, .invisible-textarea');

                                                            inputs.forEach(input => {
                                                                input.addEventListener('input', function() {
                                                                    if (this.value.trim() !== '') {
                                                                        this.classList.add('has-content');
                                                                        updateSession(this);
                                                                    } else {
                                                                        this.classList.remove('has-content');
                                                                    }
                                                                });
                                                            });

                                                            function updateSession(input) {
                                                                const name = input.getAttribute('name');
                                                                const value = input.value;

                                                                // Create an AJAX request to update the session based on input name
                                                                const xhr = new XMLHttpRequest();
                                                                xhr.open('POST', 'update_session_value.php'); // Use the same PHP script for all inputs
                                                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                                                // Send the data as a single string in the request body
                                                                const data = `name=${encodeURIComponent(name)}&value=${encodeURIComponent(value)}`;
                                                                xhr.send(data);

                                                                // Handle the response if needed
                                                                xhr.onload = function() {
                                                                    if (xhr.status === 200) {
                                                                        const response = JSON.parse(xhr.responseText);
                                                                        console.log(response.message); // You can handle the response here
                                                                    } else {
                                                                        console.error('Error:', xhr.statusText);
                                                                    }
                                                                };
                                                            }
                                                        </script>
                                                        <script>
                                                            function enableSessionValueEdit(countSession) {
                                                                // Hide the <span> and show the <input> for editing
                                                                const span = document.getElementById(`sessionValue${countSession}`);
                                                                const input = document.getElementById(`editSessionValue${countSession}`);
                                                                const editButton = document.getElementById(`editButton${countSession}`);

                                                                span.style.display = 'none';
                                                                input.style.display = 'inline';
                                                                input.focus();

                                                                // Hide the Edit button
                                                                editButton.style.display = 'none';
                                                            }

                                                            function updateSessionValue(getRIdSession, countSession) {
                                                                const input = document.getElementById(`editSessionValue${countSession}`);
                                                                const span = document.getElementById(`sessionValue${countSession}`);

                                                                // Update the session value
                                                                const newValue = input.value;
                                                                span.textContent = newValue;

                                                                // Update the session value in the session variable
                                                                // Send an AJAX request to update the session value on the server-side
                                                                updateSessionValueOnServer(getRIdSession, countSession, newValue);

                                                                // Hide the <input> and show the <span> again
                                                                input.style.display = 'none';
                                                                span.style.display = 'inline';

                                                                // Show the Edit button again
                                                                const editButton = document.getElementById(`editButton${countSession}`);
                                                                editButton.style.display = 'inline';
                                                            }

                                                            function updateSessionValueOnServer(getRIdSession, countSession, newValue) {
                                                                const url = 'update_session_value.php'; // Replace with your server endpoint
                                                                const data = {
                                                                    getRIdSession: getRIdSession,
                                                                    countSession: countSession,
                                                                    newValue: newValue
                                                                };
                                                                fetch(url, {
                                                                        method: 'POST',
                                                                        body: JSON.stringify(data),
                                                                        headers: {
                                                                            'Content-Type': 'application/json'
                                                                        }
                                                                    })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        // Handle the response if needed
                                                                        console.log(data);
                                                                    })
                                                                    .catch(error => {
                                                                        console.error('Error:', error);
                                                                    });
                                                            }
                                                        </script>
                                                    </tr>
                                                <?php
                                                    $count_session++;
                                                } ?>
                                                <tr>
                                                    <td colspan="3">

                                                    </td>
                                                    <td>
                                                        <center>
                                                            <b>ราคารวม</b>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <b> <?= number_format($p_price) . ' ' ?></b>บาท
                                                        </center>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="searchResults<?= $get_r_id ?>" class="search-results">
                        <?php
                        $sql_get_co = "SELECT parts.p_id,parts.p_pic, parts.p_brand, parts.p_model, parts_type.p_type_name 
                                            FROM parts 
                                            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
                                            WHERE parts.del_flg = 0";

                        $result_get_co = mysqli_query($conn, $sql_get_co);

                        while ($row_get_co = mysqli_fetch_array($result_get_co)) { ?>
                            <!-- Search results will be displayed here -->
                            <div class="col-md-4">
                                <div class="card ">
                                    <img src="<?= $row_get_co['p_pic'] ?>" class="card-img-top" alt="Part Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $row_get_co['p_brand'].' '.$row_get_co['p_model'] ?></h5>
                                        <p class="card-text">Type: <?= $row_get_co['p_type_name'] ?></p>
                                        <a href="add_new_parts.php?get_r_id=<?= $get_r_id ?>&p_id=<?= $row_get_co['p_id'] ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchProducts<?= $get_r_id ?>() {
            const searchInput = document.getElementById("searchInput<?= $get_r_id ?>").value.toLowerCase();
            const searchResults = document.getElementById("searchResults<?= $get_r_id ?>");
            searchResults.innerHTML = '';

            products.forEach(product => {
                const {
                    p_id,
                    p_brand,
                    p_pic,
                    p_model,
                    p_type_name
                } = product;
                const searchTerm = p_brand.toLowerCase() + ' ' + p_model.toLowerCase() + ' ' + p_type_name.toLowerCase() + ' ' + p_pic.toLowerCase() + ' ' + p_id.toLowerCase();

                if (searchTerm.includes(searchInput)) {
                    const card = document.createElement("div");
                    card.classList.add("card", "mb-3");

                    card.innerHTML = `
                            <div class="col-md-4">
                                <div class="card ">
                                    <img src="${p_pic}" class="card-img-top" alt="Part Image">
                                    <div class="card-body">
                                        <h5 class="card-title">${p_brand} ${p_model}</h5>
                                        <p class="card-text">Type: ${p_type_name}</p>
                                        <a href="add_new_parts.php?get_r_id=<?= $get_r_id ?>&p_id=${p_id}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                    `;

                    searchResults.appendChild(card);
                }
            });
        }
    </script>
    <!-- Add this script to your HTML file, after including the SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>

</html>