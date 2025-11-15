<?php
/**
 * Flash alert component.
 *
 * Include this near the top of index.php (after <body> or nav)
 * to show success/error messages stored in the session.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['flash'])):
    $status = $_SESSION['flash']['status'];
    $message = $_SESSION['flash']['message'];
    $isSuccess = $status === 'success';
    unset($_SESSION['flash']);
?>
    <style>
        .alert-wrapper {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2000;
            animation: slideDown 0.4s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
        
        .alert {
            padding: 15px 25px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            min-width: 300px;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.5);
            color: #4cb050;
        }
        
        .alert-danger {
            background: rgba(244, 67, 54, 0.2);
            border: 1px solid rgba(244, 67, 54, 0.5);
            color: #f44336;
        }
    </style>
    
    <div class="alert-wrapper">
        <div class="alert <?= $isSuccess ? 'alert-success' : 'alert-danger'; ?>">
            <i class="fas <?= $isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <span><?= htmlspecialchars($message); ?></span>
        </div>
    </div>
    
    <script>
        setTimeout(() => {
            const wrapper = document.querySelector('.alert-wrapper');
            if (wrapper) {
                wrapper.style.animation = 'slideUp 0.4s ease forwards';
            }
        }, 3000);
    </script>
    
    <style>
        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            to {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
        }
    </style>
<?php endif; ?>
