<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <hr id="hr-divider">
    <ul class="navbar-nav ms-auto pt-lg-3">
        <li class="nav-item">
            <a class="nav-link <?= activePage(['admin']) ?>" href="<?php echo APPURL; ?>/admin">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= activePage(['admin/pages', 'admin/pages/create', 'admin/pages/edit/{:id}']); ?>" href="<?php echo APPURL; ?>/admin/pages">PAGES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= activePage(['admin/categories', 'admin/categories/create', 'admin/categories/edit/{:id}']) ?>" href="<?php echo APPURL; ?>/admin/categories">CATEGORIES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= activePage(['admin/users', 'admin/users/create', 'admin/users/edit/{:id}']) ?>" href="<?php echo APPURL; ?>/admin/users">USERS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold" href="<?php echo APPURL; ?>/logout">LOGOUT</a>
        </li>
    </ul>
</div>