document.addEventListener("DOMContentLoaded", function () {
    const registro = document.querySelector("form[action*='registrarUsuario.php']");
    const login = document.querySelector("form[action*='validarLogin.php']");
  
    if (registro) {
      registro.addEventListener("submit", function (e) {
        const inputs = registro.querySelectorAll("input");
        for (let input of inputs) {
          if (input.value.trim() === "") {
            alert("Todos los campos son obligatorios.");
            e.preventDefault();
            return;
          }
        }
  
        const email = registro.querySelector("input[type='email']").value;
        const pass = registro.querySelector("input[type='password']").value;
        if (pass.length < 6) {
          alert("La contraseña debe tener al menos 6 caracteres.");
          e.preventDefault();
        }
        if (!email.includes("@")) {
          alert("Correo inválido.");
          e.preventDefault();
        }
      });
    }
  
    if (login) {
      login.addEventListener("submit", function (e) {
        const dni = login.querySelector("input[name='dni']").value;
        const pass = login.querySelector("input[name='password']").value;
  
        if (dni.trim() === "" || pass.trim() === "") {
          alert("Completá todos los campos.");
          e.preventDefault();
        }
      });
    }
  });
  
// Función para validar el formulario de solicitud de turno
function validarFormulario() {
    // Obtener referencias a los campos
    const nombre = document.getElementById('nombre');
    const dni = document.getElementById('dni');
    const email = document.getElementById('email');
    
    // Variable para controlar la validación
    let esValido = true;
    
    // Validar nombre
    if (nombre && nombre.value.trim() === '') {
        mostrarError(nombre, 'El nombre es obligatorio');
        esValido = false;
    } else if (nombre) {
        limpiarError(nombre);
    }
    
    // Validar DNI
    if (dni && dni.value.trim() === '') {
        mostrarError(dni, 'El DNI es obligatorio');
        esValido = false;
    } else if (dni) {
        limpiarError(dni);
    }
    
    // Validar email
    if (email && email.value.trim() === '') {
        mostrarError(email, 'El email es obligatorio');
        esValido = false;
    } else if (email && !validarEmail(email.value)) {
        mostrarError(email, 'Por favor ingrese un email válido');
        esValido = false;
    } else if (email) {
        limpiarError(email);
    }
    
    return esValido;
}

// Función para validar formato de email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Función para mostrar error
function mostrarError(input, mensaje) {
    const formGroup = input.parentElement;
    const errorElement = formGroup.querySelector('.error-message') || document.createElement('div');
    
    errorElement.className = 'error-message';
    errorElement.style.color = 'red';
    errorElement.style.fontSize = '0.8rem';
    errorElement.style.marginTop = '0.3rem';
    errorElement.textContent = mensaje;
    
    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(errorElement);
    }
    
    input.style.borderColor = 'red';
}

// Función para limpiar error
function limpiarError(input) {
    const formGroup = input.parentElement;
    const errorElement = formGroup.querySelector('.error-message');
    
    if (errorElement) {
        formGroup.removeChild(errorElement);
    }
    
    input.style.borderColor = '#ddd';
}

// Verificar disponibilidad de horarios mediante AJAX
function verificarDisponibilidad() {
    const tipoTurno = document.getElementById('tipo_turno').value;
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    
    if (tipoTurno && fecha && hora) {
        // Crear objeto para enviar datos
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'verificar_disponibilidad.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status === 200) {
                const respuesta = JSON.parse(this.responseText);
                const resultadoDiv = document.getElementById('resultado-disponibilidad');
                
                if (respuesta.disponible) {
                    resultadoDiv.innerHTML = '<div class="alert alert-success">¡Horario disponible!</div>';
                    document.getElementById('btn-confirmar').disabled = false;
                } else {
                    resultadoDiv.innerHTML = '<div class="alert alert-danger">Horario no disponible. Por favor seleccione otro.</div>';
                    document.getElementById('btn-confirmar').disabled = true;
                }
            }
        };
        
        xhr.send(`tipo_turno=${tipoTurno}&fecha=${fecha}&hora=${hora}`);
    }
}

// Agregar eventos cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Formulario de solicitud de turno
    const formSolicitud = document.getElementById('form-solicitud');
    if (formSolicitud) {
        formSolicitud.addEventListener('submit', function(e) {
            if (!validarFormulario()) {
                e.preventDefault();
            }
        });
    }
    
    // Selector de fecha y hora para verificar disponibilidad
    const tipoTurno = document.getElementById('tipo_turno');
    const fecha = document.getElementById('fecha');
    const hora = document.getElementById('hora');
    
    if (tipoTurno && fecha && hora) {
        tipoTurno.addEventListener('change', verificarDisponibilidad);
        fecha.addEventListener('change', verificarDisponibilidad);
        hora.addEventListener('change', verificarDisponibilidad);
    }
    
    // Establecer fecha mínima para el campo de fecha (día actual)
    if (fecha) {
        const hoy = new Date();
        const año = hoy.getFullYear();
        let mes = hoy.getMonth() + 1;
        let dia = hoy.getDate();
        
        mes = mes < 10 ? '0' + mes : mes;
        dia = dia < 10 ? '0' + dia : dia;
        
        fecha.min = `${año}-${mes}-${dia}`;
    }
});