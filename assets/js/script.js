// jQuery Document Ready
$(document).ready(function() {
    
    // Function untuk scroll ke section dengan animasi smooth
    function scrollToSection(sectionId) {
        $('html, body').animate({
            scrollTop: $('#' + sectionId).offset().top
        }, 800);
    }
    
    // Global function untuk button onclick
    window.scrollToSection = scrollToSection;
    
    // Event handler untuk navigation links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var targetId = $(this).attr('href').substring(1);
        scrollToSection(targetId);
    });
    
    // Function untuk highlight active menu saat scroll
    $(window).scroll(function() {
        var scrollPos = $(window).scrollTop() + 100;
        
        $('section[id]').each(function() {
            var sectionTop = $(this).offset().top;
            var sectionBottom = sectionTop + $(this).outerHeight();
            var sectionId = $(this).attr('id');
            
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                $('.navbar-nav .nav-link').removeClass('active');
                $('.navbar-nav .nav-link[href="#' + sectionId + '"]').addClass('active');
            }
        });
    });
    
    // Form validation dengan jQuery
    $('.needs-validation').submit(function(e) {
        e.preventDefault();
        
        var form = this;
        
        if (form.checkValidity() === false) {
            e.stopPropagation();
        } else {
            alert('Message sent successfully!\n\nTerima kasih! Pesan Anda telah dikirim.');
        }
        
        $(form).addClass('was-validated');
    });
    
    // Chart.js - Technology Stack Doughnut Chart
    var techCanvas = document.getElementById('techChart');
    if (techCanvas) {
        var techCtx = techCanvas.getContext('2d');
        var techChart = new Chart(techCtx, {
            type: 'doughnut',
            data: {
                labels: ['JavaScript', 'Python', 'PHP', 'Java', 'React', 'Node.js'],
                datasets: [{
                    label: 'Technology Usage (%)',
                    data: [25, 20, 15, 10, 15, 15],
                    backgroundColor: [
                        '#00ff00',
                        '#e95420',
                        '#0066cc',
                        '#ff6b6b',
                        '#4ecdc4',
                        '#45b7d1'
                    ],
                    borderWidth: 2,
                    borderColor: '#2d3748'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    } else {
        console.log('techChart canvas not found');
    }
    
    // Chart.js - Monthly Projects Line Chart
    var projectCanvas = document.getElementById('projectChart');
    if (projectCanvas) {
        var projectCtx = projectCanvas.getContext('2d');
        var projectChart = new Chart(projectCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    label: 'Projects Completed',
                    data: [4, 6, 8, 5, 7, 9, 6, 8],
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    borderColor: '#00ff00',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#4a5568'
                        },
                        ticks: {
                            color: '#ffffff'
                        }
                    },
                    x: {
                        grid: {
                            color: '#4a5568'
                        },
                        ticks: {
                            color: '#ffffff'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    } else {
        console.log('projectChart canvas not found');
    }
    
});