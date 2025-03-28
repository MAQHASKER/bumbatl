<div class="container-fluid pb-0 pe-0 ps-0 mt-xxl-0 pt-xxl-0 pt-0" style="z-index: 1000;padding: 0px;">
    <div class="row ms-0 me-0">
        <div class="col-xxl-12 offset-xxl-0 ps-0 pe-0"
            style="position: relative;background: var(--bs-success);border-style: none;">
            <nav
                class="navbar navbar-expand-md d-flex d-md-flex flex-column align-items-md-center justify-content-xxl-center py-3 pt-2 pb-2 ps-2 pe-2 ms-sm-0 me-xxl-0 ps-xxl-0 pe-xxl-0 pt-xxl-0 pb-xxl-0 ms-0 me-0">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center me-0 pt-0 pb-0" href="{{ url('/') }}">
                        <span class="pt-xxl-2 pb-xxl-2 pe-xxl-2 ps-xxl-2 pb-2 pe-1 ps-1 pt-2">
                            <span style="color: rgb(255, 255, 255);">Кванториум&amp;Бумбатл</span>
                        </span>
                    </a>
                    <button data-bs-toggle="collapse" class="navbar-toggler ps-1 pe-1 pt-1 pb-1"
                        data-bs-target="#navcol-1">
                        <span class="visually-hidden">Toggle navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse pt-xxl-2 pb-xxl-2 pe-xxl-0 ps-xxl-0" id="navcol-1">
                        <ul class="navbar-nav ms-auto"></ul>
                        <a class="btn btn-primary ms-md-2 ms-xxl-0 pt-1 pb-1 mt-1 mb-1 ms-1 me-1 pb-xxl-2 pt-xxl-2 ps-xxl-4 pe-xxl-4 pe-4 ps-4"
                            role="button" href="{{ Auth::check() ? route('profile.index') : route('login') }}"
                            style="background: var(--bs-info);border-style: none;">
                            {{ Auth::check() ? Auth::user()->full_name : 'Личный кабинет' }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>