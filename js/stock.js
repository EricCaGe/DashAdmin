// FUNCIONES PARA GESTIÓN DE PRODUCTOS
function editarProducto(id, nombre, cantidad, precio) {
    document.getElementById('idProducto').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('cantidad').value = cantidad;
    document.getElementById('precio').value = precio;
    
    document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Actualizar Producto';
    
    if (window.innerWidth < 992) {
        document.querySelector('.form-container').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function limpiarFormulario() {
    document.getElementById('formProducto').reset();
    document.getElementById('idProducto').value = '';
    document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Guardar Producto';
    document.getElementById('nombre').focus();
}

// MEJORAR EXPERIENCIA DEL SCROLL EN LA TABLA
document.addEventListener('DOMContentLoaded', function() {
    const tableScroll = document.getElementById('tableScroll');
    
    if (tableScroll) {
        // Agregar clase cuando se hace scroll
        tableScroll.addEventListener('scroll', function() {
            this.classList.add('scrolling');
            clearTimeout(this.scrollTimeout);
            this.scrollTimeout = setTimeout(() => {
                this.classList.remove('scrolling');
            }, 500);
        });
        
        // Detectar si hay overflow horizontal
        function checkOverflow() {
            const hasHorizontalScroll = tableScroll.scrollWidth > tableScroll.clientWidth;
            if (hasHorizontalScroll) {
                tableScroll.style.setProperty('--scroll-indicator', 'block');
            } else {
                tableScroll.style.setProperty('--scroll-indicator', 'none');
            }
        }
        
        // Verificar overflow después de cargar
        setTimeout(checkOverflow, 100);
        window.addEventListener('resize', checkOverflow);
        
        // Inicializar
        checkOverflow();
    }

    // Auto-limpiar mensajes después de 5 segundos
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});