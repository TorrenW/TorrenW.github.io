<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/style.css">
    <title>Заклинания D&D</title>
    </head>
<body>
<button id="toggleHeader">Скрыть заклинания</button>
<header id="header"> 
<script>
  document.getElementById('toggleHeader').addEventListener('click', function() {
    let header = document.getElementById('header');
    header.classList.toggle('minimised'); // Добавляем или удаляем класс 'minimised'
    
    // Меняем текст кнопки в зависимости от состояния
    if (header.classList.contains('minimised')) {
      this.textContent = 'Развернуть';
    } else {
      this.textContent = 'Минимизировать';
    }
  });
</script>
<select id="class-selector">
  <option value="Empty">Класс не выбран</option>
  <option value="волшебник">Волшебник</option>
  <option value="Бард">Бард</option>
  <option value="Друид">Друид</option>
  <option value="Жрец">Жрец</option>
  <option value="Изобретатель">Изобретатель</option>
  <option value="Колдун">Колдун</option>
  <option value="Паладин">Паладин</option>
  <option value="Следопыт">Следопыт</option>
  <option value="Чародей">Чародей</option>
</select>

<script>
  document.getElementById('class-selector').addEventListener('input', function() {
    let selectedClass = this.value.toLowerCase(); // Приводим выбранное значение к нижнему регистру
    let elements = document.getElementsByClassName('classes');
    for (let i = 0; i < elements.length; i++) {
      if (elements[i].textContent.toLowerCase().includes(selectedClass)) { // Сравниваем с учетом регистра
        let parentElement = elements[i].closest('.spell-item');
        if(parentElement) {
          parentElement.style.display = 'inline-block';
        }
      } else {
        let parentElement = elements[i].closest('.spell-item');
        if(parentElement) {
          parentElement.style.display = 'none'; // Скрываем элемент, если он не соответствует выбранному классу
        }
      }
    }
  });
</script>




<input type="text" id="searchBar" placeholder="Найти заклинание...">

<script>
  document.getElementById('searchBar').addEventListener('input', function() {
    let searchQuery = this.value.toLowerCase();
    let spells = document.querySelectorAll('.spell-item'); // Используем класс 'spell-item'

    spells.forEach(spell => {
      let spellName = spell.querySelector('.spell-name').textContent.toLowerCase(); // Предполагаем, что название заклинания находится в элементе с классом 'spell-name'
      if (spellName.includes(searchQuery)) {
        spell.classList.remove('unmatching'); // Добавляем класс 'matching' для отображения подходящих заклинаний
      } else {
        spell.classList.add('unmatching'); // Удаляем класс 'matching' для скрытия неподходящих заклинаний
      }
    });
  });
</script>





</script>



<form id="sorting">
  <!-- Динамическое создание чекбоксов -->
  <script>
  document.addEventListener('DOMContentLoaded', (event) => {
  // Функция для переключения стиля отображения родительского элемента
  function toggleDisplay(level) {
    let spells = document.querySelectorAll('span.spell-level');
    spells.forEach(spell => {
      if (spell.textContent.trim() === level) {
        let parentElement = spell.closest('.spell-item');
        if(parentElement) {
          parentElement.style.display = parentElement.style.display === 'inline-block' ? '' : 'inline-block';
        }
      }
    });
  }

  // Добавление обработчиков событий к чекбоксам
  for (let i = 0; i <= 9; i++) {
    let checkbox = document.querySelector('#checkbox-' + i);
    checkbox.addEventListener('change', function() {
      if(this.checked) {
        toggleDisplay(this.value);
      } else {
        // Если чекбокс не выбран, скрываем родительские элементы всех заклинаний с этим уровнем
        let spells = document.querySelectorAll('span.spell-level');
        spells.forEach(spell => {
          if (spell.textContent.trim() === this.value) {
            let parentElement = spell.closest('.spell-item');
            if(parentElement) {
              parentElement.style.display = '';
            }
          }
        });
      }
    });
  }
  });


  </script>
  <script>
    for (let i = 0; i <= 9; i++) {
      document.write('<input type="checkbox" id="checkbox-' + i + '" value="' + i + '"> ' + i + ' ');

    }
  </script>
  </form>

  <script>
  // Функция для применения фильтров
  function applyFilters() {
    let selectedClass = document.getElementById('class-selector').value.toLowerCase();
    let checkedLevels = Array.from(document.querySelectorAll('#sorting input[type="checkbox"]:checked')).map(el => el.value);

    let elements = document.getElementsByClassName('spell-item');
    for (let i = 0; i < elements.length; i++) {
      let elementClass = elements[i].getElementsByClassName('classes')[0].textContent.toLowerCase();
      let elementLevel = elements[i].getElementsByClassName('spell-level')[0].textContent.trim();
      // Проверяем соответствие элемента выбранным фильтрам
      let classMatch = selectedClass === 'empty' || elementClass.includes(selectedClass);
      let levelMatch = checkedLevels.length === 0 || checkedLevels.includes(elementLevel);

      // Если элемент соответствует обоим фильтрам или одному из них (если другой не активирован), показываем его
      elements[i].style.display = classMatch && levelMatch ? 'inline-block' : 'none';
    }
  }

  // Обработчик события для фильтра по классу
  document.getElementById('class-selector').addEventListener('input', applyFilters);

  // Обработчик события для фильтра по уровню
  document.addEventListener('DOMContentLoaded', (event) => {
    for (let i = 0; i <= 9; i++) {
      let checkbox = document.querySelector('#checkbox-' + i);
      checkbox.addEventListener('change', applyFilters);
    }
  });
