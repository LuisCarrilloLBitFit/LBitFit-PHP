// Validación de formularios en el cliente
document.addEventListener('DOMContentLoaded', function() {
    // Validar fecha de nacimiento en el registro
    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    if (fechaNacimiento) {
        fechaNacimiento.addEventListener('change', function() {
            const fecha = new Date(this.value);
            const hoy = new Date();
            const edad = hoy.getFullYear() - fecha.getFullYear();
            
            if (edad < 18) {
                alert('Debes ser mayor de 18 años para registrarte');
                this.value = '';
            }
        });
    }
    
    // Validar fechas de citas
    const fechaCita = document.getElementById('fecha_cita');
    if (fechaCita) {
        fechaCita.addEventListener('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const hoy = new Date();
            
            if (fechaSeleccionada < hoy) {
                alert('No puedes seleccionar una fecha en el pasado');
                this.value = '';
            }
        });
    }
    
    // Mostrar/ocultar contraseña
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});