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

    @if(!empty($w_subjects[0]))
    @foreach($w_subjects as $subject)
        <li class="nav-item">
            <a class="nav-link" href="{{$subject->group->subject->path}}">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>{{$subject->group->subject->name}}</span></a>
        </li>
    @endforeach

    <li class="nav-item">
        <a class="nav-link" href="/subjects">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span class="font-weight-bold">Pokaż wszystkie</span></a>
    </li>

    @else
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span class="font-weight-bold">Nie należysz do żadnej grupy</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Moje zadania
    </div>
    @if(!empty($w_tasks))
    @foreach($w_tasks as $task)
        <li class="nav-item">
            <a class="nav-link" href="{{$task->path}}">
                <i class="fas fa-fw fa-meteor"></i>
                <span>{{$task->name}}</span></a>
        </li>
    @endforeach

    <li class="nav-item">
        <a class="nav-link" href="/tasks">
            <i class="fas fa-fw fa-meteor"></i>
            <span class="font-weight-bold">Zobacz wszystkie</span></a>
    </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span class="font-weight-bold">Aktualnie nie masz żadnych zadań</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="/statistics">
            <i class="fas fa-fw fa-table"></i>
            <span>Statystyki</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>