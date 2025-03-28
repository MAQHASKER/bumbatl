@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center justify-content-xxl-center ps-xxl-0 pe-xxl-0 ms-xxl-0 me-xxl-0 pt-xxl-0"
    style="min-height: 66.3vh;">
    <div class="row d-flex justify-content-center ms-xxl-0 me-xxl-0 pe-xxl-3 ps-xxl-3 pt-xxl-3 pb-xxl-3"
        style="font-size: 15px;">
        <div class="col-md-6 col-xl-4 ps-xxl-0 pe-xxl-0">
            <div class="card mb-xxl-0 mb-0">
                <div class="card-body ms-xxl-0 pt-xxl-2 pb-xxl-2 ps-xxl-2 pe-xxl-2 ps-2 pe-2 pt-2 pb-2"
                    style="background: var(--bs-success);border-radius: 25px;">
                    <h1 class="text-uppercase mb-xxl-0 mb-0" style="text-align: center;color: var(--bs-light);">Вход
                    </h1>
                    <form class="text-center pt-xxl-4 pb-xxl-3 pe-xxl-1 ps-xxl-1" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="d-flex flex-column mb-3">
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
                        <div class="d-flex d-xxl-flex flex-column justify-content-xxl-start mb-3">
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
                        <div class="mb-3">
                            <button class="btn btn-primary text-uppercase d-block w-100 ps-xxl-5 pe-xxl-5 pt-xxl-3 pb-xxl-3"
                                    type="submit"
                                    style="background: var(--bs-info);border-style: none;font-size: 16px;border-radius: 15px;">
                                принять
                            </button>
                        </div>
                        <p class="text-light mt-3">
                            Нет аккаунта? <a href="{{ route('register') }}" class="text-light text-decoration-none">Зарегистрироваться</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
