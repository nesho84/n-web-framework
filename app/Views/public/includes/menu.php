<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <hr id="hr-divider">
    <ul class="navbar-nav ms-auto pt-lg-3">
        <li class="nav-item">
            <a class="nav-link <?= activePage(['/']); ?>" href="<?php echo APPURL; ?>/">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= activePage(['about-us']) ?>" href="<?php echo APPURL; ?>/about-us">ABOUT US</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= activePage(['contact']) ?>" href="<?php echo APPURL; ?>/contact">CONTACT</a>
        </li>
        <li class="nav-item">
            <!-- <a class="nav-link <?= activePage(['distributors']) ?>" href="<?php echo APPURL; ?>/distributors">HÄNDLER</a> -->
        </li>
    </ul>
</div>