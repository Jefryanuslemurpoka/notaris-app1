<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Notaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0e1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Notary-themed Particle Canvas */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* Elegant Background Gradient */
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(184, 134, 11, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(139, 69, 19, 0.06) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }

        /* Floating Legal Symbols */
        .legal-symbols {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .legal-symbol {
            position: absolute;
            font-size: 60px;
            opacity: 0.03;
            animation: floatSymbol 20s infinite ease-in-out;
            filter: blur(1px);
        }

        .legal-symbol:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
        .legal-symbol:nth-child(2) { top: 70%; left: 15%; animation-delay: 4s; font-size: 80px; }
        .legal-symbol:nth-child(3) { top: 30%; right: 10%; animation-delay: 8s; font-size: 70px; }
        .legal-symbol:nth-child(4) { bottom: 20%; right: 20%; animation-delay: 12s; }
        .legal-symbol:nth-child(5) { top: 50%; left: 50%; animation-delay: 16s; font-size: 90px; }

        @keyframes floatSymbol {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.03; }
            50% { transform: translateY(-30px) rotate(5deg); opacity: 0.06; }
        }

        /* Main Container */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1300px;
        }

        .login-container {
            background: linear-gradient(145deg, rgba(15, 20, 35, 0.95), rgba(20, 25, 40, 0.9));
            backdrop-filter: blur(40px) saturate(180%);
            border: 1px solid rgba(184, 134, 11, 0.15);
            border-radius: 32px;
            box-shadow: 
                0 50px 120px rgba(0, 0, 0, 0.7),
                inset 0 1px 0 rgba(255, 255, 255, 0.05),
                0 0 100px rgba(184, 134, 11, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            position: relative;
            animation: containerFadeIn 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Left Section - Branding */
        .login-left {
            padding: 70px 60px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(184, 134, 11, 0.05) 0%, transparent 100%);
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -30%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.1) 0%, transparent 60%);
            animation: rotateGradient 40s linear infinite;
        }

        @keyframes rotateGradient {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Premium Logo Design */
        .logo-section {
            position: relative;
            z-index: 1;
            margin-bottom: 45px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo-container {
            position: relative;
            width: 85px;
            height: 85px;
        }

        .logo-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: #b8860b;
            border-right-color: #daa520;
            animation: spinRing 4s linear infinite;
        }

        .logo-ring:nth-child(2) {
            inset: -8px;
            border-width: 1px;
            animation-duration: 6s;
            animation-direction: reverse;
            opacity: 0.5;
        }

        @keyframes spinRing {
            to { transform: rotate(360deg); }
        }

        .logo-main {
            position: absolute;
            inset: 8px;
            background: linear-gradient(135deg, #b8860b, #daa520);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            box-shadow: 
                0 10px 40px rgba(184, 134, 11, 0.4),
                inset 0 2px 10px rgba(255, 215, 0, 0.3);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.05); }
        }

        .brand-text {
            flex: 1;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .brand-tagline {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Content Section */
        .brand-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 46px;
            font-weight: 900;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #ffffff 0%, #daa520 60%, #b8860b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            animation: titleSlideIn 1s ease 0.3s both;
        }

        @keyframes titleSlideIn {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-subtitle {
            font-size: 16px;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 40px;
            animation: titleSlideIn 1s ease 0.5s both;
        }

        /* Features with Premium Look */
        .features-list {
            display: grid;
            gap: 16px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(184, 134, 11, 0.1);
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: featureSlideIn 0.8s ease both;
        }

        .feature-item:nth-child(1) { animation-delay: 0.7s; }
        .feature-item:nth-child(2) { animation-delay: 0.8s; }
        .feature-item:nth-child(3) { animation-delay: 0.9s; }
        .feature-item:nth-child(4) { animation-delay: 1s; }

        @keyframes featureSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .feature-item:hover {
            background: rgba(184, 134, 11, 0.08);
            border-color: rgba(184, 134, 11, 0.3);
            transform: translateX(8px);
            box-shadow: 0 8px 30px rgba(184, 134, 11, 0.15);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(184, 134, 11, 0.2), rgba(218, 165, 32, 0.1));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(184, 134, 11, 0.2);
        }

        .feature-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 6px;
        }

        .feature-text p {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Right Section - Form */
        .login-right {
            padding: 70px 50px;
            background: rgba(255, 255, 255, 0.01);
            position: relative;
            border-left: 1px solid rgba(184, 134, 11, 0.1);
        }

        .login-right::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.05), transparent);
            animation: rotateGradient 30s linear infinite reverse;
        }

        .form-header {
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 10px;
            animation: formSlideIn 1s ease 0.4s both;
        }

        @keyframes formSlideIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-subtitle {
            font-size: 15px;
            color: #94a3b8;
            font-weight: 400;
            animation: formSlideIn 1s ease 0.5s both;
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(185, 28, 28, 0.05));
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-left: 4px solid #ef4444;
            color: #fca5a5;
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 30px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: errorShake 0.6s ease;
            backdrop-filter: blur(10px);
        }

        .error-message::before {
            content: '⚠';
            font-size: 20px;
        }

        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Form Styling */
        .login-form {
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 26px;
            animation: inputSlideIn 0.8s ease both;
        }

        .form-group:nth-child(1) { animation-delay: 0.6s; }
        .form-group:nth-child(2) { animation-delay: 0.7s; }

        @keyframes inputSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-label {
            display: block;
            color: #e2e8f0;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 1;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 18px 22px 18px 56px;
            background: rgba(10, 14, 26, 0.6);
            border: 2px solid rgba(184, 134, 11, 0.15);
            border-radius: 14px;
            font-size: 15px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .form-input::placeholder {
            color: #64748b;
            font-weight: 400;
        }

        .form-input:focus {
            outline: none;
            background: rgba(10, 14, 26, 0.8);
            border-color: #daa520;
            box-shadow: 
                0 0 0 4px rgba(184, 134, 11, 0.1),
                inset 0 2px 8px rgba(0, 0, 0, 0.3),
                0 10px 30px rgba(184, 134, 11, 0.2);
            transform: translateY(-2px);
        }

        .form-input:focus + .input-icon {
            transform: translateY(-50%) scale(1.15);
            filter: drop-shadow(0 0 10px rgba(218, 165, 32, 0.8));
        }

        /* Premium Button */
        .btn-login {
            width: 100%;
            padding: 19px;
            background: linear-gradient(135deg, #b8860b 0%, #daa520 50%, #b8860b 100%);
            background-size: 200% 100%;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 15px 40px rgba(184, 134, 11, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            margin-top: 16px;
            animation: buttonSlideIn 0.8s ease 0.9s both;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @keyframes buttonSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover {
            background-position: 100% 0;
            transform: translateY(-3px);
            box-shadow: 
                0 20px 50px rgba(184, 134, 11, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* Trust Badge */
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding: 16px 18px;
            background: rgba(34, 197, 94, 0.05);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 12px;
            animation: footerSlideIn 0.8s ease 1.1s both;
        }

        @keyframes footerSlideIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .trust-icon {
            font-size: 22px;
        }

        .trust-text {
            font-size: 12px;
            color: #86efac;
            line-height: 1.5;
        }

        .trust-text strong {
            color: #4ade80;
        }

        /* Footer */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid rgba(184, 134, 11, 0.1);
            animation: footerSlideIn 0.8s ease 1.2s both;
        }

        .footer-text {
            font-size: 13px;
            color: #64748b;
        }

        .footer-link {
            color: #daa520;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #ffd700;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .login-container {
                grid-template-columns: 1fr 0.9fr;
            }
            
            .hero-title {
                font-size: 40px;
            }
        }

        @media (max-width: 1024px) {
            body {
                align-items: flex-start;
                padding: 30px 20px;
            }

            .login-container {
                grid-template-columns: 1fr;
                max-width: 600px;
                margin: 0 auto;
            }

            .login-left {
                padding: 50px 40px;
            }

            .login-right {
                padding: 50px 40px;
                border-left: none;
                border-top: 1px solid rgba(184, 134, 11, 0.1);
            }

            .hero-title {
                font-size: 36px;
            }

            .form-title {
                font-size: 34px;
            }

            .features-list {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .login-left,
            .login-right {
                padding: 40px 30px;
            }

            .hero-title {
                font-size: 32px;
            }

            .form-title {
                font-size: 30px;
            }

            .logo-container {
                width: 75px;
                height: 75px;
            }

            .logo-main {
                font-size: 32px;
            }

            .brand-name {
                font-size: 22px;
            }

            .features-list {
                grid-template-columns: 1fr;
            }

            .legal-symbol {
                font-size: 40px !important;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px 10px;
            }

            .login-left,
            .login-right {
                padding: 30px 24px;
            }

            .hero-title {
                font-size: 28px;
            }

            .form-title {
                font-size: 26px;
            }

            .hero-subtitle {
                font-size: 14px;
            }

            .form-input {
                padding: 16px 20px 16px 52px;
                font-size: 14px;
            }

            .btn-login {
                padding: 17px;
                font-size: 14px;
            }

            .logo-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .logo-main {
                font-size: 28px;
            }

            .form-footer {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .feature-item {
                padding: 16px;
            }

            .feature-icon {
                width: 42px;
                height: 42px;
                font-size: 20px;
            }
        }

        /* Ultra-wide screens */
        @media (min-width: 1440px) {
            .login-wrapper {
                max-width: 1400px;
            }

            .login-left,
            .login-right {
                padding: 80px 70px;
            }

            .hero-title {
                font-size: 52px;
            }

            .form-title {
                font-size: 42px;
            }
        }

        @keyframes rippleEffect {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <canvas id="particles-canvas"></canvas>
    <div class="bg-overlay"></div>

    <!-- Floating Legal Symbols -->
    <div class="legal-symbols">
        <div class="legal-symbol">⚖️</div>
        <div class="legal-symbol">📜</div>
        <div class="legal-symbol">✒️</div>
        <div class="legal-symbol">🏛️</div>
        <div class="legal-symbol">📋</div>
    </div>

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Section -->
            <div class="login-left">
                <div class="logo-section">
                    <div class="logo-container">
                        <div class="logo-ring"></div>
                        <div class="logo-ring"></div>
                        <div class="logo-main">⚖️</div>
                    </div>
                    <div class="brand-text">
                        <div class="brand-name">NOTARIS PRO</div>
                        <div class="brand-tagline">Legal Excellence Platform</div>
                    </div>
                </div>

                <div class="brand-content">
                    <h1 class="hero-title">Manajemen Notaris Digital Terpercaya</h1>
                    <p class="hero-subtitle">Platform terintegrasi untuk mengelola seluruh aspek kantor notaris dengan teknologi modern, keamanan tingkat enterprise, dan efisiensi maksimal.</p>

                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">📁</div>
                            <div class="feature-text">
                                <h4>Dokumen Digital</h4>
                                <p>Arsip digital dengan sistem pencarian cepat dan akurat</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">👥</div>
                            <div class="feature-text">
                                <h4>Manajemen Klien</h4>
                                <p>Database klien lengkap dengan riwayat transaksi</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">📅</div>
                            <div class="feature-text">
                                <h4>Jadwal Pintar</h4>
                                <p>Kalender terintegrasi dengan notifikasi otomatis</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🔒</div>
                            <div class="feature-text">
                                <h4>Keamanan Tinggi</h4>
                                <p>Enkripsi end-to-end dan backup cloud otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Form (ORIGINAL - TIDAK DIUBAH!) -->
            <div class="login-right">
                <div class="form-header">
                    <h2 class="form-title">Selamat Datang</h2>
                    <p class="form-subtitle">Masuk untuk mengakses dashboard Anda</p>
                </div>

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="login-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="nama@perusahaan.com" 
                                required 
                                autocomplete="email"
                            >
                            <span class="input-icon">📧</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="Masukkan kata sandi Anda" 
                                required 
                                autocomplete="current-password"
                            >
                            <span class="input-icon">🔒</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        MASUK KE DASHBOARD
                    </button>

                    <div class="trust-badge">
                        <span class="trust-icon">🛡️</span>
                        <div class="trust-text">
                            <strong>Koneksi Aman:</strong> Data Anda dilindungi dengan enkripsi SSL 256-bit
                        </div>
                    </div>

                    <div class="form-footer">
                        <span class="footer-text">© 2024 Notaris System</span>
                        <a href="#" class="footer-link">Butuh bantuan?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Notary-themed Particle Animation
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        resizeCanvas();

        const particles = [];
        const particleCount = 80;
        
        // Notary-themed symbols
        const symbols = ['⚖️', '📜', '✒️', '📋', '🏛️'];

        class Particle {
            constructor() {
                this.reset();
                this.y = Math.random() * canvas.height;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            reset() {
                this.x = Math.random() * canvas.width;
                this.y = -20;
                this.size = Math.random() * 2.5 + 1;
                this.speedX = Math.random() * 0.6 - 0.3;
                this.speedY = Math.random() * 0.8 + 0.3;
                this.rotation = Math.random() * Math.PI * 2;
                this.rotationSpeed = (Math.random() - 0.5) * 0.02;
                this.isSymbol = Math.random() > 0.85;
                this.symbol = symbols[Math.floor(Math.random() * symbols.length)];
                this.pulsePhase = Math.random() * Math.PI * 2;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.rotation += this.rotationSpeed;
                this.pulsePhase += 0.02;

                if (this.y > canvas.height + 20) {
                    this.reset();
                }
                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
            }

            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation);
                
                const pulse = Math.sin(this.pulsePhase) * 0.3 + 0.7;
                
                if (this.isSymbol) {
                    ctx.font = `${this.size * 8}px Arial`;
                    ctx.fillStyle = `rgba(184, 134, 11, ${this.opacity * 0.4 * pulse})`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(this.symbol, 0, 0);
                } else {
                    const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, this.size * pulse);
                    gradient.addColorStop(0, `rgba(218, 165, 32, ${this.opacity})`);
                    gradient.addColorStop(0.5, `rgba(184, 134, 11, ${this.opacity * 0.6})`);
                    gradient.addColorStop(1, 'rgba(184, 134, 11, 0)');
                    
                    ctx.fillStyle = gradient;
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size * pulse, 0, Math.PI * 2);
                    ctx.fill();
                }
                
                ctx.restore();
            }
        }

        function init() {
            particles.length = 0;
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        }

        function connectParticles() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 150 && !particles[i].isSymbol && !particles[j].isSymbol) {
                        const opacity = (1 - distance / 150) * 0.15;
                        ctx.strokeStyle = `rgba(184, 134, 11, ${opacity})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            connectParticles();
            
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            requestAnimationFrame(animate);
        }

        init();
        animate();

        window.addEventListener('resize', () => {
            resizeCanvas();
            init();
        });

        // Enhanced Input Interactions (TIDAK MENGGANGGU FUNGSI LOGIN!)
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const wrapper = this.parentElement;
                if (wrapper) {
                    wrapper.style.transform = 'scale(1.01)';
                    wrapper.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                }
            });
            
            input.addEventListener('blur', function() {
                const wrapper = this.parentElement;
                if (wrapper) {
                    wrapper.style.transform = 'scale(1)';
                }
            });
        });

        // Premium Button Ripple Effect (TIDAK MENGGANGGU SUBMIT!)
        const button = document.querySelector('.btn-login');
        
        if (button) {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: rippleEffect 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }
    </script>
</body>
</html>