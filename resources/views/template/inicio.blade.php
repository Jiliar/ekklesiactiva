<!DOCTYPE html>
<html lang="en" class=" scrollbar-type-1 ">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="vendors/metro4/css/metro-all.css">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <title>Traso Colectivo - Becas Boomerang</title>

    <script>
        window.on_page_functions = [];
    </script>
</head>
<body class="m4-cloak h-vh-100">
<div data-role="navview" data-toggle="#paneToggle" data-expand="xl" data-compact="lg" data-active-state="true">
    <div class="navview-pane">
        <div class="d-flex flex-align-center">
            <button class="pull-button m-0 bg-darkPurple-hover">
                <span class="mif-menu fg-white"></span>
            </button>
            <h2 class="text-light m-0 fg-white pl-7" style="line-height: 52px">
            <img src='images/ekklesia-logo-4.png' style='width:70% !important;'>
            </h2>
        </div>

        <div class="suggest-box">
            <div class="data-box">
                <img src="images/Jiliar.png" class="avatar">
                <div class="ml-4 avatar-title flex-column">
                    <a href="#" class="d-block fg-white text-medium no-decor"><span class="reduce-1">Jiliar Silgado</span></a>
                    <p class="m-0"><span class="fg-green mr-2">&#x25cf;</span><span class="text-small">online</span></p>
                </div>
            </div>
            <img src="images/Jiliar.png" class="avatar holder ml-2">
        </div>

        <div class="suggest-box">
            <input type="text" data-role="input" data-clear-button="false" data-search-button="true">
            <button class="holder">
                <span class="mif-search fg-white"></span>
            </button>
        </div>

        <ul class="navview-menu mt-4" id="side-menu">
            <li class="item-header">NAVEGACIÓN DEL SITIO</li>
            <!--<li>
                <a href="#dashboard">
                    <span class="icon"><span class="mif-meter"></span></span>
                    <span class="caption">Dashboard</span>
                </a>
            </li>-->
            <li>
                <a href="#widgets">
                    <span class="icon"><span class="mif-widgets"></span></span>
                    <span class="caption">Información General</span>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-versions"></span></span>
                    <span class="caption">Convocatorias</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown">
                    <li class="item-header">Pages</li>
                    <li><a href="login.html">
                        <span class="icon"><span class="mif-lock"></span></span>
                        <span class="caption">Login</span>
                    </a></li>
                    <li><a href="register.html">
                        <span class="icon"><span class="mif-user-plus"></span></span>
                        <span class="caption">Register</span>
                    </a></li>
                    <li><a href="lockscreen.html">
                        <span class="icon"><span class="mif-key"></span></span>
                        <span class="caption">Lock screen</span>
                    </a></li>
                    <li><a href="#profile">
                        <span class="icon"><span class="mif-profile"></span></span>
                        <span class="caption">Profile</span>
                    </a></li>
                    <li><a href="preloader.html">
                        <span class="icon"><span class="mif-spinner"></span></span>
                        <span class="caption">Preloader</span>
                    </a></li>
                    <li><a href="404.html">
                        <span class="icon"><span class="mif-cancel"></span></span>
                        <span class="caption">404 Page</span>
                    </a></li>
                    <li><a href="500.html">
                        <span class="icon"><span class="mif-warning"></span></span>
                        <span class="caption">500 Page</span>
                    </a></li>
                    <li><a href="#product-list">
                        <span class="icon"><span class="mif-featured-play-list"></span></span>
                        <span class="caption">Product list</span>
                    </a></li>
                    <li><a href="#product">
                        <span class="icon"><span class="mif-rocket"></span></span>
                        <span class="caption">Product page</span>
                    </a></li>
                    <li><a href="#invoice">
                        <span class="icon"><span class="mif-open-book"></span></span>
                        <span class="caption">Invoice</span>
                    </a></li>
                    <li><a href="#orders">
                        <span class="icon"><span class="mif-table"></span></span>
                        <span class="caption">Orders</span>
                    </a></li>
                    <li><a href="#order-details">
                        <span class="icon"><span class="mif-library"></span></span>
                        <span class="caption">Order details</span>
                    </a></li>
                    <li><a href="#price-table">
                        <span class="icon"><span class="mif-table"></span></span>
                        <span class="caption">Price table</span>
                    </a></li>
                    <li><a href="maintenance.html">
                        <span class="icon"><span class="mif-cogs"></span></span>
                        <span class="caption">Maintenance</span>
                    </a></li>
                    <li><a href="coming-soon.html">
                        <span class="icon"><span class="mif-watch"></span></span>
                        <span class="caption">Coming soon</span>
                    </a></li>
                    <li>
                        <a href="help-center.html">
                            <span class="icon"><span class="mif-help"></span></span>
                            <span class="caption">Help center</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-devices"></span></span>
                    <span class="caption">Inscripciones</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown" >
                    <li class="item-header">Forms</li>
                    <li><a href="#forms-basic">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Basic elements</span>
                    </a></li>
                    <li><a href="#forms-extended">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Extended elements</span>
                    </a></li>
                    <li><a href="#forms-layouts">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Layouts</span>
                    </a></li>
                    <li><a href="#forms-validating">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Validating</span>
                    </a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-table"></span></span>
                    <span class="caption">Becados</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown" >
                    <li class="item-header">Tables</li>
                    <li><a href="#table-classes">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Table classes</span>
                    </a></li>
                    <li><a href="#table-component">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Table component</span>
                    </a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-air"></span></span>
                    <span class="caption">Egresados</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown">
                    <li class="item-header">UI Elements</li>
                    <li>
                        <a href="#colors">
                            <span class="icon"><span class="mif-paint"></span></span>
                            <span class="caption">Colors</span>
                        </a>
                    </li>
                    <li><a href="#typography">
                        <span class="icon"><span class="mif-bold"></span></span>
                        <span class="caption">Typography</span>
                    </a></li>
                    <li><a href="#buttons">
                        <span class="icon"><span class="mif-apps"></span></span>
                        <span class="caption">Buttons</span>
                    </a></li>
                    <li><a href="#tabs">
                        <span class="icon"><span class="mif-open-book"></span></span>
                        <span class="caption">Accordion &amp; Tabs</span>
                    </a></li>
                    <li><a href="#tiles">
                        <span class="icon"><span class="mif-dashboard"></span></span>
                        <span class="caption">Tiles</span>
                    </a></li>
                    <li><a href="#treeview">
                        <span class="icon"><span class="mif-tree"></span></span>
                        <span class="caption">TreeView</span>
                    </a></li>
                    <li><a href="#listview">
                        <span class="icon"><span class="mif-list"></span></span>
                        <span class="caption">ListView</span>
                    </a></li>
                    <li><a href="#progress">
                        <span class="icon"><span class="mif-spinner5"></span></span>
                        <span class="caption">Progress & activities</span>
                    </a></li>
                    <li><a href="#list">
                        <span class="icon"><span class="mif-list2"></span></span>
                        <span class="caption">List component</span>
                    </a></li>
                    <li><a href="#splitter">
                        <span class="icon"><span class="mif-table"></span></span>
                        <span class="caption">Splitter</span>
                    </a></li>
                    <li><a href="#calendar">
                        <span class="icon"><span class="mif-calendar"></span></span>
                        <span class="caption">Calendar</span>
                    </a></li>
                    <li><a href="#countdown">
                        <span class="icon"><span class="mif-watch"></span></span>
                        <span class="caption">Countdown</span>
                    </a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-play"></span></span>
                    <span class="caption">Galeria</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown" >
                    <li class="item-header">Media</li>
                    <li><a href="#video">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Video player</span>
                    </a></li>
                    <li><a href="#audio">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Audio</span>
                    </a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <span class="icon"><span class="mif-comment"></span></span>
                    <span class="caption">Inserción Laboral</span>
                </a>
                <ul class="navview-menu stay-open" data-role="dropdown" >
                    <li class="item-header">Information</li>
                    <li><a href="#windows">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Windows</span>
                    </a></li>
                    <li><a href="#dialogs">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Dialogs</span>
                    </a></li>
                    <li><a href="#info-boxes">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">InfoBox</span>
                    </a></li>
                    <li><a href="#hints">
                        <span class="icon"><span class="mif-spinner2"></span></span>
                        <span class="caption">Hints</span>
                    </a></li>
                </ul>
            </li>


            <li class="item-header">CONFIGURACIONES</li>
            <li>
                <a href="https://metroui.org.ua/intro.html">
                    <span class="icon"><span class="mif-brightness-auto fg-red"></span></span>
                    <span class="caption">Usuarios</span>
                </a>
            </li>
            <li>
                <a href="https://metroui.org.ua/intro.html">
                    <span class="icon"><span class="mif-brightness-auto fg-red"></span></span>
                    <span class="caption">Roles</span>
                </a>
            </li>
        </ul>

        <div class="w-100 text-center text-small data-box p-2 border-top bd-grayMouse" style="position: absolute; bottom: 0">
            <div>&copy; 2021 <a href="mailto:sergey@pimenov.com.ua" class="text-muted fg-white-hover no-decor">Traso Colectivo</a></div>
        </div>
    </div>

    <div class="navview-content h-100">
        <div data-role="appbar" class="pos-absolute bg-darkPurple fg-white">

            <a href="#" class="app-bar-item d-block d-none-lg" id="paneToggle"><span class="mif-menu"></span></a>

            <div class="app-bar-container ml-auto">
                <a href="#" class="app-bar-item">
                    <span class="mif-envelop"></span>
                    <span class="badge bg-green fg-white mt-2 mr-1">4</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-bell"></span>
                    <span class="badge bg-orange fg-white mt-2 mr-1">10</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-flag"></span>
                    <span class="badge bg-red fg-white mt-2 mr-1">9</span>
                </a>
                <div class="app-bar-container">
                    <a href="#" class="app-bar-item">
                        <img src="images/Jiliar.png" class="avatar">
                        <span class="ml-2 app-bar-name">Jiliar Silgado</span>
                    </a>
                    <div class="user-block shadow-1" data-role="collapse" data-collapsed="true">
                        <div class="bg-darkPurple fg-white p-2 text-center">
                            <img src="images/Jiliar.png" class="avatar">
                            <div class="h4 mb-0">Jiliar Silgado</div>
                            <div>Ing. de Software</div>
                        </div>
                        <div class="bg-white d-flex flex-justify-between flex-equal-items p-2">
                            <button class="button flat-button">Followers</button>
                            <button class="button flat-button">Sales</button>
                            <button class="button flat-button">Friends</button>
                        </div>
                        <div class="bg-white d-flex flex-justify-between flex-equal-items p-2 bg-light">
                            <button class="button mr-1">Profile</button>
                            <button class="button ml-1">Sign out</button>
                        </div>
                    </div>
                </div>
                <a href="#" class="app-bar-item">
                    <span class="mif-cogs"></span>
                </a>
            </div>
        </div>

        <div id="content-wrapper" class="content-inner h-100" style="overflow-y: auto">
            @yield('contenido')
        </div>
    </div>
</div>


<!-- jQuery first, then Metro UI JS -->
<script src="vendors/jquery/jquery-3.4.1.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js' integrity='sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="vendors/chartjs/Chart.bundle.min.js"></script>
<script src="vendors/qrcode/qrcode.min.js"></script>
<script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
<script src="vendors/metro4/js/metro.js"></script>
<script src="js/index.js"></script>
</body>
</html>
