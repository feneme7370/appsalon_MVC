let paso = 1;

const pasoInicial = 1;
const pasoFinal = 3;

const cita ={
    id : '',
    nombre : '',
    fecha : '',
    hora : '',
    servicios : []
}

//cuando todo el documento este cargado va a ejecutar las funciones de dentro
document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});
/* ============ INICIAR APP ============ */
function iniciarApp(){
    //SECCION CITA
    mostrarSeccion();//muestra y oculta secciones, e inicia con 1 que esta definido
    tabs();//cambia las secciones cuando se presiona
    botonesPaginador();
    paginaAnterior();
    paginaSiguiente();

    //CONSULTAR API
    consultarAPI();//consulta el backend

    idCliente();//agrega el id del cliente a la cita
    nombreCliente();//agrega el nombre del cliente a la cita
    seleccionarFecha();//agrega la fecha a la cita
    seleccionarHora();//agrega la hora de la cita

    //MOSTRAR RESUMEN
    mostrarResumen();//muestra el resumen de la cita
}

/* ============ MOSTRAR SECCIONES ============ */
function mostrarSeccion(){
    //remover a la que ya tiene mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //selecciona el elemento a mostrar
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    //remover el titulo ya marcado
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //resalta el titulo seleccionado
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

/* ============ ELEGIR CON TABS SUPERIORES ============ */
function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    
    //cuando es un All no se puede hacer botones.add.. porque debe ser a cada elemento seleccionado, por lo tanto se debe iterar

    botones.forEach( (boton) => {
        boton.addEventListener('click', function (e){
            paso = parseInt(e.target.dataset.paso);//se accede al atributo creado con data- y se le asigna el valor a la variable paso (1,2,3)
            
            mostrarSeccion();
            botonesPaginador();

        });
    } );
    
}

/* ============ ELEGIR CON BOTONES INFERIORES ============ */
//mostrar y ocultar botones segun la posicion
function botonesPaginador(){
    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }else if (paso === 3){
        botonSiguiente.classList.add('ocultar');
        botonAnterior.classList.remove('ocultar');
        mostrarResumen();
    }else{
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso <= pasoInicial){
            return;
        }else{
            paso--;
        }
        botonesPaginador();
    });
}
function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso >= pasoFinal){
            return;
        }else{
            paso++;
        }
        botonesPaginador();
    });
}

