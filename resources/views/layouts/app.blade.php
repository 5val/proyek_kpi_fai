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
                                <img src="data:image/png;base64,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" class="img-fluid rounded-circle" style="width:40px;height:40px;object-fit:cover;">
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