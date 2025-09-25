// Función para mostrar la animación de carga
function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    
    const spinner = document.createElement('div');
    spinner.className = 'loading-spinner';
    
    overlay.appendChild(spinner);
    document.body.appendChild(overlay);
    
    // Prevenir scroll mientras carga
    document.body.style.overflow = 'hidden';
}

// Función para ocultar la animación de carga
function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.remove();
            document.body.style.overflow = '';
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Mostrar loading inicial
    showLoading();

    // Asegurarse de que jQuery está cargado
    if (typeof jQuery === 'undefined') {
        console.error('jQuery no está cargado');
        hideLoading();
        return;
    }

    try {
        // Inicializar DataTables
        const librosTable = new DataTable('#librosTable', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        pageLength: 10,
        responsive: true,
        dom: '<"table-header"Bf>rt<"table-footer"lip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Configurar eliminación con SweetAlert2
    document.querySelectorAll('.btn-error').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--color-error)',
                cancelButtonColor: 'var(--color-secondary)',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    // Animación de entrada para las stats cards
    anime({
        targets: '.stat-card',
        translateY: [50, 0],
        opacity: [0, 1],
        delay: anime.stagger(100),
        duration: 800,
        easing: 'easeOutElastic(1, .5)'
    });

    // Gráfico de estadísticas con Chart.js
    const statsChart = new Chart(
        document.getElementById('statsChart'),
        {
            type: 'bar',
            data: {
                labels: ['Libros', 'Usuarios', 'Préstamos', 'Disponibilidad'],
                datasets: [{
                    label: 'Estadísticas',
                    data: [1250, 856, 124, 98],
                    backgroundColor: [
                        'rgba(var(--color-primary-rgb), 0.7)',
                        'rgba(var(--color-secondary-rgb), 0.7)',
                        'rgba(var(--color-accent-rgb), 0.7)',
                        'rgba(var(--color-success-rgb), 0.7)'
                    ],
                    borderColor: [
                        'rgb(var(--color-primary-rgb))',
                        'rgb(var(--color-secondary-rgb))',
                        'rgb(var(--color-accent-rgb))',
                        'rgb(var(--color-success-rgb))'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Resumen General'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    );

    // Alpine.js para el menú desplegable
    if (typeof Alpine !== 'undefined') {
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            }));
        });
    }

    // Garantizar que se oculte la pantalla de carga
    // Asegurar que se oculte la pantalla de carga después de un tiempo
    setTimeout(() => {
        try {
            hideLoading();
            // Agregar clases de animación a elementos después de cargar
            document.querySelectorAll('.dashboard-card').forEach(card => {
                card.style.opacity = '1';
            });
        } catch (error) {
            console.error('Error durante la carga:', error);
            hideLoading(); // Asegurar que se oculte incluso si hay error
        }
    }, 1500);
});

// Mostrar loading al hacer clic en enlaces del dashboard
document.querySelectorAll('.dashboard-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (!e.ctrlKey && !e.shiftKey && !e.metaKey) {
            e.preventDefault();
            showLoading();
            setTimeout(() => {
                window.location = this.href;
            }, 300);
        }
    });
});