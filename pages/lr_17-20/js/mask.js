//маска ввода
document.addEventListener('DOMContentLoaded', function () {
    // Используем метод inputmask для настройки формата ввода
    $('#phone-input').inputmask({
        mask: '+7 (999) 999-9999',
        showMaskOnHover: false,
        clearIncomplete: true
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');

    phoneInputs.forEach(input => {
        input.addEventListener('input', maskPhone);
        input.addEventListener('focus', maskPhone);
        input.addEventListener('blur', maskPhone);
        input.addEventListener('keydown', maskPhone);
    });

    function maskPhone(event) {
        let keyCode;
        if (event.keyCode) {
            keyCode = event.keyCode;
        }

        let input = event.target,
            matrix = "+7 (___) ___-__-__",
            i = 0,
            def = matrix.replace(/\D/g, ""),
            val = input.value.replace(/\D/g, ""),
            newValue = matrix.replace(/[_\d]/g, function (a) {
                return i < val.length ? val.charAt(i++) : a;
            });

        i = newValue.indexOf("_");
        if (i !== -1) {
            newValue = newValue.slice(0, i);
        }

        let reg = matrix.substr(0, input.value.length).replace(/_+/g,
            function (a) {
                return "\\d{1," + a.length + "}";
            }).replace(/[+()]/g, "\\$&");

        reg = new RegExp("^" + reg + "$");

        if (!reg.test(input.value) || input.value.length < 5 || keyCode > 47 && keyCode < 58) {
            input.value = newValue;
        }

        if (event.type === "blur" && input.value.length < 18) {
            input.value = "";
        }
    }
});