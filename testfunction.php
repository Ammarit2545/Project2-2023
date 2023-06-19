<?php
session_start();
include('database/condb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['part_id']) && isset($_POST['quantity'])) {
        $partId = $_POST['part_id'];
        $quantity = $_POST['quantity'];

        // Insert the part and quantity into the database
        $query = "INSERT INTO stock_parts (part_id, quantity) VALUES ('$partId', '$quantity')";
        mysqli_query($con, $query);
        // You can add error handling and validation as per your requirements

        // Close the modal after adding the part
        echo '<script>document.getElementById("myModal").style.display = "none";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Modal styles */

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Button to open the modal -->
    <button id="openModalBtn">Add Stock Part</button>

    <!-- The modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Stock Part</h2>
            <input type="text" id="searchInput" placeholder="Search by name or type">
            <ul id="searchResults"></ul>
            <div id="partDetails" style="display: none;">
                <h3>Part Details</h3>
                <p id="partName"></p>
                <p id="partType"></p>
                <input type="number" id="partQuantity" placeholder="Quantity">
                <button id="addButton">Add Part</button>
            </div>
        </div>
    </div>

    <script>
        // Get the modal element
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openModalBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function () {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Search functionality
        var searchInput = document.getElementById("searchInput");
        var searchResults = document.getElementById("searchResults");
        var partDetails = document.getElementById("partDetails");
        var partName = document.getElementById("partName");
        var partType = document.getElementById("partType");
        var partQuantity = document.getElementById("partQuantity");
        var addButton = document.getElementById("addButton");

        // Sample data for demonstration
        var parts = [{
                p_id: 1,
                p_name: "Part 1",
                p_type: "Type A",
                p_stock: 10
            },
            {
                p_id: 2,
                p_name: "Part 2",
                p_type: "Type B",
                p_stock: 5
            },
            {
                p_id: 3,
                p_name: "Part 3",
                p_type: "Type A",
                p_stock: 8
            }
        ];

        searchInput.addEventListener("input", function (event) {
            var query = event.target.value.toLowerCase();
            var filteredParts = parts.filter(function (part) {
                return (
                    part.p_name.toLowerCase().includes(query) ||
                    part.p_type.toLowerCase().includes(query)
                );
            });

            renderSearchResults(filteredParts);
        });

        function renderSearchResults(results) {
            searchResults.innerHTML = "";
            results.forEach(function (result) {
                var li = document.createElement("li");
                li.textContent = result.p_name + " (" + result.p_type + ")";
                li.addEventListener("click", function () {
                    showPartDetails(result);
                });
                searchResults.appendChild(li);
            });
        }

        function showPartDetails(part) {
            partName.textContent = "Name: " + part.p_name;
            partType.textContent = "Type: " + part.p_type;
            partDetails.style.display = "block";
            addButton.onclick = function () {
                var quantity = parseInt(partQuantity.value, 10);
                if (!isNaN(quantity) && quantity > 0) {
                    // Add part to the database
                    var form = document.createElement("form");
                    form.setAttribute("method", "POST");
                    form.setAttribute("action", "");

                    var partIdInput = document.createElement("input");
                    partIdInput.setAttribute("type", "hidden");
                    partIdInput.setAttribute("name", "part_id");
                    partIdInput.setAttribute("value", part.p_id);
                    form.appendChild(partIdInput);

                    var quantityInput = document.createElement("input");
                    quantityInput.setAttribute("type", "hidden");
                    quantityInput.setAttribute("name", "quantity");
                    quantityInput.setAttribute("value", quantity);
                    form.appendChild(quantityInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            };
        }
    </script>
</body>

</html>
