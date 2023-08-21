<!DOCTYPE html>
<html>
<head>
    <title>Record Checker</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function checkRecords() {
            $.ajax({
                url: 'check_records.php',
                dataType: 'json',
                success: function (data) {
                    if (data.length > 0) {
                        // Handle the response, e.g., display a notification or update the UI
                        // For demonstration purposes, we'll just log the data to the console
                        console.log(data);

                        // Call the function again after a delay (e.g., 5 seconds)
                        setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
                    } else {
                        // No records found, call the function again after a delay
                        setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
                    }
                },
                error: function () {
                    // Handle errors, and call the function again after a delay
                    setTimeout(checkRecords, 5000); // 5 seconds (5000 milliseconds)
                }
            });
        }

        // Start checking records when the page loads
        $(document).ready(function () {
            checkRecords();
        });
    </script>
</head>
<body>
    <!-- Your HTML content here -->
</body>
</html>