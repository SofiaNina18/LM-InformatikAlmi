const botonIrRegistro = document.getElementById('irARegistro');
const botonIrLogin = document.getElementById('irALogin');
const contenedorPrincipal = document.getElementById('contenedor');

botonIrRegistro.addEventListener('click', () => {
    contenedorPrincipal.classList.add("activar-registro");
});

botonIrLogin.addEventListener('click', () => {
    contenedorPrincipal.classList.remove("activar-registro");
});