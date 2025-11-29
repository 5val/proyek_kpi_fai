<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem KPI Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('https://s1infpro.istts.ac.id/wp-content/uploads/2021/03/gedung1.jpeg');
            /* Menggunakan dvh untuk mobile browser modern */
            min-height: 100vh;
            min-height: 100dvh; 
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            /* Mencegah background bergeser saat keyboard muncul di HP */
            background-attachment: fixed; 
            /* Overlay gelap agar teks footer terbaca */
            background-color: rgba(0,0,0,0.4); 
            background-blend-mode: overlay;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 15px; /* Padding container dikurangi sedikit */
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: bold;
            font-size: 1.75rem;
        }
        
        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .login-body {
            padding: 2.5rem 2rem;
        }
        
        .form-floating {
            margin-bottom: 1.25rem;
        }
        
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }
        
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            border: none;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s;
            border-radius: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .icon-wrapper {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(5px);
        }
        
        .icon-wrapper i {
            font-size: 2rem;
        }

        /* Footer Text */
        .footer-text {
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            font-size: 0.9rem;
        }

        /* === RESPONSIVE KHUSUS MOBILE === */
        @media (max-width: 576px) {
            .login-header {
                padding: 2rem 1.5rem; /* Kurangi padding header */
            }
            
            .login-header h2 {
                font-size: 1.5rem; /* Kecilkan font judul */
            }
            
            .login-body {
                padding: 2rem 1.5rem; /* Kurangi padding body form */
            }
            
            .icon-wrapper {
                width: 50px;
                height: 50px;
                margin-bottom: 0.8rem;
            }
            
            .icon-wrapper i {
                font-size: 1.5rem;
            }
            
            .btn-login {
                padding: 0.6rem; /* Tombol sedikit lebih ramping */
            }
        }
        
        /* Fix untuk layar landscape pendek (HP dimiringkan) */
        @media (max-height: 600px) {
            body {
                padding-top: 20px;
                padding-bottom: 20px;
                align-items: flex-start; /* Agar bisa discroll jika tinggi kurang */
                overflow-y: auto;
            }
            .login-container {
                margin-top: auto;
                margin-bottom: auto;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="icon-wrapper">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h2>Sistem KPI Kampus</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>
            
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" style="font-size: 0.9rem;" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('loginData') }}">
                    @csrf
                    
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" placeholder="name@example.com" 
                               value="{{ old('email') }}" required autofocus>
                        <label for="email"><i class="fas fa-envelope me-2 text-muted"></i>Email</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-floating position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Password" required>
                        <label for="password"><i class="fas fa-lock me-2 text-muted"></i>Password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-login mt-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </form>
            </div>  
        </div>
        
        <div class="text-center mt-4 text-white footer-text">
            <p class="mb-0">&copy; {{ date('Y') }} Sistem KPI Kampus. All rights reserved.</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>