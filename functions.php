<?php
function parseSpells($filePath) {
    $content = file_get_contents($filePath);
    $spells = preg_split('/\n\s*\n/', trim($content));
    $spellData = [];
    
    foreach ($spells as $spell) {
        $lines = explode("\n", trim($spell));
        $name = array_shift($lines);
        
        // Разделяем имя на русскую и английскую части
        $nameParts = explode('[', $name);
        $nameRussian = '<span>' . trim($nameParts[0]) . '</span><br>';
        $nameEnglish = isset($nameParts[1]) ? '[' . $nameParts[1] : '';
        $name = $nameRussian . $nameEnglish;

        $data = [
            'name' => $name,
            'school' => '',
            'casting_time' => '',
            'range' => '',
            'components' => '',
            'duration' => '',
            'classes' => '',
            'description' => ''
        ];

        foreach ($lines as $line) {
            if (strpos($line, 'Заговор') !== false || strpos($line, '1 уровень') !== false || strpos($line, '2 уровень') !== false || strpos($line, '3 уровень') !== false || strpos($line, '4 уровень') !== false || strpos($line, '5 уровень') !== false || strpos($line, '6 уровень') !== false || strpos($line, '7 уровень') !== false || strpos($line, '8 уровень') !== false || strpos($line, '9 уровень') !== false) {
                $data['school'] = $line;
            } elseif (strpos($line, 'Время накладывания') !== false) {
                $data['casting_time'] = str_replace('Время накладывания: ', '', $line);
            } elseif (strpos($line, 'Дистанция') !== false) {
                $data['range'] = str_replace('Дистанция: ', '', $line);
            } elseif (strpos($line, 'Компоненты') !== false) {
                $data['components'] = str_replace('Компоненты: ', '', $line);
            } elseif (strpos($line, 'Длительность') !== false) {
                $data['duration'] = str_replace('Длительность: ', '', $line);
            } elseif (strpos($line, 'Классы') !== false) {
                $data['classes'] = str_replace('Классы: ', '', $line);
            } elseif (strpos($line, 'Подклассы') !== false || strpos($line, 'Источник') !== false) {
                // Игнорируем строки "Подклассы" и "Источник"
                continue;
            } else {
                $data['description'] .= $line . ' ';
            }
        }

        // Обрабатываем 'description' отдельно, добавляем тег <br> после каждого переноса строки "\r\n"
        $data['description'] = str_replace("\r", "<br>", trim($data['description']));

        $spellData[] = $data;
    }
    
    return $spellData;
}

function reorderCards(&$array, $order) {
    $newArray = [];
    foreach ($order as $index) {
        if (isset($array[$index])) {
            $newArray[] = $array[$index];
        }
    }
    $array = $newArray;
}

function addEmptyCards(&$array, $totalCards) {
    $cardsPerPage = 9;
    $missingCards = $cardsPerPage - ($totalCards % $cardsPerPage);
    if ($missingCards < $cardsPerPage) {
        for ($i = 0; $i < $missingCards; ++$i) {
            array_push($array, ['name' => '', 'school' => '', 'casting_time' => '', 'range' => '', 'components' => '', 'duration' => '', 'description' => '']);
        }
    }
}

function printSpellCard($spell) {
    echo "<div class='spell-card'>";
    echo "<table><tr><td class='name' colspan='2'><h2>{$spell['name']}</h2></td>";
    echo "</tr><tr>";
    echo "    <td colspan='2'><div class='description'>{$spell['description']}</div>";
    $level = 0; // По умолчанию уровень равен 0
    if (preg_match('/(\d+)/', $spell['school'], $matches)) {
        // Если в строке 'school' есть цифры, используем их как уровень
        $level = $matches[1];
    } elseif (strpos($spell['school'], 'Заговор') !== false) {
        // Если в строке 'school' есть слово 'Заговор', уровень остается 0
        $level = 0;
    }
    echo "<p>{$level}</p>";
    echo "</td>";
    echo "</tr><tr class='school'><td colspan='2'>{$spell['school']}</td></tr></table>";
    echo "</div>";
}

