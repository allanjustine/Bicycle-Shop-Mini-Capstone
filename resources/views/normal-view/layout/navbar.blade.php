<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="bi-bicycle fs-1"></i> Bicycle Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Bikes</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/request-order">My Request</a>
                    </li>
                    @role('Admin')
                        <li class="nav-item"><a class="nav-link" href="/admin/dashboard"><i class="far fa-arrow-up"></i>
                                Admin Page</a>
                        </li>
                    @endrole

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">
                            {{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/logout">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/register">Register</a>
                    </li>

                @endauth
            </ul>

        </div>
    </div>
</nav>
