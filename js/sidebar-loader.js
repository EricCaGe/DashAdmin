// Cargar sidebar dinámicamente
function loadSidebar(currentPage = 'dashboard') {
    fetch('../components/sidebar.html')
        .then(response => response.text())
        .then(data => {
            // Insertar el sidebar en el elemento con id "sidebar-container"
            document.getElementById('sidebar-container').innerHTML = data;
            
            // Marcar la página activa
            setActivePage(currentPage);
            
            // Inicializar funcionalidades del sidebar después de cargar
            initializeSidebar();
        })
        .catch(error => console.error('Error loading sidebar:', error));
}

// Marcar la página activa en el sidebar
function setActivePage(page) {
    // Remover active de todos los items
    const navItems = document.querySelectorAll('.sidebar .nav-item');
    navItems.forEach(item => item.classList.remove('active'));
    
    // Agregar active al item correspondiente
    switch(page) {
        case 'dashboard':
            document.querySelector('.sidebar .nav-item a[href*="../index.php"]').parentElement.classList.add('active');
            break;
        case 'stock':
            document.querySelector('.sidebar .nav-item a[href*="../pages/stock.php"]').parentElement.classList.add('active');
            break;
        case 'ventas':
            document.querySelector('.sidebar .nav-item a[href*="ventas.html"]').parentElement.classList.add('active');
            break;
        case 'empleados':
            document.querySelector('.sidebar .nav-item a[href*="empleados.html"]').parentElement.classList.add('active');
            break;
        case 'clientes':
            document.querySelector('.sidebar .nav-item a[href*="clientes.html"]').parentElement.classList.add('active');
            break;
    }
}

// Inicializar funcionalidades del sidebar
function initializeSidebar() {
    // Toggle del sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleTop = document.getElementById('sidebarToggleTop');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    }
    
    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    }
}

// Cargar sidebar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Determinar la página actual basada en la URL
    const currentPath = window.location.pathname;
    let currentPage = 'dashboard';
    
    if (currentPath.includes('stock.html')) currentPage = 'stock';
    else if (currentPath.includes('ventas.html')) currentPage = 'ventas';
    else if (currentPath.includes('empleados.html')) currentPage = 'empleados';
    else if (currentPath.includes('clientes.html')) currentPage = 'clientes';
    
    loadSidebar(currentPage);
});