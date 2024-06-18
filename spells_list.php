<?php
function transformSpells($inputFile, $outputFile) {
    $content = file_get_contents($inputFile);
    
    // Убираем пустые строки
    $content = trim(preg_replace("/[\r\n]+/m","\r\n", $content));
    
    // Разбиваем контент на строки
    $lines = explode("\r\n", $content);
    
    $transformedLines = [];
    foreach ($lines as $line) {
        // Если строка содержит символ [ и не содержит символ ., добавляем пустую строку перед ней
        if (strpos($line, '[') !== false && strpos($line, '.') === false) {
            $transformedLines[] = '';
        }
        $transformedLines[] = $line;
    }
    
    // Объединяем строки обратно в контент
    $transformedContent = implode("\r\n", $transformedLines);

    file_put_contents($outputFile, $transformedContent);
}

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

function printSpellList($spells) {
    echo '<div class="spell-list">';
    foreach ($spells as $spell) {
        $spellData = json_encode([]);

        echo '<div class="spell-item">';
        echo " <p class='classes'>{$spell['classes']}</p>";
        echo "<input type='checkbox' class='spell-checkbox' data-spell='" . htmlspecialchars($spellData) . "'>";
        
        // Извлекаем уровень заклинания
        $level = 0;
        if (strpos($spell['school'], 'Заговор') !== false) {
            $level = 0;
        } elseif (preg_match('/(\d+)/', $spell['school'], $matches)) {
            $level = $matches[1];
        }
        echo "<span class='spell-level'>{$level}</span>";
        
        // Объединяем русское и английское название без переноса
        $name = str_replace('<br>', ' ', $spell['name']);
        echo " <span class='spell-name'>{$name}</span>";
        
        echo '</div>';
    }
    echo '</div>';
}

function printSpellCardToString($spell) {
    ob_start();
    printSpellCard($spell);
    return ob_get_clean();
}

// Очищаем файл spells_output.txt при открытии страницы
file_put_contents("spells_output.txt", "");

// Преобразуем файл spells.txt и сохраняем результат в spells_transform.txt
transformSpells('spells.txt', 'spells_transform.txt');
// Получаем массив заклинаний
$spells = parseSpells('spells_transform.txt');

// Добавим проверку наличия данных заклинаний
if (empty($spells)) {
    die('Ошибка: не удалось получить данные заклинаний.');
}

// Выводим список всех заклинаний
printSpellList($spells);
?>
