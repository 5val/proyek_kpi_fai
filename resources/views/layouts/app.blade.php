<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem KPI Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, #34495e 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .top-navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-custom .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .badge-score {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        .progress-custom {
            height: 10px;
            border-radius: 10px;
        }
        
        .btn-custom {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table-custom thead {
            background: var(--primary-color);
            color: white;
        }
        
        .logo-section {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .logo-section h4 {
            color: white;
            margin-top: 10px;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="logo-section">
                    <i class="bi bi-graph-up-arrow" style="font-size: 3rem; color: white;"></i>
                    <h4>KPI Kampus</h4>
                    <small class="text-light">Sistem Monitoring Kinerja</small>
                </div>
                
                <nav class="nav flex-column">
                    @yield('sidebar-menu')
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10">
                <div class="main-content">
                    <!-- Top Navbar -->
                    <div class="top-navbar d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">@yield('page-title')</h5>
                            <small class="text-muted">@yield('page-subtitle')</small>
                        </div>
                        <div class="user-info">
                            <div>
                                <div class="fw-bold">@yield('user-name', 'Admin')</div>
                                <small class="text-muted">@yield('user-role', 'Administrator')</small>
                            </div>
                            <div class="user-avatar">
                                @yield('user-initial', 'A')
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Pengaturan</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>