<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Calculate</title>
</head>
<script language="javascript">
    function fncAlert(grand, position) {
        var grand_name;
        var i;
        var grand_A = 0,
            grand_B = 0,
            grand_C = 0,
            grand_D = 0,
            grand_F = 0;
        var count_a = 0,
            count_b = 0,
            count_c = 0,
            count_d = 0,
            count_f = 0;

        if (grand >= 80 && grand <= 100) {
            grand_name = 'A';
        } else if (grand >= 70 && grand <= 79) {
            grand_name = 'B';
        } else if (grand >= 60 && grand <= 69) {
            grand_name = 'C';
        } else if (grand >= 50 && grand <= 59) {
            grand_name = 'D';
        } else {
            grand_name = 'F';
        }

        document.getElementById("show_value_" + position).innerText = grand_name;

        if (grand >= 80 && grand <= 100) {
            var x = parseInt(document.getElementById("show_grand_A").value);
            var grand_A = x + 1;
            document.getElementById("show_grand_A").value = grand_A;

        } else if (grand >= 70 && grand <= 79) {
            var x = parseInt(document.getElementById("show_grand_B").value);
            grand_B = x + 1;
            document.getElementById("show_grand_B").value = grand_B;

        } else if (grand >= 60 && grand <= 69) {
            var x = parseInt(document.getElementById("show_grand_C").value);
            document.getElementById("show_grand_C").value = grand_C;

            grand_C = x + 1;
        } else if (grand >= 50 && grand <= 59) {
            var x = parseInt(document.getElementById("show_grand_D").value);
            grand_D = x + 1;
            document.getElementById("show_grand_D").value = grand_D;

        } else {
            var x = parseInt(document.getElementById("show_grand_F").value);
            grand_F = x + 1;
            document.getElementById("show_grand_F").value = grand_F;

        }
        for (i = 1; i <= 10; i++) {
            var value = parseInt(document.getElementById("grand_" + i).value);
            if (!isNaN(value)) {
                if (value >= 80 && value <= 100) {
                    count_a += 1;
                    console.log('A');
                } else if (value >= 70 && value <= 79) {
                    count_b += 1;
                    document.getElementById("show_grand_B").value += 1;
                    console.log('B');
                } else if (value >= 60 && value <= 69) {
                    count_c += 1;
                    document.getElementById("show_grand_C").value += 1;
                    console.log('C');
                } else if (value >= 50 && value <= 59) {
                    count_d += 1;
                    document.getElementById("show_grand_D").value += 1;
                    console.log('D');
                } else {
                    count_f += 1;
                    document.getElementById("show_grand_F").value += 1;
                    console.log('F');
                }
            }
        }
        document.getElementById("show_grand_A").value = count_a;
        document.getElementById("show_grand_B").value = count_b;
        document.getElementById("show_grand_C").value = count_c;
        document.getElementById("show_grand_D").value = count_d;
        document.getElementById("show_grand_F").value = count_f;
    }
</script>
<style>
    .color-text {
        background-color: gray;
        color: white;
        width: 200px;
    }

    .color-text-to {
        padding: 35px 20px 20px 20px;
        background-color: red;
        color: white;
        width: 200px;
        border-radius: 0% 100% 100% 0%;
        height: 50px;
    }
</style>

<body>
    <br> <br>
    <center>
        <!-- <marquee direction="left"> -->
        <h1>โปรแกรมคำนวนเกรด</h1>
        <!-- </marquee> -->
    </center>
    <br>
    <hr> <br> <br>
    <center>
        <table>
            <th>
                <center>
                    <h2 class="color-text">กรุณาใส่เกรด</h2>
                </center>
                <?php for ($i = 1; $i <= 10; $i++) {  ?>
                    <p> User_<?= $i ?> <input name="grand_<?= $i ?>" id="grand_<?= $i ?>" type="int" onchange="fncAlert(this.value, <?= $i ?>);"><span> - Grade : <span id="show_value_<?= $i ?>"></span></span></p>
                <?php } ?>
            </th>
            <th width="500px">
                <center>
                    <!-- <marquee direction="right"> -->
                    <h2 class="color-text-to">ผลรวมของเกรด</h2>
                    <!-- </marquee> -->
                </center>
            </th>
            <th>
                <div>
                    <h2 class="color-text">Total Grand</h2>
                    <p>A : <input id="show_grand_A" value="0" type="number" name="show_grand_A"></p>
                    <p>B : <input id="show_grand_B" value="0" type="number" name="show_grand_B"></p>
                    <p>C : <input id="show_grand_C" value="0" type="number" name="show_grand_C"></p>
                    <p>D : <input id="show_grand_D" value="0" type="number" name="show_grand_D"></p>
                    <p>F : <input id="show_grand_F" value="0" type="number" name="show_grand_F"></p>
                </div>
            </th>
        </table>
        <br> <br>
        <hr>
    </center>
</body>

</html>