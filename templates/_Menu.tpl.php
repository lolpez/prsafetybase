<header id="header" class="page-topbar">
    <div class="navbar-fixed">
        <nav class="navbar-color black">
            <div class="nav-wrapper">
                <ul class="left">
                    <li>
                        <h1 class="logo-wrapper">
                            <a href="index.html" class="brand-logo darken-1">
                                <img src="./resources/images/materialize-logo.png" alt="materialize logo">
                            </a>
                            <span class="logo-text">Materialize</span>
                        </h1>
                    </li>
                </ul>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                            <i class="mdi-action-settings-overscan"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown">
                            <i class="mdi-social-notifications"><small class="notification-badge">5</small></i>
                        </a>
                    </li>
                </ul>
                <ul id="notifications-dropdown" class="dropdown-content">
                    <li>
                        <h5>NOTIFICATIONS <span class="new badge">5</span></h5>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#!"><i class="mdi-action-add-shopping-cart"></i> A new order has been placed!</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-stars"></i> Completed the task</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-settings"></i> Settings updated</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-editor-insert-invitation"></i> Director meeting started</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                    </li>
                    <li>
                        <a href="#!"><i class="mdi-action-trending-up"></i> Generate monthly report</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<div id="main">
    <div class="wrapper">
        <aside id="left-sidebar-nav">
            <ul id="slide-out" class="side-nav fixed leftside-navigation">
                <li class="user-details cyan darken-2">
                    <div class="row">
                        <div class="col col s4 m4 l4">
                            <img src="./resources/images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
                        </div>
                        <div class="col col s8 m8 l8">
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li>
                                    <a href="#"><i class="mdi-action-face-unlock"></i> Mi perfil</a>
                                </li>
                                <li>
                                    <a href="#"><i class="mdi-communication-live-help"></i> Help</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="logout"><i class="mdi-hardware-keyboard-tab"></i> Cerrar Sesión</a>
                                </li>
                            </ul>
                            <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">
                                <?php $this->eprint($this->currentUser->Name); ?><i class="mdi-navigation-arrow-drop-down right"></i>
                            </a>
                            <p class="user-roal">Admin</p>
                        </div>
                    </div>
                </li>
                <li <?php if ($this->nav=='home') { echo 'class="active"'; } ?> >
                    <a href="./" class="waves-effect waves-cyan"><i class="mdi-action-home"></i> Inicio</a>
                </li>
                <li <?php if ($this->nav=='report') { echo 'class="active"'; } ?> >
                    <a href="./report" class="waves-effect waves-cyan"><i class="mdi-action-announcement"></i> Reporte</a>
                </li>
            </ul>
            <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
        </aside>
        <section id="content">