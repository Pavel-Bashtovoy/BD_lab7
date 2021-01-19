<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD_lab7_br4_3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style= "padding-left:10px;">
<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
    $host='students.ami.nstu.ru';
    $db = 'students';
    $username = 'pmi-b7104';
    $password = 'JiHanth';
    $dbconn = pg_connect("host=$host port=5432 dbname=$db  user=$username password=$password");

if (!$dbconn) 
{
    die('ERROR:Could not connect!');
}
else 
{
    $n_det = $_POST['query2-n_det'];
    $value = $_POST['query2-value'];
    $query2 = "updated pmib7104.s
    set reiting = reiting + $2
    where pmib7104.s.n_post in (
    select pmib7104.spj.n_post
    from pmib7104.spj
    where pmib7104.spj.n_det = $1 and pmib7104.spj.kol = (
    select max(kol)
    from pmib7104.spj
    where n_det = $1));";
    pg_query($dbconn,"BEGIN");

    if ($res = pg_prepare($dbconn,"query2", $query2)) 
    {
        if ($res = pg_execute($dbconn, "query2", array($n_det, $value))) 
        {

            $affected_rows = pg_affected_rows($res);
            pg_free_result($res);
            ?>
                <div class="number-of-task">
                Результаты запроса:
                </div>
            <?php
            echo '
            <table>
            <tr>
                <th>n_post</th>
                <th>name</th>
                <th>reiting</th>
                <th>town</th>
            </tr>';
            $get_table_s = "select n_post, name, reiting, town from pmib7104.s;";
            $res = pg_query($dbconn, $get_table_s);
            while ($row = pg_fetch_row($res)) 
            {
                echo '
                <tr>
                    <td>'.$row[0].'</td>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                </tr>';
            }
            echo '</table>';
            echo "Обработано $affected_rows строк(а/и)<br><br>";
        ?>
            <div class="task-result">
                SQL-запрос выполнен
            </div>
            <button onclick="window.location.href = 'query2.php';">Повторить запрос</button>
        <?php
            pg_free_result($res);
            pg_query($dbconn, "COMMIT");
            pg_close($dbconn);
            return 1;
        }
        else 
        {
            echo pg_last_error($dbconn);
        ?>
            <button onclick="window.location.href = 'query2.php';">Повторить запрос</button>
        <?php
            pg_query($dbconn, "ROLLBACK");
            pg_free_result($res);            
        }
    }
    else {
        echo "pg_prepare\n";
        echo pg_last_error($dbconn);
        pg_query($dbconn, "ROLLBACK");        
    }
}
?>
</body>
</html>