</script>


<?php 
    include 'spells_list.php';
?>



</header>
<main>



<!-- <input type="color" id="colorPicker" style="margin-top: 100px">
<script>
  document.getElementById('colorPicker').addEventListener('input', function() {
      document.documentElement.style.setProperty('--main-bg-color', this.value);
  });
  </script> -->
<input type="color" id="color-picker" style="display:none;">
<input type="color" id="color-picker" style="display:none;">
<button id="toggle-color-button">Стандартный цвет</button>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
  const classSelector = document.getElementById('class-selector');
  const colorPicker = document.getElementById('color-picker');
  const toggleColorButton = document.getElementById('toggle-color-button');
  
  // Функция для получения стандартного цвета по имени класса
  function getStandardColor(className) {
    switch(className.toLowerCase()) {
      case 'волшебник':
        return '#cccccc'; // Замените на ваш стандартный цвет для Волшебника
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      case 'волшебник':
        return '#cccccc';
      
      // Добавьте другие кейсы для каждого класса с их стандартными цветами
      default:
        return '#000000'; // Значение по умолчанию
    }
  }
  
  // Функция для установки стандартного цвета
  function setStandardColor(className) {
    const color = getStandardColor(className);
    document.documentElement.style.setProperty('--main-bg-color', color);
    colorPicker.style.display = 'none'; // Скрыть палитру
    toggleColorButton.textContent = 'Свой цвет'; // Изменить надпись кнопки
  }
  
  // Функция для установки своего цвета
  function setCustomColor(color) {
    document.documentElement.style.setProperty('--main-bg-color', color);
    colorPicker.style.display = 'block'; // Показать палитру
    toggleColorButton.textContent = 'Стандартный цвет'; // Изменить надпись кнопки
  }
  
  // Переключение между стандартным и своим цветом
  let useCustomColor = false;
  toggleColorButton.addEventListener('click', () => {
    useCustomColor = !useCustomColor;
    if(useCustomColor) {
      setCustomColor(colorPicker.value);
    } else {
      setStandardColor(classSelector.value);
    }
  });
  
  // Обработчик событий для выпадающего списка
  classSelector.addEventListener('change', (e) => {
    if(!useCustomColor) {
      setStandardColor(e.target.value);
    }
  });
  
  // Обработчик событий для выбора своего цвета в палитре
  colorPicker.addEventListener('input', (e) => {
    if(useCustomColor) {
      setCustomColor(e.target.value);
    }
  });
});

</script>


<button id="activateFunction" >Активировать функцию</button>
<button id="adjust-text">подстроить текст</button>
<script>
  document.getElementById('adjust-text').addEventListener('click', function() {
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
  });
  </script>
<div class="page-break"> 
<div id="functionResult"></div>
<script>
  document.getElementById('activateFunction').addEventListener('click', function() {
    fetch('functions.php', {
      method: 'POST',
      // Дополнительные данные можно отправить через тело запроса, если это необходимо
      // body: JSON.stringify({ key: 'value' })
    })
    .then(response => response.text())
    .then(data => {
      // Вставляем данные в элемент с id="functionResult"
      document.getElementById('functionResult').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
  });
  </script>
<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.spell-checkbox').forEach((checkbox) => {
      checkbox.addEventListener('change', (event) => {
        let spellName = event.target.closest('.spell-item').querySelector('.spell-name span').textContent;
        let action = event.target.checked ? 'add' : 'remove';
        
        fetch('spell_handler.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `spellName=${encodeURIComponent(spellName)}&action=${action}`
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
      });
    });
  });
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
