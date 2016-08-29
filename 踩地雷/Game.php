<?php
require_once 'GameResult.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="/jquery-1.10.2.min.js"></script>
    </head>
    <body oncontextmenu="return false">
        <?php
        $g = new GameResult();
        $result = $g->create();
        echo ' <table width="300" border="1"> ';
        for ($j = 0 ; $j < 10; $j++) {
            echo "<tr>";
            for ($i = 0 ; $i < 10; $i++) {
                $ans = $result[$j][$i];
                $ansArray = array($j, $i, $ans);
                echo "<td>" . "<button class='value' value='$j,$i' style='width:30px;height:30px;'></button>" . "</td>";
            }
            echo "</tr>";
        }
        echo ' </table> ';

        echo ' <table width="300" border="1"> ';
        for ($j = 0 ; $j < 10; $j++) {
            echo "<tr>";
            for ($i = 0 ; $i < 10; $i++) {
                $ans = $result[$j][$i];
                $ansArray = array($j, $i, $ans);
                echo "<td>" . "<button style='width:30px;height:30px;'>$ans</button>" . "</td>";
            }
            echo "</tr>";
        }
        echo ' </table> ';
        ?>

        <script>
            $('.value').mousedown(function() {
                var buttonType = event.button;
                if (buttonType == 2) {
                    var value = $(this).attr('value');
                    // alert(value);
                $.ajax({
                    url:"/echo.php",
                    data:{"value":value},
                    type : "POST",
                    dataType:'json',
                    error:function(){
                        alert("失敗");
                        console.log(value);
                    },
                    success:function(res){
                    // var res = JSON.parse(data);
                        if ($(" .value[ value='" + res['y'] + "," + res['x'] + "' ] ").text() != 'F') {
                            $(" .value[ value='" + res['y'] + "," + res['x'] + "' ] ").html('F');
                        }
                        else if ($(" .value[ value='" + res['y'] + "," + res['x'] + "' ] ").text() == 'F') {
                            $(" .value[ value='" + res['y'] + "," + res['x'] + "' ] ").html('');
                        }
                    }
                });
            }
        });

            $('.value').click(function() {
                var value = $(this).attr('value');
                $.ajax({
                url:"/echo.php",
                data:{"value":value},
                type : "POST",
                dataType:'json',
                error:function(){
                    alert("失敗");
                    console.log(value);
                },
                success:function(res){
                    // var res = JSON.parse(data);
                    if (res != 'M') {
                        $(" .value[ value='" + res['y'] + "," + res['x'] + "' ] ").html(res['position']);
                    }
                    if (res['position'] == 'M') {
                        alert('Game Over');
                        console.log(res);
                    }
                }
            });
        });

        </script>
    </body>
</html>
