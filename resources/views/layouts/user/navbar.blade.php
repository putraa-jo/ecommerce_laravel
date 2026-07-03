<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navabr-light main_box">
            <div class="container">
                <a class="navbar-brand logo_h" href="index.html"><img src="{{ asset('assets/templates/user/img/logo.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupporetdContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="{{ route('user.dashboard') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}#flash-sale">⚡ Flash Sale</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.history', Auth::user()->id) }}">History</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>