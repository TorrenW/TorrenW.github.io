<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spellName = $_POST['spellName'];
    $action = $_POST['action'];
    
    // Читаем содержимое файла spells_transform.txt
    $spellsContent = file_get_contents("spells_transform.txt");
    
    if ($action == 'add') {
        // Ищем заклинание по названию и до символов "\r\n\r\n"
        $pattern = '/'.preg_quote($spellName, '/').'(.*?)\r\n\r\n/s';
        preg_match($pattern, $spellsContent, $matches);
        
        if (!empty($matches)) {
            // Получаем полное описание заклинания
            $fullSpell = $matches[0];
            
            // Заменяем лишние символы "\r\n"
            $fullSpell = str_replace("\r\n\r\n", "\r\n", $fullSpell);
            
            // Открываем файл для добавления
            $file = fopen("spells_output.txt", "a") or die("Unable to open file!");
            
            // Записываем полное заклинание в файл
            fwrite($file, $fullSpell . PHP_EOL);
            
            // Закрываем файл
            fclose($file);
            
            echo "Spell saved: " . $spellName;
        } else {
            echo "Spell not found: " . $spellName;
        }
    } elseif ($action == 'remove') {
        // Читаем текущее содержимое файла spells_output.txt
        $currentContent = file_get_contents("spells_output.txt");
        
        // Ищем и удаляем заклинание из содержимого
        $pattern = '/'.preg_quote($spellName, '/').'(.*?)\r\n\r\n/s';
        $updatedContent = preg_replace($pattern, '', $currentContent);
        
        // Перезаписываем файл с обновленным содержимым
        file_put_contents("spells_output.txt", $updatedContent);
        
        echo "Spell removed: " . $spellName;
    }
} else {
    echo "No spell name received";
}
?>