//открытие картинок в отдельном окне
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("img-modal");
    const modalImg = document.getElementById("img-modal-content");
    const closeBtn = document.querySelector(".img-modal__close");

    document.querySelectorAll(".services__img").forEach(img => {
        img.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.src;
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    }
});