<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/style.css">
    <title>Заклинания D&D</title>
</head>
<body>
    <main>
        <div class="page-break"></div>
   <?php 
    include 'functions.php';
?>


<script type="text/javascript">
  function scaleText(containerClass) {
    // Получаем все элементы с заданным классом
    let elements = document.getElementsByClassName(containerClass);

    // Проходим по каждому элементу
    for (let i = 0; i < elements.length; i++) {
      let el = elements[i];
      
      // Выставляем размер шрифта таким образом, чтобы он уложился в рамки контейнера
      for (let fs = 14; el.scrollHeight > el.offsetHeight || el.scrollWidth > el.offsetWidth; fs--) {
        el.style.fontSize = `${fs}px`;
      }

      // Уменьшаем размер шрифта ещё на 1 пункт
      // el.style.fontSize = `${parseInt(el.style.fontSize) - 1}px`;
    }
  }

  // Применяем функцию к элементам с классом 'fixedContainer'
  scaleText('description');
</script>

<script type="text/javascript">
  function scaleText(containerClass) {
    // Получаем все элементы с заданным классом
    let elements = document.getElementsByClassName(containerClass);

    // Проходим по каждому элементу
    for (let i = 0; i < elements.length; i++) {
      let el = elements[i];
      
      // Выставляем размер шрифта таким образом, чтобы он уложился в рамки контейнера
      for (let fs = 10; el.scrollHeight > el.offsetHeight || el.scrollWidth > el.offsetWidth; fs--) {
        el.style.fontSize = `${fs}px`;
      }

      // Уменьшаем размер шрифта ещё на 1 пункт
       el.style.fontSize = `${parseInt(el.style.fontSize) - 1}px`;
    }
  }

  // Применяем функцию к элементам с классом 'fixedContainer'
  scaleText('material-component');
</script>


</main>
</body>
</html>
