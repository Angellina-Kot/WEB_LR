// События клавиш
function runOnKeys(func, ...codes) {
    let pressed = new Set();

    document.addEventListener('keydown', function (event) {
        pressed.add(event.code);

        for (let code of codes) { // все ли клавиши из набора нажаты?
            if (!pressed.has(code)) {
                return;
            }
        }
        // да, все

        // во время показа alert, если посетитель отпустит клавиши - не возникнет keyup
        // при этом JavaScript "пропустит" факт отпускания клавиш, а pressed[keyCode] останется true
        // чтобы избежать "залипания" клавиши -- обнуляем статус всех клавиш, пусть нажимает всё заново
        pressed.clear();

        func();
    });

    document.addEventListener('keyup', function (event) {
        pressed.delete(event.code);
    });

}

runOnKeys(
    () => alert("ОЙ, Вы что-то нашли, Вы весьма любознательны!"),
    "KeyQ",
    "KeyW"
);

//слайдер, который нужно перетащить на вкладке "оформить заявку"
let slider = document.getElementById('slider');
let thumb = slider.querySelector('.thumb');
let valueBox = document.getElementById('slider-value');
let shiftX = 0;

function updateValue(newLeft) {
    let rightEdge = slider.offsetWidth - thumb.offsetWidth;
    let percent = Math.round((newLeft / rightEdge) * 100);
    valueBox.textContent = percent + '%';
    thumb.dataset.value = percent; // сохраняем значение в dataset (можно потом достать)
}

// Срабатывает при нажатии на ползунок, инициируя процесс перетаскивания
function onThumbDown(event) {
    event.preventDefault();
    shiftX = event.clientX - thumb.getBoundingClientRect().left;

    thumb.setPointerCapture(event.pointerId);
    thumb.onpointermove = onThumbMove;

    thumb.onpointerup = () => {
        thumb.onpointermove = null;
        thumb.onpointerup = null;

        // пример: запись в localStorage (можно заменить на отправку в файл через бекенд)
        localStorage.setItem("sliderValue", thumb.dataset.value);
    };
}

// Срабатывает при перемещении указателя мыши, позволяя ползунку перемещаться в соответствии с движением курсора
function onThumbMove(event) {
    let newLeft = event.clientX - shiftX - slider.getBoundingClientRect().left;

    if (newLeft < 0) newLeft = 0;
    let rightEdge = slider.offsetWidth - thumb.offsetWidth;
    if (newLeft > rightEdge) newLeft = rightEdge;

    thumb.style.left = newLeft + 'px';
    updateValue(newLeft);
}

thumb.onpointerdown = onThumbDown;
thumb.ondragstart = () => false;
