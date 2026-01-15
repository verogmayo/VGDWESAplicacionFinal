const textElement = document.getElementById("text");
const text = "PAGINA EN CONSTRUCCION....";
let index = 0;
let seBorra = false;

function typeEffect() {
    if (!seBorra) {
        textElement.textContent = text.substring(0, index++);
        if (index > text.length) {
            seBorra = true;
            setTimeout(typeEffect, 1000); // Espera antes de borrar
            return;
        }
    } else {
        textElement.textContent = text.substring(0, index--);
        if (index === 0) {
            seBorra = false;
        }
    }
    setTimeout(typeEffect, seBorra ? 100 : 200);
}

typeEffect();