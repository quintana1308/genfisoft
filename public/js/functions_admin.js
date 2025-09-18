// loadin de carga y navegacion en diferentes vistas
window.addEventListener("load", () => {
  const contenedor = document.querySelector("#divLoadingVista");
  contenedor.style.display = "none";
});

// para desvincular el telefono del sistema
function confirmLogout(event) {
  event.preventDefault();
  
  Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Esta acción te desvinculará!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, desvincular',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
          
          window.location.href = base_url+'/Home/desvincular';
      }
  });
}
// fin del desvinculamiento


// modo oscuro
function temaOscuro() {
  document.querySelector('body').classList.add('dark-mode');
  document.querySelector('body').classList.remove('light-mode');
  localStorage.setItem('theme', 'dark');
  localStorage.setItem('class', 'dark-mode');
  
  // Cambiar la imagen de fondo en modo oscuro
  document.querySelector('#kt_sidebar').style.backgroundImage = "url('" + base_url + "/images/siv.jpg')";
  document.querySelector('#modeImage').setAttribute('src', base_url + '/images/media/svg/avatars/soleado.png');
  document.querySelector('#logoPryvitHome').setAttribute('src', base_url + '/images/uploads/pryvit3-blanco.png');

};

function temaClaro() {
  document.querySelector('body').classList.add('light-mode');
  document.querySelector('body').classList.remove('dark-mode');
  localStorage.setItem('theme', 'light');
  localStorage.setItem('class', 'light-mode');
  
  document.querySelector('#kt_sidebar').style.backgroundImage = "url('" + base_url + "/images/siv1.jpg')";
  document.querySelector('#modeImage').setAttribute('src', base_url + '/images/media/svg/avatars/luna.png');
  document.querySelector('#logoPryvitHome').setAttribute('src', base_url + '/images/uploads/pryvit1.png');
};

function cambiarTema(){
  const body = document.querySelector('body');
  const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
  if (currentTheme === 'light') {
    temaOscuro();
  } else {
    temaClaro();
  }
};

function aplicarTema(){
  const savedTheme = localStorage.getItem('theme') || 'light'; // Por defecto 'light'
  if (savedTheme === 'dark') {
    temaOscuro();
  } else {
    temaClaro();
  }
};
// Aplicar el tema guardado cuando la página carga
document.addEventListener('DOMContentLoaded', aplicarTema);

// fin del modo oscuro

