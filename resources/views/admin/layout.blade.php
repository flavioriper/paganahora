<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Painel de administração do Raspadinha Premiada">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="/adminAsset/images/favicon_1.ico">

    <title>Painel do Administrador</title>

    <!-- Developer www.agencianaweb.com.br -->
    <meta http-equiv="Content-Language" content="pt-br">
    <meta name="document-classification" content="Site Institucional">
    <meta name="REVISIT-AGENCIANAWEB" content="1 days">
    <meta name="LANGUAGE" content="Portuguese">
    <meta name="COPYRIGHT" content="www.agencianaweb.com.br">
    <meta name="robots" content="all"/>
    <meta name="googlebot" content="all"/>
    <meta name="audience" content="all">
    <meta name="copyright" content="Copyright (c) AgÃªncia na Web. Todos os Direitos Reservados.">

    <link rel="stylesheet" href="/adminAsset/plugins/morris/morris.css">

    <link href="/adminAsset/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="/adminAsset/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
    <link href="/adminAsset/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
    <link href="/adminAsset/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" /> 
    <link href="/adminAsset/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/adminAsset/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

    <link href="/adminAsset/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/css/core.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/css/pages.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/adminAsset/js/modernizr.min.js"></script>


    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="/adminAsset//js/jquery.min.js"></script>
    <script src="/adminAsset//js/bootstrap.min.js"></script>
    <script src="/adminAsset//js/detect.js"></script>
    <script src="/adminAsset//js/fastclick.js"></script>
    <script src="/adminAsset//js/jquery.slimscroll.js"></script>
    <script src="/adminAsset//js/jquery.blockUI.js"></script>
    <script src="/adminAsset//js/waves.js"></script>
    <script src="/adminAsset//js/wow.min.js"></script>
    <script src="/adminAsset//js/jquery.nicescroll.js"></script>
    <script src="/adminAsset//js/jquery.scrollTo.min.js"></script>
    <script src="/adminAsset//plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
    <script src="/adminAsset//plugins/switchery/js/switchery.min.js"></script>
    <script type="text/javascript" src="/adminAsset//plugins/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/adminAsset//plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script src="/adminAsset//plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="/adminAsset//plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/adminAsset//plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script src="/adminAsset//plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="/adminAsset//plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="/adminAsset/plugins/morris/morris.min.js"></script>
    <script src="/adminAsset/plugins/raphael/raphael-min.js"></script>
    <script src="/adminAsset/plugins/jquery-knob/jquery.knob.js"></script>
    <script src="/adminAsset/pages/jquery.dashboard.js"></script>
    <!-- <script type="text/javascript" src="/adminAsset//plugins/autocomplete/jquery.mockjax.js"></script> -->
    <!-- <script type="text/javascript" src="/adminAsset//plugins/autocomplete/jquery.autocomplete.min.js"></script> -->
    <!-- <script type="text/javascript" src="/adminAsset//plugins/autocomplete/countries.js"></script> -->
    <!-- <script type="text/javascript" src="/adminAsset//pages/autocomplete.js"></script> -->
    <script type="text/javascript" src="/adminAsset//pages/jquery.form-advanced.init.js"></script>

    <script src="/adminAsset//js/jquery.core.js"></script>
    <script src="/adminAsset//js/jquery.app.js"></script>
</head>


<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <a href="/admin" class="logo"><i class="icon-magnet icon-c-logo"></i><span><img border="0" src="https://www.agencianaweb.com.br/www.agencianaweb.com-painel-branco-pp.png"></span></a>
            </div>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">
                    <div class="pull-left">
                        <button class="button-menu-mobile open-left waves-effect waves-light">
                            <i class="md md-menu"></i>
                        </button>
                        <span class="clearfix"></span>
                    </div>

                    <ul class="nav navbar-nav navbar-right pull-right">
                        <li class="dropdown top-menu-item-xs">
                            <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                               aria-expanded="true"><img src="{{Auth::user()->avatar}}" alt="user-img"
                                                         class="img-circle"> </a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->

    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <!--- Divider -->
            <div id="sidebar-menu">
                <ul>

                    <li class="text-muted menu-title">Navegação</li>

                    <li class="has_sub">
                        <a href="/admin" class="waves-effect"><i class="ti-home"></i> <span> Estatisticas </span> <span class="menu-arrow"></span></a>
                    </li>
                    <li class="has_sub">
                        <a href="/admin/settings" class="waves-effect"><i class="ti-light-bulb"></i><span> Configurações </span> <span class="menu-arrow"></span></a>
                    </li>
                    <li class="has_sub">
                        <a class="waves-effect">
                            <i class="ti-credit-card"></i>
                            <span> Pagamentos </span> 
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li>
                                <a href="/admin/payments/tefway" class="waves-effect">
                                    <span> Tefway ( PIX )</span> 
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has_sub ms-hover">
                        <a href="/admin/users" class="waves-effect"><i class="ti-spray"></i> <span> Lista de Usuários </span> </a>
                    </li>
                    <li class="has_sub ms-hover">
                        <a href="/admin/lastOpen" class="waves-effect"><i class="ti-spray"></i> <span> Histórico de Apostas </span> </a>
                    </li>
                    <li class="has_sub ms-hover">
						@php
						$count = \DB::table('withdraw')->where('status', 0)->count();
						@endphp
                        <a href="/admin/lastWithdraw" class="waves-effect"><i class="ti-spray"></i> <span>Pedidos de Saque </span> @if($count > 0) <span class="label label-primary pull-right">{{$count}}</span> @endif </a>
                    </li>
                    <li class="has_sub ms-hover">
                        <a href="/admin/lastOrders" class="waves-effect"><i class="ti-spray"></i> <span> Últimos Depósitos </span> </a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
@yield('content')
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->
<div style="display:none;"><a href="https://www.agencianaweb.com.br">Agencia na Web</a></div>
@stack('js')
</body>
</html>