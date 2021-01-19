<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD_lab7_br4_3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="padding-left:10px;">
<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
    $host='students.ami.nstu.ru';
    $db = 'students';
    $username = 'pmi-b7104';
    $password = 'JiHanth6';
    $dbconn = pg_connect("host=$host port=5432 dbname=$db  user=$username password=$password");

if (!$dbconn) 
{
    die('Could not connect');
}
else 
{

    $town = $_POST['query1-town'];
    $query1 = "select distinct pmib7104.s.n_post, pmib7104.s.name, pmib7104.s.reiting, pmib7104.s.town
                from pmib7104.spj
                join pmib7104.j on pmib7104.spj.n_izd = pmib7104.j.n_izd
                join pmib7104.s on pmib7104.s.n_post = pmib7104.spj.n_post 
                where pmib7104.j.town = $1";
        
    $res = pg_prepare($dbconn,"query1", $query1);
    $res = pg_execute($dbconn, "query1", array($town));
        if(!$res) 
        {
            echo "Ошибка  в pg_prepare\n";
            echo pg_last_error($dbconn);
        ?>
            <button onclick="window.location.href = 'query1.php';">Повторить запрос</button>
        <?php
        }
        else 
        {
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
        ?>
            <div class="task-result">
            SQL-запрос выполнен
            </div>
            <br><button onclick="window.location.href = 'query1.php';">Повторить запрос</button>
        <?php
            pg_free_result($res);
            pg_close($dbconn);
            return 1;
        }   
}
?>
</body>
</html>