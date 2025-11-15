<?php
declare(strict_types=1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Courses — RaYnk Labs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .courses-header {
            background: linear-gradient(135deg, #3BA7FF, #A26BFF);
            padding: 60px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .courses-header h1 {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
        }
        .courses-header p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
        }
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 50px 0;
        }
        .course-card-full {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(59, 167, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .course-card-full::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
        }
        .course-card-full:hover {
            transform: translateY(-10px);
            border-color: var(--neon-blue);
            background: rgba(59, 167, 255, 0.1);
            box-shadow: 0 20px 60px rgba(59, 167, 255, 0.3);
        }
        .course-icon {
            font-size: 48px;
            color: var(--neon-blue);
            margin-bottom: 15px;
        }
        .course-badge {
            display: inline-block;
            background: var(--neon-blue);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .course-card-full h3 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin: 10px 0;
        }
        .course-card-full p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .course-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-top: 1px solid rgba(59, 167, 255, 0.2);
            margin-bottom: 20px;
        }
        .detail-item {
            text-align: center;
            flex: 1;
        }
        .detail-item i {
            color: var(--neon-blue);
            margin-bottom: 5px;
        }
        .detail-item small {
            color: rgba(255, 255, 255, 0.7);
            display: block;
            font-size: 12px;
        }
        .enroll-btn {
            display: block;
            text-align: center;
            padding: 12px 30px;
            background: var(--neon-blue);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .course-card-full:hover .enroll-btn {
            background: var(--electric-purple);
            transform: translateX(5px);
        }
        @media (max-width: 1200px) {
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .courses-header {
                padding: 40px 20px;
            }
            .courses-header h1 {
                font-size: 32px;
            }
            .courses-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .course-card-full {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Courses Header -->
    <div class="courses-header" style="margin-top: 70px;">
        <div class="container">
            <h1>Our Courses</h1>
            <p>Master in-demand skills from industry experts</p>
        </div>
    </div>

    <!-- Courses Grid -->
    <section>
        <div class="container">
            <div class="courses-grid">
                <!-- Course 1 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-star me-1"></i>Popular</span>
                    <div class="course-icon"><i class="fas fa-robot"></i></div>
                    <h3>AI for Students</h3>
                    <p>Learn how to leverage AI tools for productivity, research, and career growth. Practical applications and hands-on projects included.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>8 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>Beginner</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>

                <!-- Course 2 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-check me-1"></i>Free</span>
                    <div class="course-icon"><i class="fas fa-pencil-ruler"></i></div>
                    <h3>UI/UX Basics</h3>
                    <p>Master the fundamentals of user interface and experience design. Learn design principles, tools, and best practices with real projects.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>10 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>Beginner</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>

                <!-- Course 3 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-fire me-1"></i>Trending</span>
                    <div class="course-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h3>Flutter Basics</h3>
                    <p>Build beautiful, natively compiled applications for mobile, web, and desktop from a single codebase using Flutter and Dart.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>12 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>Beginner</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>

                <!-- Course 4 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-compass me-1"></i>Guidance</span>
                    <div class="course-icon"><i class="fas fa-compass"></i></div>
                    <h3>Career Roadmap</h3>
                    <p>Personalized career guidance and strategic planning. Understand industry demands, skill gaps, and create your unique path to success.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>6 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>All Levels</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>

                <!-- Course 5 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-star me-1"></i>Popular</span>
                    <div class="course-icon"><i class="fas fa-code"></i></div>
                    <h3>Web Development Bootcamp</h3>
                    <p>Comprehensive full-stack web development. From frontend to backend, learn HTML, CSS, JavaScript, Node.js, and database management.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>16 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>Beginner</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>

                <!-- Course 6 -->
                <div class="course-card-full">
                    <span class="course-badge"><i class="fas fa-check me-1"></i>Free</span>
                    <div class="course-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Data Science Fundamentals</h3>
                    <p>Introduction to data science with Python. Learn data analysis, visualization, machine learning basics, and real-world applications.</p>
                    <div class="course-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <small>14 Weeks</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <small>Intermediate</small>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-certificate"></i>
                            <small>Certified</small>
                        </div>
                    </div>
                    <button type="button" class="enroll-btn" data-bs-toggle="modal" data-bs-target="#courseModal">Enroll Now</button>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
