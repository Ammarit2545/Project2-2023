<?php
session_start();

// Check if the button has been clicked
if(isset($_POST['switchButton'])){
    // Toggle the input field index stored in the session
    $_SESSION['inputIndex'] = isset($_SESSION['inputIndex']) ? ($_SESSION['inputIndex'] + 1) % 5 : 0;
}

// Get the current input field index from the session or set it to 0 by default
$inputIndex = isset($_SESSION['inputIndex']) ? $_SESSION['inputIndex'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Toggle Input Field</title>
    <script>
        function switchInput() {
            var inputIndex = parseInt(document.getElementById('inputIndex').value);
            var nextIndex = (inputIndex + 1) % 5;
            document.getElementById('inputIndex').value = nextIndex;

            // Hide all input fields
            var inputFields = document.getElementsByClassName('input-field');
            for (var i = 0; i < inputFields.length; i++) {
                inputFields[i].style.display = 'none';
            }

            // Show the input field corresponding to the current index
            document.getElementById('input' + nextIndex).style.display = 'block';
        }
    </script>
    <style>
        .input-field {
            display: none;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <?php for($i = 0; $i <= 4; $i++): ?>
            <input type="file" name="input<?php echo $i; ?>" id="input<?php echo $i; ?>" class="input-field" placeholder="Input <?php echo $i; ?>" <?php if($inputIndex == $i) echo 'style="display: block;"'; ?>>
        <?php endfor; ?>
        <input type="hidden" id="inputIndex" value="<?php echo $inputIndex; ?>">
        <br><br>
        <button type="button" onclick="switchInput()">Switch Input</button>
    </form>
</body>
</html>
