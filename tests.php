<?php


Misc::start();

class Misc
{
    public static function goHome(): void
    {
        header('Location: http://localhost:3000/');
    }

    public static function session_message(): void
    {
        if (!empty($_SESSION['errorMessage']))
        {
            echo $_SESSION['errorMessage'];
            unset($_SESSION['errorMessage']);
        }
    }

    public static function csrf_token_create(): void
    {
        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function start(): void
    {
        session_start();
        define('MAX_BROS_OR_SISTRS', 30);
        Misc::csrf_token_create();
        Misc::session_message();
    }

    public static function array_multisum(array $arr): mixed
    {
        $sum = array_sum($arr);
        return $sum <= 0 ? " " : $sum;
    }
}


class Database
{    public static function getConfig(): array
    {
        $config = json_decode(file_get_contents('secrets.json'), true);
        return ['dsn' => $config['dsn'],  'user' => $config['user'], 'pass' => $config['pass']];
    }

    public static function addComment($text): void
    {
        $config = Database::getConfig();
        $pdo = new PDO($config['dsn'], $config['user'], $config['pass']);

        $sql = 'INSERT INTO comments (text) VALUES (:text)';

        $sth = $pdo->prepare($sql);
        $sth->execute(['text' => $text]);        
    }
}


class interVolgaTests
{

    public static function family(int $countSisters, int $countBrothers): string
    {
        /*  Тест - У Алисы есть n сестер и m братьев. 
            Описание:
            Напишите функцию на php, принимающую эти параметры и возвращающую количество сестер произвольного брата Алисы.
        */ 
        if ($countBrothers <= 0) {return "у Алисы нет братьев :(";}
        if ($countSisters <= 0) {return "у Алисы нет сестёр :(";}
        if ($countSisters >= MAX_BROS_OR_SISTRS or $countBrothers >= MAX_BROS_OR_SISTRS) {return "Это слишком...";}

        $randomBrother = rand(1, $countBrothers);
        $countSisters = rand(1, $countSisters);

        return "У $randomBrother-го брата Алисы $countSisters сестёр!";
    }


    public static function news(): void
    {
        /*  Тест - Дан текст новости 
            Описание:
            Необходимо обрезать его до 29 слов с добавлением многоточия.
            Форматирование необходимо сохранить.
        */
        $text = <<<TXT
        <p class="big">
            Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
        </p>
        <p class="float">
            <img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
            <span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
        </p>
        <p>
            <i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
        </p>
        TXT;

        $text = trim($text);
        $wordLimit = 29;

        preg_match_all('/(<.*?>|[^<>\s]+)/', $text, $matches);
        
        $words = [];
        $count = 0;
        
        foreach ($matches[0] as $part) {
            // Если это тег, добавляем его в слова без увеличения счетчика
            if (preg_match('/^<.*?>$/', $part)) {
                 $words[] = $part;
            } else {
                // Если это слово, добавляем его и увеличиваем счетчик
                $words[] = $part;
                $count++;

                if ($count >= $wordLimit) {
                    break;
                }
            }
        }
        
        $truncatedText = implode(' ', $words);
            
        // Если обрезанный текст меньше исходного, добавляем многоточие
        if (count($matches[0]) > $count) {
            $truncatedText .= '...';
        }    
        echo $truncatedText;    
    }


    public static function getComments(): void
    {
        /*
            Тест - вывод комментариев
        */
        $config = Database::getConfig();
        $pdo = new PDO($config['dsn'], $config['user'], $config['pass']);

        $sql = 'SELECT text, insert_at FROM comments';

        $result = $pdo->query($sql, PDO::FETCH_ASSOC)->fetchAll() ?? [];

        foreach ($result as $comment)
        {
            $text = htmlspecialchars($comment['text']);
            $time = $comment['insert_at'];
            echo 
                "<div style='display:flex;gap:1rem;'> 
                    <p>$text</p> <p>||</p> <p>$time</p>
                </div>
                ";
        }
    }


    public static function arrayTest(): void
    {
        $data = [
            ['Иванов', 'Математика', 5],
            ['Иванов', 'Математика', 4],
            ['Иванов', 'Математика', 5],
            ['Петров', 'Математика', 5],
            ['Сидоров', 'Физика', 4],
            ['Иванов', 'Физика', 4],
            ['Петров', 'ОБЖ', 4]
        ];

        $items = array_unique(array_column($data, 1)) ?? [];
        sort($items);


        $studentsAndGrades = [];

        // К этому решению пришел спустя довольно долгое время...
        // Берем изначальный массив и пересобираем его в формат: 
        /* [
            'Ученик' => ['Предмет' => [список_оценок], 'Предмет' => [список_оценок],
            'Ученик' => ['Предмет' => [список_оценок], 'Предмет' => [список_оценок]
            ];
        */ 
        foreach ($data as [$student, $item, $grade])
        {
            $studentsAndGrades = array_merge_recursive($studentsAndGrades, [$student => [$item => [$grade]]]);
        }

        arsort($studentsAndGrades);
        
        // Доп. проверка чтобы не создавать таблицу в случае отсутствия предметов
        if (count($items) > 0)
        {
            echo "<table>
                    <tr>
                        <th>
                        </th>";
            // Создаем таблицу и сразу вписываем все предметы
            array_map(function($item) {echo "<th>$item</th>";}, $items);
            echo   "</tr>";

            foreach ($studentsAndGrades as $student => $grades)
            {
                echo "<tr><td>$student</td>";
                foreach ($items as $item)
                {   // Ищем предмет в оценках ученика, если его нет, то будет пробел в оценках
                    $grade = Misc::array_multisum($grades[$item] ?? []);
                    echo "<td>$grade</td>";
                }
                echo "</tr>";
            }
                           
            echo "</table>";
        }
    }
}
