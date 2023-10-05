<?php
session_start();
include('database/condb.php');
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
<?php $count = 1; ?>

<body>
    <br>
    <br>
    <center>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Parts<?= $count ?>">
            จัดการอะไหล่
        </button>
    </center>

    <!-- Modal -->
    <div class="modal fade" id="Parts<?= $count ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เลือกอะไหล่ที่คุณต้องการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 90vh;">
                    <iframe src="add_new_parts.php" width="100%" height="100%"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Product Search</a>
        </div>
    </nav> -->



    <!-- Scrollable modal -->
    <!-- <div class="modal-dialog modal-dialog-scrollable">
  ...
</div> -->


</body>

</html>