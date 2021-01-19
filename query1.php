
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
            <form class="task-form-container" method="POST" action="query1-result.php">
                <div class="number-of-task">
                    Задание №1
                </div>
                <div class="task-text">
                    Получить информацию о поставщиках, поставивших детали для изделий из указанного города:
                </div>
                <div class="task-input-container">                    
                    <select name="query1-town">
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
                            $res= pg_query($dbconn,"select distinct town from pmib7104.j");
                            if (!$res) 
                            {
                                echo "При выполнении запроса возникла ошибка.\n";
                            }
                            while ($row = pg_fetch_row($res)) 
                            {
                                echo '<option value='.$row[0].'>'.$row[0].'</option>';
                            }
                            pg_free_result($res);
                        }
                    ?>
                    </select>
                </div>
                <button class="btn">
                    Выполнить запрос
                </button>
            </form>
        
    </div>
</body>
</html>