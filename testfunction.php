<?php
session_start();

// Check if the button has been clicked
if (isset($_POST['switchButton'])) {
    // Toggle the input field index stored in the session
    $_SESSION['inputIndex'] = isset($_SESSION['inputIndex']) ? $_SESSION['inputIndex'] + 1 : 1;
    if ($_SESSION['inputIndex'] > 4) {
        $_SESSION['inputIndex'] = 1;
        echo '<script>
            Swal.fire({
                icon: "warning",
                text: "Can only insert up to 4 files",
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>';
    }
}

// Get the current input field index from the session or set it to 1 by default
$inputIndex = isset($_SESSION['inputIndex']) ? $_SESSION['inputIndex'] : 1;

// Remove the following code block
if ($_SESSION['inputIndex'] > 4) {
    $_SESSION['inputIndex'] = 1;
    echo '<script>
        Swal.fire({
            icon: "warning",
            text: "Can only insert up to 4 files",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Toggle Input Field</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3"></script>
    <script>
        function switchInput() {
            var inputIndex = parseInt(document.getElementById('inputIndex').value);
            var nextIndex = inputIndex + 1;
            if (nextIndex > 4) {
                nextIndex = 4;
            }
            document.getElementById('inputIndex').value = nextIndex;

            // Hide all input fields
            var inputFields = document.getElementsByClassName('input-field');
            for (var i = 0; i < inputFields.length; i++) {
                inputFields[i].style.display = 'none';
            }

            // Show the input field corresponding to the current index
            var currentInputField = document.getElementById('input' + nextIndex);
            currentInputField.style.display = 'block';
            currentInputField.focus();

            // Trigger click event on the input field
            var clickEvent = new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true
            });
            currentInputField.dispatchEvent(clickEvent);

        }

        window.onload = function() {
            switchInput(); // Automatically trigger the switchInput() function on page load
        };
    </script>
    <style>
        .input-field {
            display: none;
        }
    </style>
</head>

<body>
    <form method="POST" action="">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <input type="file" name="input<?php echo $i; ?>" id="input<?php echo $i; ?>" class="input-field" placeholder="Input <?php echo $i; ?>" <?php if ($inputIndex == $i) echo 'style="display: block;"'; ?>>
        <?php endfor; ?>
        <input type="hidden" id="inputIndex" value="<?php echo $inputIndex; ?>">
        <br><br>
        <button type="button" onclick="switchInput()">Switch Input</button>
        <input type="submit" name="switchButton" style="display: none;">
    </form>
</body>

</html>