<?php
$userId = $_SESSION['user']['id'] ?? null;
$userName = $_SESSION['user']['name'] ?? null;
$settingId = $_SESSION['settings']['settingID'] ?? null;
$userPic = $_SESSION['user']['pic'] ?? null;
$hasViewAccess = $_SESSION['user']['role'] === 'admin';

$userPicHtml = $userPic ? '<img width="25" height="25" src="' . $userPic . '" class="rounded-circle" alt="...">' : '<img width="25" height="25" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
?>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <hr id="hr-divider">
    <ul class="navbar-nav ms-auto pt-lg-3">
        <li class="nav-item">
            <a class="nav-link <?php echo activePage(['admin', 'admin/']); ?>" href="<?php echo APPURL; ?>/admin">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo activePage(['admin/categories', 'admin/categories/create', 'admin/categories/edit/{id}']); ?>" href="<?php echo APPURL; ?>/admin/categories">CATEGORIES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo activePage(['admin/pages', 'admin/pages/create', 'admin/pages/edit/{id}']); ?>" href="<?php echo APPURL; ?>/admin/pages">PAGES</a>
        </li>
        <li class="nav-item">
            <?php if ($hasViewAccess) : ?>
                <a class="nav-link <?php echo activePage(['admin/users', 'admin/users/create', 'admin/users/edit/{id}', 'admin/users/profile']); ?>" href="<?php echo APPURL; ?>/admin/users">USERS</a>
            <?php else : ?>
                <button type="button" class="btn nav-link text-muted" disabled>USERS</button>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <div class="dropdown mt-2 mt-lg-0">
                <a class="btn btn-link text-secondary text-decoration-none px-1 px-lg-3 py-2 border-0 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $userPicHtml; ?>
                </a>
                <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                    <li>
                        <!-- Modal -->
                        <a href="<?php echo APPURL . '/admin/users/profile/' . $userId; ?>" class="d-modal dropdown-item" data-title="User Profile">Profile</a>
                    </li>
                    <li>
                        <!-- Modal -->
                        <button type="button" class="d-modal dropdown-item" data-title="Settings - <?php echo $userName; ?>" data-link="<?php echo htmlspecialchars(APPURL . '/admin/settings/edit_modal/' . $settingId); ?>" data-submit="true">
                            Settings
                        </button>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-0">
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo APPURL; ?>/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>