<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-time Session Display</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Session Data:</h1>
    <div id="session-data">
        <!-- Session data will be displayed here -->
    </div>

    <form id="update-form">
        <label for="delivery-id">Get ID:</label>
        <input type="text" id="delivery-id" name="get_d_id">
        <label for="product-id">Product ID:</label>
        <input type="text" id="product-id" name="p_id">
        <label for="product-value">Product Value:</label>
        <input type="text" id="product-value" name="value_p">

        <button type="submit">Update Session</button>
    </form>


    <script>
        // Function to update the session data on the page
        function updateSessionData() {
            $.ajax({
                url: 'action/session_update.php',
                dataType: 'json',
                data: $('#update-form').serialize(),
                success: function(data) {
                    // Clear form fields
                    $('#update-form')[0].reset();

                    // Display the updated session data
                    var html = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                    $('#session-data').html(html);
                }
            });
        }

        // Update session data initially
        updateSessionData();

        // Submit form to update session data
        $('#update-form').on('submit', function(e) {
            e.preventDefault();
            updateSessionData();
        });
    </script>
</body>

</html>