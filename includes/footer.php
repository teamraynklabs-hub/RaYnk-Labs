<?php
/**
 * Modern Footer with responsive design
 */
?>

<!-- Footer -->
<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row g-5 py-5 flex-column-reverse flex-md-row">
                <!-- Brand Section -->
                <div class="col-12 col-md-4 text-center text-md-start">
                    <div class="footer-brand">
                        <h3 class="fw-bold mb-3">
                            <span style="background: linear-gradient(135deg, #3BA7FF, #A26BFF); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">RaYnk Labs</span>
                        </h3>
                        <p class="text-white-50">Empowering students through innovation, education, and real-world opportunities.</p>
                        <div class="social-icons mt-4 justify-content-center justify-content-md-start">
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="https://github.com/teamraynklabs-hub" class="social-icon"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-12 col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-4 text-white">Quick Links</h5>
                    <ul class="footer-links justify-content-center justify-content-md-start">
                       <li><a href="services.php">Delivered Services</a></li>
                        <li><a href="courses.php">Completed Courses</a></li>
                        <li><a href="projects.php">Completed Projects</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div class="col-12 col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-4 text-white">Get In Touch</h5>
                    <div class="footer-contact">
                        <p class="mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:team.raynklabs@gmail.com" class="text-white-50 text-decoration-none">team.raynklabs@gmail.com</a>
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <a href="tel:+919876543210" class="text-white-50 text-decoration-none">+91 98765 43210</a>
                        </p>
                        <p class="text-white-50">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            Building Innovation, India
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <p class="text-white-50 mb-3 mb-md-0">&copy; 2025 RaYnk Labs. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background: linear-gradient(180deg, rgba(13, 13, 13, 0.8) 0%, #000000 100%);
    border-top: 1px solid rgba(59, 167, 255, 0.2);
    color: #0006acff;
    padding-top: 10px;
    margin-top: 10px;
}

.footer-main {
    backdrop-filter: blur(10px);
}

.footer-brand h3 {
    font-size: 24px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-links a:hover {
    color: #3BA7FF;
    padding-left: 8px;
}

.social-icons {
    display: flex;
    gap: 12px;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(59, 167, 255, 0.15);
    border: 1px solid rgba(59, 167, 255, 0.3);
    border-radius: 50%;
    color: #3BA7FF;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 16px;
}

.social-icon:hover {
    background: #3BA7FF;
    color: #ffffff;
    transform: translateY(-3px);
    border-color: #3BA7FF;
}

.footer-contact p {
    margin-bottom: 0;
}

.footer-contact a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-contact a:hover {
    color: #3BA7FF;
}

.footer-bottom {
    padding-bottom: 10px;
}

@media (max-width: 768px) {
    .footer {
        margin-top: 10px;
        padding-top: 30px;
    }

    .footer-main .row {
        gap: 0.2rem !important;
    }

    .footer-links a:hover {
        padding-left: 0;
        color: #3BA7FF;
    }

    .footer-bottom .row {
        flex-direction: column;
    }

    .footer-bottom .text-md-end {
        text-align: start !important;
        margin-top: 15px;
    }
}
</style>