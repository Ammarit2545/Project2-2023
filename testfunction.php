<?php
if (!isset($_SESSION['profile'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION['profile'])) {
        $profile = $_SESSION['profile'];
    }
    ?>
    <h1>Welcome , <?= $profile->name; ?></h1>
    <p class="lead">Your Email : <?= $profile->email; ?></p>
    <img src="<?php echo $profile->picture  ?>" class="rounded" alt="Profile Picture">
</body>

</html>