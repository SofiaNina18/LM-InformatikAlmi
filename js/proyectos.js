const elementos = document.querySelectorAll('.carrusel-elemento');
const btnSiguiente = document.querySelector('.btn-siguiente');
const btnAnterior = document.querySelector('.btn-anterior');
let indiceActual = 0;

function mostrarElemento(indice) {
    elementos.forEach(el => el.classList.remove('activo'));
    elementos[indice].classList.add('activo');
}

btnSiguiente.addEventListener('click', () => {
    indiceActual = (indiceActual + 1) % elementos.length;
    mostrarElemento(indiceActual);
});

btnAnterior.addEventListener('click', () => {
    indiceActual = (indiceActual - 1 + elementos.length) % elementos.length;
    mostrarElemento(indiceActual);
});