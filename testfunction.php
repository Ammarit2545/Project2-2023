<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script language="javascript">
    function fncAlert() {
        alert('Hello World');
    }
</script>

<body>
    <form action="" method="POST" name="form1">
        Name <input name="txtName" type="text" onblur="JavaScript:fncAlert();">
        <input type="submit" name="btnSubmit" value="Submit">
    </form>
</body>

</html>