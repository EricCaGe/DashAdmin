// Mejorar la experiencia del scroll en la tabla
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
            }
        }
        
        // Verificar overflow después de cargar
        setTimeout(checkOverflow, 100);
        window.addEventListener('resize', checkOverflow);
    }
});