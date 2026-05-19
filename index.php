<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-Bootstrap</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('assets/img/head-bg.png');; background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;"">
        <div class=" container">
        <a class="navbar-brand" href="#">
            <img src="assets/img/logo.png" alt="My Logo" class="img-logo">
            <span class="terminal-prompt">MICHAEL.ID</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-vh-100 d-flex align-items-center"
        style="background: linear-gradient(rgba(45, 55, 73, 1), rgba(0, 0, 0, 0.9)), url('assets/img/bg-2.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-4 terminal-prompt typewriter">
                        Welcome to My Portfolio
                    </h1>
                    <p class="lead mb-4 text-light">
                        <span class="terminal-prompt">#</span> Hi, I'm Michael Nugroho
                    </p>
                    <p class="mb-4 text-secondary">
                        Crafting innovative technology solutions with modern development practices. Specializing in
                        full-stack development,
                        system architecture, and building scalable applications.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <button class="btn btn-outline-success" onclick="scrollToSection('services')">
                            <i class="fas fa-code me-2"></i>View Services
                        </button>
                        <button class="btn btn-outline-success" onclick="scrollToSection('contact')">
                            <i class="fas fa-envelope me-2"></i>Contact Me
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <button class="btn btn-terminal mb-4">Services</button>
                </div>
            </div>

            <div class="row g-4" id="services-grid">
                <?php
                include 'connect.php';

                $result = $conn->query("SELECT * FROM services ORDER BY id ASC");
                $services = [];

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $services[] = $row;
                    }
                }

                foreach ($services as $index => $service) {
                    $hidden = ($index >= 3) ? 'service-item d-none' : 'service-item';
                    echo '<div class="col-md-4 ' . $hidden . '">';
                    echo '<div class="card card-linux h-100">';
                    echo '<div class="card-body text-center p-4">';
                    echo '<h5 class="card-title terminal-prompt mb-3">' . htmlspecialchars($service['name']) . '</h5>';
                    echo '<p class="card-text text-light">' . htmlspecialchars($service['description']) . '</p>';
                    echo '</div></div></div>';
                }
                $conn->close();
                ?>
            </div>

            <?php if (count($services) > 3): ?>
                <div class="text-center mt-5">
                    <button class="btn btn-outline-success" id="toggleServices" onclick="toggleServices()">
                        <i class="fas fa-plus me-2"></i>Show All Services
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
        function toggleServices() {
            const items = document.querySelectorAll('.service-item');
            const btn = document.getElementById('toggleServices');

            items.forEach((item, index) => {
                if (index >= 3) item.classList.toggle('d-none');
            });

            if (btn.innerHTML.includes('Show All')) {
                btn.innerHTML = '<i class="fas fa-minus me-2"></i>Show Less';
            } else {
                btn.innerHTML = '<i class="fas fa-plus me-2"></i>Show All Services';
                document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>

    <!-- About Section -->
    <section id="about" class="py-5" style="background-color: #2d3748;">
        <?php
        include 'connect.php';

        // Set defaults
        $project_count = 0;
        $satisfaction_pct = 0;
        $satisfied_count = 0;
        $total_fb = 0;
        $since_year = 2023;
        $years_exp = date('Y') - $since_year;

        // Count projects
        $proj_res = $conn->query("SELECT COUNT(*) as total FROM projects");
        if ($proj_res) {
            $row = $proj_res->fetch_assoc();
            $project_count = $row['total'] ?? 0;
        }

        // Calculate satisfaction
        $fb_res = $conn->query("SELECT COUNT(*) as total, SUM(CASE WHEN is_satisfied = 1 THEN 1 ELSE 0 END) as satisfied FROM user_feedback");
        if ($fb_res) {
            $fb = $fb_res->fetch_assoc();
            $total_fb = $fb['total'] ?? 0;
            $satisfied_count = $fb['satisfied'] ?? 0;
            if ($total_fb > 0) {
                $satisfaction_pct = round(($satisfied_count / $total_fb) * 100, 1);
            }
        }
        $conn->close();
        ?>

        <div class="container">
            <div class="row justify-content-center mb-5">
                <!-- Rest of your code continues here... -->
                <div class="container">
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-8 text-center">
                            <button class="btn btn-terminal mb-4">About</button>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left: About Text + Pie Chart -->
                        <div class="col-lg-6 mb-4">
                            <p class="text-light mb-4">
                                <span class="terminal-prompt">console.log('developer-info')</span>
                            </p>
                            <p class="text-light">
                                A passionate software developer with
                                experience in full-stack development and system design.
                                Committed to writing clean, efficient code and staying current with emerging
                                technologies.
                            </p>
                            <p class="text-light">
                                <span class="terminal-prompt text-success">></span>
                                <span class="text-secondary">Location:</span>
                                <span class="text-info">Surakarta, Indonesia</span>
                            </p>

                            <!-- Pie Chart Below Text -->
                            <div class="mt-5 p-4 card card-linux">
                                <h6 class="text-warning mb-3 text-center">Client Satisfaction Rate</h6>
                                <div style="max-width: 250px; margin: 0 auto;">
                                    <canvas id="satisfactionChart"></canvas>
                                </div>
                                <p class="text-secondary small text-center mt-3 mb-0">
                                    <?php echo $satisfaction_pct; ?>% Satisfaction
                                    (<?php echo $satisfied_count; ?>/<?php echo $total_fb; ?>)
                                </p>
                            </div>
                        </div>

                        <!-- Right: Achievement Metrics (Only 3) -->
                        <div class="col-lg-6">
                            <h5 class="section-title text-warning mb-4">Achievement Metrics</h5>
                            <div class="card card-linux p-4">
                                <div class="row">
                                    <!-- Projects -->
                                    <div class="col-12 mb-4 text-center">
                                        <h3 class="terminal-prompt text-success mb-2"><?php echo $project_count; ?>+
                                        </h3>
                                        <p class="text-secondary small mb-0">Projects Completed</p>
                                    </div>

                                    <!-- Support -->
                                    <div class="col-6 mb-3 text-center">
                                        <h3 class="terminal-prompt text-success mb-2">24/7</h3>
                                        <p class="text-secondary small mb-0">Support Available</p>
                                    </div>

                                    <!-- Experience -->
                                    <div class="col-6 mb-3 text-center">
                                        <h3 class="terminal-prompt text-success mb-2"><?php echo $years_exp; ?>+</h3>
                                        <p class="text-secondary small mb-0">Years Experience</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>

    <script>
        // Pie Chart
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('satisfactionChart');
            if (!ctx) return;

            const satisfiedCount = <?php echo $satisfied_count ?? 0; ?>;
            const notSatisfiedCount = <?php echo ($total_fb ?? 0) - ($satisfied_count ?? 0); ?>;
            const totalFeedback = <?php echo $total_fb ?? 0; ?>;

            new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Satisfied', 'Not Satisfied'],
                    datasets: [{
                        data: [satisfiedCount, notSatisfiedCount],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#adb5bd',
                                font: { size: 11 },
                                boxWidth: 12,
                                padding: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const pct = totalFeedback > 0 ? ((value / totalFeedback) * 100).toFixed(1) : 0;
                                    return label + ': ' + value + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        });
    </script>
    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <button class="btn btn-terminal mb-4">Contact</button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form id="contactForm" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label text-light">
                                    <span class="terminal-prompt">></span> Your Name
                                </label>
                                <input type="text" class="form-control bg-secondary text-light border-success" id="name"
                                    name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-light">
                                    <span class="terminal-prompt">></span> Your Email
                                </label>
                                <input type="email" class="form-control bg-secondary text-light border-success"
                                    id="email" name="email" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label text-light">
                                    <span class="terminal-prompt">></span> Your Message
                                </label>
                                <textarea class="form-control bg-secondary text-light border-success" id="message"
                                    name="message" rows="5" required></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <div id="formMessage" class="alert d-none mt-3" role="alert"></div>
                                <button type="submit" class="btn btn-terminal" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (!this.checkValidity()) {
                this.classList.add('was-validated');
                return;
            }

            const btn = document.getElementById('submitBtn');
            const msgBox = document.getElementById('formMessage');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            msgBox.classList.add('d-none');

            fetch('contact_process.php', {
                method: 'POST',
                body: new FormData(this)
            })
                .then(res => res.json())
                .then(data => {
                    msgBox.classList.remove('d-none', 'alert-success', 'alert-danger');
                    msgBox.classList.add(data.success ? 'alert-success' : 'alert-danger');
                    msgBox.textContent = data.message;

                    if (data.success) {
                        this.reset();
                        this.classList.remove('was-validated');
                    }

                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Message';
                })
                .catch(() => {
                    msgBox.classList.remove('d-none');
                    msgBox.classList.add('alert-danger');
                    msgBox.textContent = 'Network error. Try again.';
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Message';
                });
        });
    </script>

    <!-- Footer -->
    <footer class="py-4 text-center" style="background-color: #1a202c;">
        <div class="container">
            <p class="text-muted mb-2">
                <span class="terminal-prompt">developer@portfolio:~$</span> status
            </p>
            <p class="text-light mb-3">© 2025 Michael Nugroho. Built with ❤️ and Modern Tech</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="text-success"><i class="fab fa-github fa-2x"></i></a>
                <a href="#" class="text-primary"><i class="fab fa-linkedin fa-2x"></i></a>
                <a href="#" class="text-info"><i class="fab fa-twitter fa-2x"></i></a>
                <a href="#" class="text-danger"><i class="fas fa-envelope fa-2x"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                const forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            event.preventDefault();
                            alert('Message sent successfully!\n\nTerima kasih! Pesan Anda telah dikirim.');
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Active navigation highlighting
        window.addEventListener('scroll', function () {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>