<?php
// dd($data);
$userPic = $_SESSION['userPicture'] ? '<img width="25" height="25" src="' . $_SESSION['userPicture'] . '" class="rounded-circle" alt="...">' : '<img width="25" height="25" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
?>

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
            <a class="nav-link <?= activePage(['admin/users', 'admin/users/create', 'admin/users/edit/{:id}', 'admin/users/profile']) ?>" href="<?php echo APPURL; ?>/admin/users">USERS</a>
        </li>
        <li class="nav-item">
            <div class="dropdown mt-2 mt-lg-0">
                <a class="btn btn-link text-secondary text-decoration-none px-1 px-lg-3 py-2 border-0 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $userPic; ?>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="<?php echo APPURL . '/admin/users/profile/' . $_SESSION['userID']; ?>">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?php echo APPURL; ?>/logout">LOGOUT</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>