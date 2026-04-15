<nav class="main-navbar">
    <div class="container">
        <ul>



            <li
                class="menu-item  ">
                <a href="{{ route('dashboard') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                </a>
            </li>
            <li
                class="menu-item  ">
                <a href="{{ route('unidades.index') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Unidades</span>
                </a>
            </li>
            <li
                class="menu-item  ">
                <a href="{{ route('delegados.index') }}" class='menu-link'>
                    <span><i class="bi bi-people-fill"></i> Delegados</span>
                </a>
            </li>

            <li
                class="menu-item  ">
                <a href="{{ route('sessoes.index') }}" class='menu-link'>
                    <span><i class="bi bi-calendar-date-fill"></i> Sessões</span>
                </a>
            </li>
            <li
                class="menu-item  ">
                <a href="{{ route('documentos.index') }}" class='menu-link'>
                    <span><i class="bi bi-file-earmark-text-fill"></i> Documentos</span>
                </a>
            </li>
            <li
                class="menu-item  ">
                <a href="{{ route('comissoes.index') }}" class='menu-link'>
                    <span><i class="bi bi-people-fill"></i> Comissões</span>
                </a>
            </li>
            <li
                class="menu-item  ">
                <a href="{{ route('atas.index') }}" class='menu-link'>
                    <span><i class="bi bi-file-earmark-text-fill"></i> Atas</span>
                </a>
            </li>

            <!-- <li
                class="menu-item  has-sub">
                <a href="{{ route('dashboard') }}" class='menu-link'>
                    <span><i class="bi bi-stack"></i> Components</span>
                </a>
                <div
                    class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li
                                class="submenu-item  ">
                                <a href="component-alert.html"
                                    class='submenu-link'>Alert</a>


                            </li>
                        </ul>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
</nav>