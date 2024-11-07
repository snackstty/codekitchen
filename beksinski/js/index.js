////////////////////////////////////////////////////////////////////////////////
// REFERENCIAS
const formu = document.querySelector("#formu");
const galeria = document.querySelector("#galeria-div");
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// CARGA DE IMÁGENES DE LA GALERÍA
async function cargaImagenes() {
	let fd = new FormData();
	fd.append("comando", "galeria");
	let opciones = {method: "post", body: fd};
	let respuesta = await fetch("api/api.php", opciones);
	let datos = await respuesta.json();
	for(var item of datos.data) {
		var cadena = `
		<a href="img/${item.url_alta}" data-fancybox="gallery">
		<img src="img/${item.url_baja}">
		</a>
		`;
		galeria.innerHTML += cadena;
	}
}
cargaImagenes();
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// CARGA DE LOS EVENTOS DE LA AGENDA
async function cargaEventos() {
	let fd = new FormData();
	fd.append("comando", "eventos");
	let respuesta = await fetch("api/api.php", {method: "post", body: fd});
	let datos = await respuesta.json();
	// Ponemos en marcha la agenda. Tienes toda la documentación sobre este plugin de jQuery en https://fullcalendar.io/docs
	$("#calendario").fullCalendar({
		locale: "es",
		events: datos.data,	
	});
}
cargaEventos();
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// ENVÍO DEL FORMULARIO DE CONTACTO
formu.onsubmit = async function(e) {
	e.preventDefault();
	let fd = new FormData(formu);
	fd.append("comando", "contacto");
	let respuesta = await fetch("api/api.php", {method: "post", body: fd});
	let datos = await respuesta.json();
	if(datos.meta.ok == true) {
		alert("El mensaje ha sido enviado correctamente\nGracias por ponerte en contacto con nosotros");
		formu.reset();
	} else {
		alert("Atención: se han producido los siguientes errores:\n\n" + datos.meta.errores);
	}
};
////////////////////////////////////////////////////////////////////////////////