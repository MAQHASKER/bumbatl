<div class="container d-flex flex-column pb-xxl-3 ps-xxl-3 pe-xxl-4 pt-xxl-4" style="min-height: 66.3vh;">
    <div class="row d-flex flex-row ms-xxl-0 me-xxl-0 ms-md-0 me-md-0">
        @include('pages.profile.components.navigation')
        <div class="col-md-12 col-xxl-8 ps-xxl-0 pe-xxl-0 pt-xxl-3 pb-xxl-3">
            <div class="row d-flex flex-column ms-xxl-0 me-xxl-0 pe-xxl-0 pt-xxl-0 pb-xxl-0 me-md-1 ms-md-0 ms-0 me-0">

                <!-- личный кабинет -->
                <!-- Вот сюда нужно импортировать личный кабинет -->
                @include('pages.profile.components.main')

                <!-- редактирование профиля -->
                <!-- вот сюда нужно импортировать редактирование профиля -->
                @include('pages.profile.components.settings')

                <!-- команда -->
                <!-- Вот сюда нужно импортировать команду -->
                @include('pages.profile.components.team')

                <!-- статистика сдачи макулатуры -->
                <!-- Вот сюда нужно импортировать статистику сдачи макулатуры -->
                @include('pages.profile.components.stats')

            </div>
        </div>
    </div>
</div>