/* ============ CONSULTAR API AL BACKEND ============ */
//CONSULTAR API
async function consultarAPI(){
    try {
        const url = 'http://localhost:3000/api/servicios';//donde se encuentran los datos
        const resultado = await fetch(url);//agarra los resultados
        const servicios = await resultado.json();//los transforma a json desde el array asoc
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

/* ============ MOSTRAR TARJETAS CON LOS SERVICIOS ============ */
//mostrar datos traidos de la api
function mostrarServicios(servicios){
    //se itera para poder usar cada elemento
    servicios.forEach( (servicio) => {
        const {id, nombre, precio} = servicio; //no entiendo que asigna aca

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        //servicioDiv.onclick = seleccionarServicio;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        //agregar los elementos como hijos de un div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        //agrega el div como hijo de otro que esta en la view
        document.querySelector('#servicios').appendChild(servicioDiv);
        
    });
}

function seleccionarServicio(servicio){
    const { id } = servicio; //lo extra de la variable cita arriva
    const { servicios } = cita; //lo extra de la variable cita arriva
    
    //identificar al elemento que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //some verifica si dentro de un arreglo ya esta agregado un elemento
    //agregado.id es cuando ahces click, y servicio es el objeto con todo, si da true es porque ya estaba seleccionado
    if(servicios.some( agregado => agregado.id === servicio.id )){
        //si esta agregado se debe eliminar
            //filter elimina un elemento pero entiendo que elimina no lo que no es igual a lo seleccionado?
        cita.servicios = servicios.filter( agregado => agregado.id !== id);//id es lo mismo que servicio.id
        divServicio.classList.remove('seleccionado');
    }else{
        //agregarlo
        cita.servicios = [...servicios, servicio];//...servicios toma una copia con el string vacio, y agrega el elemento nuevo servicio, luego reescrivimos la variable servicios dentro de cita
        divServicio.classList.add('seleccionado');
    }
    
}

/* ============ INGRESAR DATOS DE LA CITA ============ */
function idCliente(){
    const id = document.querySelector('#id').value;
    
    cita.id = id;
}
function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    
    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        
        //crea un objeto con el valor del dia completo de informacion
            //con getUTCDay trae a numeros los dias domingo=0
        const dia = new Date(e.target.value).getUTCDay();

        if( [6,0].includes(dia) ){
            e.target.value = '';
            mostrarAlerta('error', 'los sabados y domingos no abrimos','.formulario');
        }else{
            //agrega al objeto cita, en la parte de fecha el valor
            cita.fecha = e.target.value;
        }
        
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){

        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];
        const minutos = horaCita.split(':')[1];
        if(hora < 8 || hora > 22){
            e.target.value = '';
            mostrarAlerta('error', 'el horario es de 8 a 22', '.formulario');
        }else{
            cita.hora = e.target.value;
        }
        
    });
}
function mostrarAlerta(tipo, mensaje, elemento, desaparece = true){
    //previene si ya hay una alerta
    const alertaAnterior = document.querySelector(elemento + ' .alerta');
    if(alertaAnterior){
        alertaAnterior.remove();
    }

    //script para crear alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    
    //agregar la alerta al formulario
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        //eliminar alerta
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

/* ============ MOSTRAR RESUMEN FINAL ============ */
function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //limpiar el contenido de resumen para sacar alerta
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('error', 'hacen falta datos o servicios', '.contenido-resumen', false);
        return;//corta ejecucion de codigo     
    }
    
    //formatear el div de resumen
    const {nombre, fecha, hora, servicios} = cita;

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //formatear fecha en en el idioma
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() +2;//se le suma 2 porque cada vez que se instncia una new date, al comenzar de 0 y no 1, se va restando, y quedan dos dias menos al marcado
    const anio = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(anio, mes, dia));

    const opciones = {weekday : 'long', year : 'numeric', month : 'long', day : 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR',opciones);

    
    
    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} Hs`;
    
    //boton para crear cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = reservarCita;//no lleva parentesis la funcion porque sino la llamaria en el momento

    resumen.append(nombreCliente);
    resumen.append(fechaCliente);
    resumen.append(horaCliente);

    resumen.append(botonReservar);
    
    //heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de servicios';
    resumen.appendChild(headingServicios);

    
    //recorrer array de servicios para mostrarlos en html
    servicios.forEach( servicio => {
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');
        
        const textoServicio = document.createElement('P');
        textoServicio.textContent = servicio.nombre;
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${servicio.precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        
        resumen.appendChild(contenedorServicio);
    })
    
}
//console.log([...datos]);
//para poder ver lo que se envia, se hace una copia de la variable datos y se ve solo eso, no el formData en si

async function reservarCita(){
    //extrar variables en una linea
    const {nombre, fecha, hora, servicios, id} = cita;

    //foreach solo itera, mientra que map las coincidencias las coloca en la variable
        //agara solo los servicios que corresponden
    const idServicios = servicios.map(servicio => servicio.id)

    const datos = new FormData();
    //el primer parametro es como se va a acceder el POST[nobmre], lo segundo es el value
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    //validar url con trycatch
    try {
        //peticion a la api
        const url = 'http://localhost:3000/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
    
        console.log(datos);
        const resultado = await respuesta.json();
        console.log(resultado);
        
        if(resultado.resultado){
            Swal.fire({
                icon: 'success',
                title: 'Reservado',
                text: 'La cita se a creado correctamente!',
            }).then( () => {
                window.location.reload();
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo generar la cita, intente nuevamente'
        })
    }

    
    
    
}