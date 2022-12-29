document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    buscarPorFecha();
}

/* ================================================ BUCADOR POR FECHA ================================================ */
function buscarPorFecha(){
    //selecciono el input type date
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;
        
        //redirecciona a la url con la fecha lista para ser capturada
        window.location = `?fecha=${fechaSeleccionada}`;
    });  
}