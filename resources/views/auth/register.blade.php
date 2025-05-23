@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center justify-content-xxl-center ps-xxl-0 pe-xxl-0 ms-xxl-0 me-xxl-0 pt-xxl-0"
    style="min-height: 66.3vh;">
    <div class="row d-flex justify-content-center ms-xxl-0 me-xxl-0 pe-xxl-3 ps-xxl-3 pt-xxl-3 pb-xxl-3"
        style="font-size: 15px;">
        <div class="col-md-6 col-xl-4 ps-xxl-0 pe-xxl-0">
            <div class="card mb-5 mb-xxl-0">
                <div class="card-body ms-xxl-0 pt-xxl-2 pb-xxl-2 ps-xxl-2 pe-xxl-2 ps-2 pe-2 pt-2 pb-2"
                    style="background: var(--bs-success);border-radius: 25px;">
                    <h1 class="text-uppercase mb-xxl-0 mb-0" style="text-align: center;color: var(--bs-light);">
                        Регистрация</h1>
                    <form class="text-center pt-xxl-4 pb-xxl-3 ps-xxl-1 pe-xxl-1" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="d-flex flex-column mb-3 mb-xxl-2">
                            <span class="text-start pb-xxl-2" style="color: var(--bs-light);font-size: 15px;">Введите имя и фамилию:</span>
                            <div class="d-flex">
                                <input class="form-control pt-xxl-3 pb-xxl-3 me-1 @error('first_name') is-invalid @enderror"
                                       type="text"
                                       name="first_name"
                                       value="{{ old('first_name') }}"
                                       placeholder="Вадим"
                                       style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                                <input class="form-control pt-xxl-3 pb-xxl-3 ms-1 @error('last_name') is-invalid @enderror"
                                       type="text"
                                       name="last_name"
                                       value="{{ old('last_name') }}"
                                       placeholder="Достовалов"
                                       style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                            </div>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-3 mb-xxl-2">
                            <span class="text-start pb-xxl-2" style="color: var(--bs-light);font-size: 15px;">Введите номер телефона:</span>
                            <div class="d-flex align-items-center">
                                <span class="text-light me-2" style="font-size: 15px;">+7</span>
                                <input class="form-control pt-xxl-3 pb-xxl-3 @error('phone') is-invalid @enderror"
                                       type="tel"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="9999999999"
                                       maxlength="10"
                                       pattern="[0-9]{10}"
                                       style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                            </div>
                            @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>Введите 10 цифр номера телефона без +7</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex flex-column mb-3 mb-xxl-2">
                            <span class="text-start pb-xxl-2" style="color: var(--bs-light);font-size: 15px;">Введите почту:</span>
                            <input class="form-control pt-xxl-3 pb-xxl-3 @error('email') is-invalid @enderror"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="example@email.com"
                                   style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex d-xxl-flex flex-column justify-content-xxl-start mb-3 mb-xxl-2">
                            <span class="text-start pb-xxl-2" style="color: var(--bs-light);font-size: 15px;">Введите пароль:</span>
                            <input class="form-control pt-xxl-3 pb-xxl-3 @error('password') is-invalid @enderror"
                                   type="password"
                                   name="password"
                                   placeholder="*************"
                                   style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex d-xxl-flex flex-column justify-content-xxl-start mb-4 mb-xxl-4">
                            <span class="text-start pb-xxl-2" style="color: var(--bs-light);font-size: 15px;">Повторите пароль:</span>
                            <input class="form-control pt-xxl-3 pb-xxl-3"
                                   type="password"
                                   name="password_confirmation"
                                   placeholder="*************"
                                   style="background: var(--bs-light);border-style: none;border-radius: 15px;">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary text-uppercase d-block w-100 ps-xxl-5 pe-xxl-5 pt-xxl-3 pb-xxl-3"
                                    type="submit"
                                    style="background: var(--bs-info);border-style: none;font-size: 16px;border-radius: 15px;">
                                принять
                            </button>
                        </div>
                        <p class="text-light mt-3">
                            Уже есть аккаунт? <a href="{{ route('login') }}" class="text-light text-decoration-none">Войти</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
