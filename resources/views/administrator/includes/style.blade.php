<style>
    a {
        color: {{ Helper::getLinkColor() }} !important;
    }

    a.btn-dark:hover {
        color: #fff !important;
    }

    a:hover {
        color: {{ Helper::getLinkColorHover() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-link {
        color: {{ Helper::getMenuColor() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-second-level li a,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-third-level li a,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-forth-level li a {
        color: {{ Helper::getMenuColor() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-link:hover {
        color: {{ Helper::getMenuColorHover() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-second-level li a:focus,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-second-level li a:hover,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-third-level li a:focus,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-third-level li a:hover,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-forth-level li a:focus,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-forth-level li a:hover {
        color: {{ Helper::getMenuColorHover() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-link:hover {
        background: {{ Helper::getMenuBackgroundColorHover() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .menuitem-active>a {
        color: {{ Helper::getMenuColorActive() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .menuitem-active>a {
        background: {{ Helper::getMenuBackgroundColorActive() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav-second-level li a.active {
        color: {{ Helper::getSubMenuColor() }} !important;
        background: {{ Helper::getSubMenuBackgroundColor() }} !important;
    }

    body[data-leftbar-theme="dark"] .side-nav .side-nav-second-level li a:active,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-third-level li a:active,
    body[data-leftbar-theme="dark"] .side-nav .side-nav-forth-level li a:active,
    {
    color: {{ Helper::getMenuColorActive() }} !important;
    }



    body[data-leftbar-theme="dark"] .leftside-menu {
        background: {{ Helper::getMenuBackgroundColor() }} !important;
    }

    .leftside-menu {
        background: {{ Helper::getMenuBackgroundColor() }} !important;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: {{ Helper::getButtonTextColorActive() }} !important;
        background-color: {{ Helper::getButtonColorActive() }} !important;
    }

    .nav-pills .nav-link:hover {
        color: {{ Helper::getButtonTextColorHover() }} !important;
        background-color: {{ Helper::getButtonColorHover() }} !important;
    }

    .btn-warning {
        color: {{ Helper::getButtonTextColor() }} !important;
        background-color: {{ Helper::getButtonColor() }} !important;
        border-color: {{ Helper::getButtonColor() }} !important;
    }

    .btn-warning:hover {
        color: {{ Helper::getButtonTextColorHover() }} !important;
        background-color: {{ Helper::getButtonColorHover() }} !important;
        border-color: {{ Helper::getButtonColorHover() }} !important;
    }

    .btn-warning:active,
    .btn-warning:focus {
        color: {{ Helper::getButtonTextColorActive() }} !important;
        background-color: {{ Helper::getButtonColorActive() }} !important;
        border-color: {{ Helper::getButtonColorActive() }} !important;
    }

    .page-item.active .page-link {
        color: {{ Helper::getPaginationColor() }} !important;
        background-color: {{ Helper::getPaginationBackgroundColor() }} !important;
        border-color: {{ Helper::getPaginationBackgroundColor() }} !important;
    }

    .page-link {
        color: {{ Helper::getPaginationColor() }} !important;
    }
</style>
