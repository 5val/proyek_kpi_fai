<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem KPI Kampus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --sidebar-width: 260px;
            --header-height: 70px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden; /* Mencegah scroll horizontal body */
        }

        /* === LAYOUT SYSTEM === */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            transition: all 0.3s;
        }

        /* === SIDEBAR STYLING === */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #34495e 100%);
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
            z-index: 1050; /* Pastikan di atas overlay */
        }

        /* Sidebar Link */
        #sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-size: 0.95rem;
        }

        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
            transition: all 0.2s;
        }

        #sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 12px;
            width: 25px;
            text-align: center;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        /* === CONTENT AREA === */
        #content {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0; /* PENTING: Agar flex item tidak overflow screen */
        }

        /* Navbar Top */
        .navbar-top {
            padding: 10px 25px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            min-height: var(--header-height);
            display: flex;
            align-items: center;
        }

        .content-padding {
            padding: 0 25px 25px 25px;
            flex: 1;
        }

        /* === RESPONSIVE LOGIC === */
        
        /* Desktop Mode (Layar Besar) */
        @media (min-width: 992px) {
            #sidebar.collapsed {
                margin-left: calc(var(--sidebar-width) * -1);
            }
            .btn-close-sidebar { display: none; }
        }

        /* Mobile Mode (Layar Kecil/Tablet) */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
                position: fixed; /* Sidebar melayang di mobile */
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto; /* Scroll jika menu panjang */
                box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            }
            
            #sidebar.active {
                margin-left: 0; /* Slide in */
            }

            /* Overlay Gelap */
            #overlay {
                display: none;
                position: fixed;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 1040; /* Di bawah sidebar, di atas content */
                top: 0; left: 0;
                opacity: 0;
                transition: all 0.5s ease-in-out;
            }
            
            #overlay.active {
                display: block;
                opacity: 1;
            }

            /* Adjust Content Padding Mobile */
            .navbar-top { padding: 10px 15px; }
            .content-padding { padding: 0 15px 15px 15px; }
            
            /* Text Truncate di Navbar Mobile */
            .navbar-title-wrapper {
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        /* === UTILITY === */
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 20px;
        }
        .card-custom .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        /* Avatar */
        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--secondary-color);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
            overflow: hidden;
        }
        .user-avatar img {
            width: 100%; height: 100%; object-fit: cover;
        }

        /* Fix DataTables Responsive Scroll */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Custom Scrollbar */
        #sidebar::-webkit-scrollbar { width: 5px; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
    </style>
    @stack('styles')
