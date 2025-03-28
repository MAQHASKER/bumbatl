<div class="col-md-12 col-xxl-12 pb-xxl-0 ps-xxl-3 pe-xxl-0 pt-xxl-0 profile-section d-none" data-section="settings">
    <div class="card d-flex align-items-center mb-0" style="border-style: none;">
        <div class="position-relative">
            <div class="bs-icon-xl bs-icon-circle bs-icon-primary d-xxl-flex align-items-xxl-center bs-icon my-4 mb-2 mt-2 me-3 ms-3 ms-xxl-0 me-xxl-3 overflow-hidden"
                style="background: var(--bs-success);">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Аватар"
                        class="w-100 h-100 object-fit-cover">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                        class="bi bi-person">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z">
                        </path>
                    </svg>
                @endif
            </div>
            <button type="button"
                class="btn btn-link position-absolute d-flex align-items-center justify-content-center"
                style="bottom: 0; right: 0; padding: 0; background: var(--bs-success); border-radius: 50%; width: 24px; height: 24px;"
                onclick="document.getElementById('avatar-input').click();">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="bi bi-pencil-square"
                    viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 13.5 1h-11A1.5 1.5 0 0 0 1 2.5v11zm1.5-.5a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-11z" />
                </svg>
            </button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST"
            class="card-body pt-0 pb-0 ps-0 pe-0 pt-xxl-0 pb-xxl-0 ps-xxl-0 pe-xxl-0 w-100"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="active_section" value="{{ request()->query('section', 'settings') }}">

            <input type="file" id="avatar-input" name="avatar" accept="image/*" class="d-none"
                onchange="previewAvatar(this);">

            <!-- Имя и фамилия -->
            <div class="mb-4">
                <div class="d-flex align-items-center">
                    <span class="d-xxl-flex justify-content-xxl-start pt-1 pb-1 pt-xxl-0"
                        style="color: var(--bs-secondary);font-size: 13px;">Имя и фамилия</span>
                    <button type="button" class="btn btn-link p-0 ms-2 edit-toggle" data-fields="name-fields">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 13.5 1h-11A1.5 1.5 0 0 0 1 2.5v11zm1.5-.5a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-11z" />
                        </svg>
                    </button>
                </div>
                <div class="d-flex flex-row align-items-xxl-center name-fields" style="opacity: 0.7;">
                    <input class="form-control me-2" type="text" name="first_name"
                        value="{{ auth()->user()->first_name }}" placeholder="Имя"
                        style="background: var(--bs-light);border-style: none;" disabled>
                    <input class="form-control ms-2" type="text" name="last_name"
                        value="{{ auth()->user()->last_name }}" placeholder="Фамилия"
                        style="background: var(--bs-light);border-style: none;" disabled>
                </div>
            </div>

            <!-- Телефон -->
            <div class="mb-4">
                <span class="d-xxl-flex justify-content-xxl-start pt-1 pb-1 pt-xxl-0"
                    style="color: var(--bs-secondary);font-size: 13px;">Номер телефона</span>
                <div class="d-flex flex-row align-items-xxl-center">
                    <input class="form-control" type="tel" value="{{ auth()->user()->phone }}"
                        style="background: var(--bs-light);border-style: none;opacity: 0.7;" disabled>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <div class="d-flex align-items-center">
                    <span class="d-xxl-flex justify-content-xxl-start pt-1 pb-1 pt-xxl-0"
                        style="color: var(--bs-secondary);font-size: 13px;">Почта</span>
                    <button type="button" class="btn btn-link p-0 ms-2 edit-toggle" data-fields="email-fields">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 13.5 1h-11A1.5 1.5 0 0 0 1 2.5v11zm1.5-.5a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-11z" />
                        </svg>
                    </button>
                </div>
                <div class="d-flex flex-row align-items-xxl-center email-fields" style="opacity: 0.7;">
                    <input class="form-control" type="email" name="email" value="{{ auth()->user()->email }}"
                        placeholder="example@email.com" style="background: var(--bs-light);border-style: none;"
                        disabled>
                </div>
            </div>

            <!-- Пароль -->
            <div class="mb-4">
                <div class="d-flex align-items-center">
                    <span class="d-xxl-flex justify-content-xxl-start pt-1 pb-1 pt-xxl-0"
                        style="color: var(--bs-secondary);font-size: 13px;">Изменить пароль</span>
                    <button type="button" class="btn btn-link p-0 ms-2 edit-toggle" data-fields="password-fields">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 13.5 1h-11A1.5 1.5 0 0 0 1 2.5v11zm1.5-.5a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-11z" />
                        </svg>
                    </button>
                </div>
                <div class="d-flex flex-column password-fields" style="opacity: 0.7;">
                    <input class="form-control mb-2" type="password" name="current_password"
                        placeholder="Текущий пароль" style="background: var(--bs-light);border-style: none;" disabled>
                    <input class="form-control mb-2" type="password" name="password" placeholder="Новый пароль"
                        style="background: var(--bs-light);border-style: none;" disabled>
                    <input class="form-control" type="password" name="password_confirmation"
                        placeholder="Подтвердите новый пароль" style="background: var(--bs-light);border-style: none;"
                        disabled>
                </div>
            </div>

            <div class="mb-0">
                <button class="btn btn-primary d-block w-100" type="submit"
                    style="background: var(--bs-success);border-style: none;">
                    Сохранить изменения
                </button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mt-3 fade show d-flex justify-content-between align-items-center"
                    id="successAlert">
                    <div>
                        {{ session('success') }}
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-success ms-3" id="profileUndoButton">
                            Отменить изменения
                        </button>
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
