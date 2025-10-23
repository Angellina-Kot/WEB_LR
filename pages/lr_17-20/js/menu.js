//появление меню
const o = document.querySelector(".menu__icon"), 
r = document.querySelector(".menu__body"); 
o && o.addEventListener("click",
    (function (e) {
        document.body.classList.toggle("_lock"),
            o.classList.toggle("_active"), r.classList.toggle("_active")
    }));