</head>
<body>

    <div id="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mx-auto">
                        <i class="bi bi-graph-up-arrow fs-1"></i>
                        <h5 class="mt-2 fw-bold mb-0">KPI Kampus</h5>
                    </div>
                    <button type="button" id="dismiss" class="btn btn-close-sidebar text-white bg-transparent border-0 d-lg-none">
                        <i class="bi bi-x-lg fs-4"></i>
                    </button>
                </div>
                <small class="d-block text-white-50 mt-1">Sistem Monitoring Kinerja</small>
            </div>

            <div class="p-2">
                @auth
                    {{-- ================= MENU ADMIN ================= --}}
                    @if(Auth::user()->role == 'admin')
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <small class="text-white-50 text-uppercase px-3 mt-3 mb-1 d-block fw-bold" style="font-size: 0.75rem;">Manajemen</small>
                        <a class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}" href="{{ route('admin.user') }}"><i class="bi bi-people-fill"></i> User</a>
                        <a class="nav-link {{ request()->routeIs('admin.fasilitas*') ? 'active' : '' }}" href="{{ route('admin.fasilitas') }}"><i class="bi bi-building"></i> Fasilitas</a>
                        <a class="nav-link {{ request()->routeIs('admin.unit*') ? 'active' : '' }}" href="{{ route('admin.unit') }}"><i class="bi bi-bank2"></i> Unit</a>
                        
                        <small class="text-white-50 text-uppercase px-3 mt-3 mb-1 d-block fw-bold" style="font-size: 0.75rem;">Akademik</small>
                        <a class="nav-link {{ request()->routeIs('admin.periode*') ? 'active' : '' }}" href="{{ route('admin.periode') }}"><i class="bi bi-calendar-event-fill"></i> Periode</a>
                        <a class="nav-link {{ request()->routeIs('admin.mata_kuliah*') ? 'active' : '' }}" href="{{ route('admin.mata_kuliah') }}"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
                        <a class="nav-link {{ request()->routeIs('admin.kelas*') ? 'active' : '' }}" href="{{ route('admin.kelas') }}"><i class="bi bi-easel-fill"></i> Kelas</a>
                        
                        <small class="text-white-50 text-uppercase px-3 mt-3 mb-1 d-block fw-bold" style="font-size: 0.75rem;">KPI & Laporan</small>
                        <a class="nav-link {{ request()->routeIs('admin.kategori_kpi*') ? 'active' : '' }}" href="{{ route('admin.kategori_kpi') }}"><i class="bi bi-tags-fill"></i> Kategori KPI</a>
                        <a class="nav-link {{ request()->routeIs('admin.penilaian*') ? 'active' : '' }}" href="{{ route('admin.penilaian') }}"><i class="bi bi-star-fill"></i> Penilaian</a>
                        <a class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}" href="{{ route('admin.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
                        <a class="nav-link {{ request()->routeIs('admin.feedback*') ? 'active' : '' }}" href="{{ route('admin.feedback') }}"><i class="bi bi-chat-left-text-fill"></i> Feedback</a>

                    {{-- ================= MENU DOSEN ================= --}}
                    @elseif(Auth::user()->role == 'dosen')
                        <a class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}" href="{{ route('dosen.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        <a class="nav-link {{ request()->routeIs('dosen.kpi*') ? 'active' : '' }}" href="{{ route('dosen.kpi') }}"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
                        <a class="nav-link {{ request()->routeIs('dosen.kelas*') ? 'active' : '' }}" href="{{ route('dosen.kelas') }}"><i class="bi bi-book-fill"></i> Kelas</a>
                        <a class="nav-link {{ request()->routeIs('dosen.penilaian_mahasiswa*') ? 'active' : '' }}" href="{{ route('dosen.penilaian_mahasiswa') }}"><i class="bi bi-people"></i> Penilaian Mahasiswa</a>
                        <a class="nav-link {{ request()->routeIs('dosen.penilaian_fasilitas*') ? 'active' : '' }}" href="{{ route('dosen.penilaian_fasilitas') }}"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
                        <a class="nav-link {{ request()->routeIs('dosen.penilaian_unit*') ? 'active' : '' }}" href="{{ route('dosen.penilaian_unit') }}"><i class="bi bi-bank2"></i> Penilaian Unit</a>
                        <a class="nav-link {{ request()->routeIs('dosen.laporan*') ? 'active' : '' }}" href="{{ route('dosen.laporan') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kinerja</a>
                        <a class="nav-link {{ request()->routeIs('dosen.feedback*') ? 'active' : '' }}" href="{{ route('dosen.feedback') }}"><i class="bi bi-chat-left-text"></i> Feedback</a>

                    {{-- ================= MENU MAHASISWA ================= --}}
                    @elseif(Auth::user()->role == 'mahasiswa')
                        <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.kpi*') ? 'active' : '' }}" href="{{ route('mahasiswa.kpi') }}"><i class="bi bi-clipboard-check"></i> KPI Saya</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.penilaian_dosen*') ? 'active' : '' }}" href="{{ route('mahasiswa.penilaian_dosen') }}"><i class="bi bi-star"></i> Penilaian Dosen</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.penilaian_fasilitas*') ? 'active' : '' }}" href="{{ route('mahasiswa.penilaian_fasilitas') }}"><i class="bi bi-building"></i> Penilaian Fasilitas</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.penilaian_unit*') ? 'active' : '' }}" href="{{ route('mahasiswa.penilaian_unit') }}"><i class="bi bi-bank2"></i> Penilaian Unit</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.penilaian_praktikum*') ? 'active' : '' }}" href="{{ route('mahasiswa.penilaian_praktikum') }}"><i class="bi bi-person-workspace"></i> Penilaian Praktikum</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.laporan*') ? 'active' : '' }}" href="{{ route('mahasiswa.laporan') }}"><i class="bi bi-bar-chart"></i> Laporan KPI</a>
                        <a class="nav-link {{ request()->routeIs('mahasiswa.feedback*') ? 'active' : '' }}" href="{{ route('mahasiswa.feedback') }}"><i class="bi bi-chat-left-text"></i> Feedback</a>
                    @endif
                @endauth

                <div class="mt-4 px-3 pb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100 d-flex align-items-center justify-content-center" type="submit">
                            <i class="bi bi-box-arrow-left me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div id="content">
            <nav class="navbar navbar-top">
                <div class="container-fluid px-0">
                    <div class="d-flex align-items-center">
                        <button type="button" id="sidebarCollapse" class="btn btn-light border shadow-sm me-3">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div class="navbar-title-wrapper">
                            <h5 class="mb-0 text-dark fw-bold text-truncate">@yield('page-title')</h5>
                            <small class="text-muted d-none d-sm-block">@yield('page-subtitle')</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="text-end me-3 d-none d-md-block">
                            <div class="fw-bold text-dark">@yield('user-name', Auth::user()->name ?? 'Guest')</div>
                            <small class="text-muted">
                                @auth
                                    {{ ucfirst(Auth::user()->role) }}
                                @endauth
                            </small>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="user-avatar shadow-sm border">
                                    <img src="{{ Auth::user()->photo_profile ? Storage::url(Auth::user()->photo_profile) : asset('images/default-user.png') }}" class="rounded-circle" width="45" alt="Profile" height="45">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow ms-2">
                                <li class="d-block d-md-none px-3 py-2 text-center border-bottom bg-light">
                                    <div class="fw-bold text-truncate">{{ Auth::user()->name ?? 'Guest' }}</div>
                                    <small class="text-muted">{{ ucfirst(Auth::user()->role ?? '') }}</small>
                                </li>
                                <li><a class="dropdown-item py-2" href="/profiles"><i class="bi bi-person me-2"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="content-padding">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="overlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
      $(document).ready(function () {
          // DataTables Config
          if ($.fn.DataTable) {
              var table = $('.data-table').DataTable({
                  "order": [],
                  "language": {
                      "search": "Cari:",
                      "lengthMenu": "Tampilkan _MENU_ data",
                      "paginate": { "next": ">>", "previous": "<<" }
                  }
              });
              
              // === FITUR KUNCI: Membuat Tabel Responsive Scroll ===
              // Membungkus tabel dengan div scrollable agar tidak merusak layout HP
              $('.data-table').wrap('<div class="table-responsive-wrapper"></div>');
          }

          // Sidebar Toggle Logic
          $('#sidebarCollapse').on('click', function () {
              $('#sidebar').toggleClass('active'); // Slide In (Mobile)
              $('#sidebar').toggleClass('collapsed'); // Slide Out (Desktop)
              
              // Tampilkan Overlay hanya di layar kecil
              if ($(window).width() <= 992) {
                  $('#overlay').toggleClass('active');
              }
          });

          // Tutup sidebar saat klik tombol X atau Overlay (Mobile)
          $('#dismiss, #overlay').on('click', function () {
              $('#sidebar').removeClass('active');
              $('#overlay').removeClass('active');
          });

          // Reset saat resize layar
          $(window).resize(function() {
              if ($(window).width() > 992) {
                  $('#overlay').removeClass('active');
                  $('#sidebar').removeClass('active');
              }
          });
      });
   </script>
    @stack('scripts')
</body>
</html>