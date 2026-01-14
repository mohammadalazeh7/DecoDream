<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Leaflet CSS -->
    <!-- بدون مسافات -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet @1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet @1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #2F5D50 0%, #1B3C34 100%);
            min-height: 100vh;
            width: 250px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 0;
            position: fixed;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar .logo-text {
            /* color: white; */
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            margin-top: 20px;
        }


        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .sidebar-menu li {
            margin: 5px 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            /* background-color: rgba(255, 255, 255, 0.1); */
            background-color: #1B3C34;
            /* color: white; */
            color: #fff;
            /* border-left-color: #28a745; */
            border-left-color: #2F5D50;
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 0;
        }

        .top-navbar {
            /* background: white; */
            background: #2F5D50;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            background: linear-gradient(135deg, #2F5D50 0%, #1B3C34 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            user-select: none;
        }

        .content-area {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            /* color: #333; */
            color: #2F5D50;
        }

        .btn-primary {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            background: linear-gradient(135deg, #2F5D50 0%, #1B3C34 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: #fff;
        }

        .btn-info {
            background: linear-gradient(135deg, #2F5D50 0%, #1B3C34 100%);
            border: none;
            border-radius: 8px;
            /* padding: 10px 20px; */
            color: #fff;
        }

        /*
         .btn-primary:hover {
            background: #1B3C34;
            color: #fff;
        }

        .btn-outline-dark {
            border-radius: 30px;
            border-color: #2F5D50;
            color: #2F5D50;
        }

        .btn-outline-dark:hover {
            background: #2F5D50;
            color: #fff;
        } */

        .table-container {
            /* background: #1B3C34; */
            background: white;
            border-radius: 15px;
            overflow: hidden;
            /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); */
            box-shadow: 0 5px 15px rgba(47, 93, 80, 0.08);
        }

        .table {
            margin: 0;
        }

        .table thead {
            /* background: linear-gradient(135deg, #2c5530 0%, #1e3a20 100%); */
            background: #2F5D50;
            /* color: white; */
            color: #fff;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 15px;
            /* border-bottom: 1px solid #e9ecef; */
            border-bottom: 1px solid #2F5D50;
            vertical-align: middle;
            /* color: #fff; */
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            /* border-radius: 5px; */
            border-radius: 30px !important;
        }

        .btn-edit {
            /* background: #17a2b8;
            color: white; */
            background: #2F5D50;
            color: #fff;
            border: none;
        }

        ///////////////////////////////////
        .btn-edit:hover {
            background: #1B3C34;
            color: #fff;
        }

        ///////////////////////////////////

        /* .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
        } */
        .btn-delete {
            background: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-delete:hover {
            background: #a71d2a;
            color: #fff;
        }

        .pagination {
            margin-top: 20px;
            justify-content: center;
        }

        .page-link {
            /* color: #2c5530;
            border-color: #dee2e6; */
            border-radius: 30px !important;
            background: #1B3C34;
            color: #fff;
            border: 1px solid #2F5D50;
        }

        .page-item.active .page-link {
            /* background-color: #2c5530;
            border-color: #2c5530; */
            background: #2F5D50;
            color: #fff;
            border-color: #2F5D50;
        }

        ///////////////////////////////////
        .card {
            background: #1B3C34;
            border-radius: 30px;
            /* color: #fff; */
        }

        .card-header {
            background: #2F5D50;
            border-radius: 30px 30px 0 0;
            color: #fff;
        }

        .form-control {
            border-radius: 30px;
            /* background: #0F241F; */
            /* color: #fff; */
            border: 1px solid #2F5D50;
        }

        /* .form-control:focus {
            border-color: #2F5D50;
            box-shadow: 0 0 0 0.2rem rgba(47, 93, 80, 0.25);
            background: #1B3C34;
            color: #fff;
        } */


        .img-thumbnail {
            border-radius: 20px;
            background: #2F5D50;
            border: 2px solid #1B3C34;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" role="navigation" aria-label="Main Sidebar">
        <div class="logo">
            <div class="d-flex align-items-center justify-content-center">
                <div
                    style="width: 40px; height: 40px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                    <i class="fas fa-cash-register" style="color: #2c5530;" aria-hidden="true"></i>
                </div>
                <span class="logo-text">{{ config('app.name') }}</span>
            </div>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-menu">
                @if (auth()->user()->role->role_name == 'Super Admin')
                    <li><a href="{{ route('employees.index') }}"
                            class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <i class="fas fa-users" aria-hidden="true"></i> Employees
                        </a></li>
                    <li><a href="{{ route('users.index') }}"
                            class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users" aria-hidden="true"></i> Users
                        </a></li>
                @endif

                @if (auth()->user()->role->role_name == 'Data Entry')
                    <li><a href="{{ route('products.index') }}"
                            class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-box" aria-hidden="true"></i> Products
                        </a></li>
                    <li><a href="{{ route('categories.index') }}"
                            class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="fas fa-list" aria-hidden="true"></i> Categories
                        </a></li>
                    <li><a href="{{ route('woods.index') }}"
                            class="{{ request()->routeIs('woods.*') ? 'active' : '' }}">
                            <i class="fas fa-tree" aria-hidden="true"></i> Woods
                        </a></li>
                    <li><a href="{{ route('fabrics.index') }}"
                            class="{{ request()->routeIs('fabrics.*') ? 'active' : '' }}">
                            <i class="fas fa-cut" aria-hidden="true"></i> Fabrics
                        </a></li>
                @endif

                @if (auth()->user()->role->role_name == 'Order Validater')
                    <li><a href="{{ route('orders.index') }}"
                            class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i> Orders
                        </a></li>
                @endif

                @if (auth()->user()->role->role_name == 'Support Team')
                    <li><a href="{{ route('complaints.index') }}"
                            class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                            <i class="fas fa-comment-dots" aria-hidden="true"></i> Complaints
                        </a></li>
                @endif

                @if (auth()->user()->role->role_name == 'Shipping Representative')
                    <li><a href="{{ route('invoices.index') }}"
                            class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                            <i class="fas fa-comment-dots" aria-hidden="true"></i> Invoices
                        </a></li>
                @endif
            </ul>
        </div>

        <div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('logout') }}" role="button"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="user-info" aria-label="User info">
                <span>
                    @if (auth()->user()->role->role_name === 'Super Admin')
                        <a href="{{ route('profile') }}" class="btn btn-primary px-4 rounded-pill">
                            {{ auth()->user()->role->role_name }}
                        </a>
                    @else
                        {{ auth()->user()->name }}
                    @endif
                </span>
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>


        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
