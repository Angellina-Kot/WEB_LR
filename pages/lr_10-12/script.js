// Функция calculateY принимает аргумент x и возвращает значение y
function calculateY() {

    var x = parseFloat(document.getElementById('inputX').value);

    try {
        if ((x == null || isNaN(x)) || typeof x != 'number') {
            throw new Error('Некорректный ввод! Введите действительное число.');
        }
        if (x == 1) { // Проверяем деление на ноль
            throw new Error('Ошибка: делить на ноль нельзя!');
        }
        var result = Math.abs((x - 2) / (x - 1)); // Вычисляем выражение
        document.getElementById('resultDiv').innerHTML = 'Результат: ' + result.toFixed(2); // Округляем до двух знаков после запятой
    } catch (err) {
        alert(err.message); // Сообщение об ошибке
        return null;
    }

}