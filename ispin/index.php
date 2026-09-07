<?php
session_start();

// If already logged in as super admin, redirect to adminForm.php
if (isset($_SESSION['ispin_admin_logged_in']) && $_SESSION['ispin_admin_logged_in'] === true) {
    header("Location: ../pages/adminForm.php");
    exit();
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === 'ISPIN' && $password === 'LVMPAYALUGA') {
        $_SESSION['ispin_admin_logged_in'] = true;
        $_SESSION['admin_user'] = 'ISPIN';
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_auth_time'] = time();

        header("Location: ../pages/adminForm.php");
        exit();
    } else {
        $error_msg = "Invalid Admin Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>iSPIN Admin Login | NSCET WAVES</title>
    <link rel="icon" type="image/png" href="../public/images/logos/waves-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff5722;
            --primary-glow: rgba(255, 87, 34, 0.4);
            --waves-pink: #e22361;
            --waves-glow: rgba(226, 35, 97, 0.4);
            --bg-dark: #0a0d18;
            --card-bg: rgba(18, 24, 43, 0.85);
            --border-glass: rgba(255, 255, 255, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: 
                radial-gradient(circle at 20% 20%, rgba(226, 35, 97, 0.18) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(255, 87, 34, 0.18) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(103, 58, 183, 0.15) 0%, transparent 60%),
                #070a14;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle animated background grid */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        .login-card-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 42px 36px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7),
                        0 0 35px -5px rgba(226, 35, 97, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8),
                        0 0 45px -5px rgba(255, 87, 34, 0.3);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .brand-logo-img {
            height: 52px;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.5));
            transition: transform 0.3s;
        }

        .brand-logo-img:hover {
            transform: scale(1.06);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 87, 34, 0.12);
            border: 1px solid rgba(255, 87, 34, 0.35);
            color: #ff8a65;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .login-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .login-subtitle {
            color: #94a3b8;
            font-size: 0.88rem;
        }

        .form-group label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .custom-input-group {
            position: relative;
        }

        .custom-input-group .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1rem;
            transition: color 0.3s;
            z-index: 4;
            pointer-events: none;
        }

        .form-control-custom {
            width: 100%;
            height: 52px;
            padding: 12px 46px 12px 46px;
            background: rgba(11, 15, 29, 0.85);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            background: rgba(14, 20, 38, 0.95);
            border-color: #ff5722;
            box-shadow: 0 0 0 4px rgba(255, 87, 34, 0.18);
            color: #fff;
            outline: none;
        }

        .custom-input-group:focus-within .input-icon {
            color: #ff5722;
        }

        .toggle-password-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 6px;
            z-index: 4;
            transition: color 0.2s;
        }

        .toggle-password-btn:hover {
            color: #f1f5f9;
        }

        .btn-login-submit {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, #ff5722 0%, #e22361 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(255, 87, 34, 0.4);
            transition: all 0.3s ease;
            margin-top: 26px;
        }

        .btn-login-submit:hover {
            background: linear-gradient(135deg, #ff7043 0%, #f02d6e 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(255, 87, 34, 0.5);
        }

        .btn-login-submit:active {
            transform: translateY(0);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.88rem;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 0.85rem;
            text-decoration: none;
            margin-top: 22px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #fff;
            text-decoration: none;
        }

        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 0.76rem;
            color: #64748b;
        }

        .footer-note span {
            color: #e22361;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="login-card-container">
        <div class="login-card">
            <!-- Brand header -->
            <div class="brand-header">
                <div class="brand-logos">
                    <img src="../public/images/logos/ispin-logo.png" alt="iSPIN Logo" class="brand-logo-img">
                    <div style="width: 1px; height: 36px; background: rgba(255,255,255,0.15);"></div>
                    <img src="../public/images/logos/waves-logo.png" alt="Waves Logo" class="brand-logo-img">
                </div>
                <div class="brand-badge">
                    <i class="fas fa-shield-alt"></i> Control Center
                </div>
                <h1 class="login-title">iSPIN Admin Login</h1>
                <p class="login-subtitle">NSCET WAVES'26 Portal Administration</p>
            </div>

            <!-- Error Notification -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 1.1rem;"></i>
                    <span><?php echo htmlspecialchars($error_msg); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="POST" autocomplete="off">
                <div class="form-group mb-3">
                    <label for="username">
                        <i class="fas fa-user-shield text-warning"></i> Admin Username
                    </label>
                    <div class="custom-input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            class="form-control-custom" 
                            placeholder="Enter Username" 
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password">
                        <i class="fas fa-key text-warning"></i> Admin Password
                    </label>
                    <div class="custom-input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control-custom" 
                            placeholder="Enter Password" 
                            required
                        >
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility()" title="Toggle visibility">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login-submit">
                    <i class="fas fa-sign-in-alt"></i> Authenticate & Enter
                </button>
            </form>

            <a href="../index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Return to Waves Home
            </a>
        </div>

        <div class="footer-note">
            Crafted by <span>iSPIN</span> &bull; Department of CSE, AI&DS and IT
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var input = document.getElementById('password');
            var icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