function printSpellBack($spell) {
    if (empty($spell['name'])) {
        echo "<div class='empty-card'></div>";
        return;
    }

    echo "<div class='spell-back'>";
    echo "<table><tr><td class='name' colspan='3'><h2>{$spell['name']}</h2></td></tr>";
    echo "<tr class='icon-top'>"; 
    echo "<td><img src='/src/img/cast_time.svg'><p style='font-family:MartaBold;'>Время накладывания</p><p>{$spell['casting_time']}</p></td>";
    echo "<td><img src='/src/img/Range.svg'><p style='font-family:MartaBold;'>Дистанция</p><p>{$spell['range']}</p></td>";
    echo "<td><img src='/src/img/duration.svg'><p style='font-family:MartaBold;'>Длительность</p><p>{$spell['duration']}</p></td>";
    echo "</tr>";
    echo "<tr><td></td><td></td><td></td></tr>";
    echo "<tr class='icon-bottom'><td>";
    if (strpos($spell['components'], 'В') !== false) {
        echo "<img src='/src/img/mouth.svg'>";
    }
    echo "</td><td>";
    if (strpos($spell['components'], 'С') !== false) {
        echo "<img src='/src/img/hand.svg'>";
    }
    echo "</td><td>";
    if (strpos($spell['components'], 'М') !== false) {
        echo "<img src='/src/img/bag.svg'>";
        if (preg_match('/М\s*\((.*?)\)/', $spell['components'], $matches)) {
            $mComponents = $matches[1];
            echo "<div style='height: -webkit-fill-available; display: contents;'><p class='material-component' style='font-family:MartaBold;'>{$mComponents}</p>";
        }
    }
    echo "</td></tr></table>";
    echo "<img style='display:none' class='class-img' src='/src/img/monk.svg'></div>";
}

function swapColumns($array) {
    $order = [2, 1, 0, 5, 4, 3, 8, 7, 6]; // Новый порядок, меняющий местами левый и правый столбцы
    $newArray = [];
    foreach ($order as $index) {
        if (isset($array[$index])) {
            $newArray[] = $array[$index];
        }
    }
    return $newArray;
}

function printSpellCardToString($spell) {
    ob_start();
    printSpellCard($spell);
    return ob_get_clean();
}

function printSpellBackToString($spell) {
    ob_start();
    printSpellBack($spell);
    return ob_get_clean();
}



$spells = parseSpells('spells_output.txt');

$file = 'spells_transform.txt'; // Имя файла
$data = "\r\n\r\nКОНЕЦ";
file_put_contents($file, $data, FILE_APPEND);


// Добавим проверку наличия данных заклинаний
if (empty($spells)) {
    die('Ошибка: не удалось получить данные заклинаний.');
}

echo '<main>';

$cardsPerPage = 9; // Количество карт на странице
$totalCards = count($spells); // Общее количество карт
$totalPages = ceil($totalCards / $cardsPerPage); // Общее количество страниц

for ($p = 0; $p < $totalPages; $p++) {
    // Выводим карты
    for ($i = $p * $cardsPerPage; $i < min(($p + 1) * $cardsPerPage, $totalCards); $i++) {
        if (isset($spells[$i])) {
            printSpellCard($spells[$i]);
        }
    }

    echo "<div class='page-break'></div>"; // Разделитель страницы
    echo "<div class='spell-back-block'>"; // начало блока рубашек

    // Получаем подмножество рубашек для текущей страницы
    $currentSpellsBacks = array_slice($spells, $p * $cardsPerPage, $cardsPerPage);
    
    // Добавляем пустые карты, если нужно
    addEmptyCards($currentSpellsBacks, count($currentSpellsBacks));
    
    // Меняем местами столбцы
    $currentSpellsBacks = swapColumns($currentSpellsBacks);

    // Корректно выводим каждую рубашку заклинания
    foreach ($currentSpellsBacks as $spellBack) {
        printSpellBack($spellBack);
    }

    echo "</div>"; // конец блока рубашек
    echo "<div class='page-break'></div>"; // Разделитель страницы
}



?>
