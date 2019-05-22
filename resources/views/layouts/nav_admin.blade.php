<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fire"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Moje przedmioty
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/subjects">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span class="font-weight-bold">Pokaż wszystkie</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Moje zadania
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/tasks">
            <i class="fas fa-fw fa-meteor"></i>
            <span class="font-weight-bold">Zobacz wszystkie</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="/statistics">
            <i class="fas fa-fw fa-table"></i>
            <span>Statystyki</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin">
            <i class="fas fa-user-cog"></i>
            <span>Panel zarządzania</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>