<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <title>BD_lab7_br4_3</title>
</head>
<body>
    <div class="wrapper">
            <form class="task-form-container" method="POST" action="query2-result.php">
                <div class="number-of-task">
                    Задание №2
                </div>
                <div class="task-text">
                    Увеличить рейтинг поставщика, выполнившего наибольшую поставку заданной детали, на указанную величину:
                </div>
                <?php
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
                            $res = pg_query($dbconn,"select n_post, name, reiting, town from pmib7104.s");
                            if (!$res) 
                            {
                                echo "При выполнении запроса возникла ошибка.\n";
                            }
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
                            
                            pg_free_result($res);
                ?>
                <div class="task-input-container">
                    Выберите деталь:
                    <select name="query2-n_det">
                    <?php
                            $res = pg_query($dbconn,"select distinct p.n_det from pmib7104.p order by p.n_det");
                            if (!$res) 
                            {
                                echo "При выполнении запроса возникла ошибка.\n";
                            }
                            while ($row = pg_fetch_row($res)) 
                            {
                                echo '
                                <option value='.$row[0].'>'.$row[0].'</option>';
                            }
                            pg_free_result($res);
                        
                    ?>
                    </select>
                </div>
                <div class="task-input-container">
                Укажите величину:
                <input class="task-input" placeholder="Введите число" name="query2-value" type="text" size="9" >
                </div>
                <?php } ?>
                <button class="btn">
                    Выполнить запрос
                </button>
            </form>
    </div>
</body>
</html>