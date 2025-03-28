<div class="col-md-12 col-xxl-12 justify-content-sm-center pb-xxl-0 ps-xxl-3 pe-xxl-0 pt-xxl-0 pt-4 pb-4 profile-section d-none" data-section="team">
    <!-- Уведомление об успешном создании команды -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Уведомление о приглашении в команду -->
    @if($pendingInvite)
        <div class="alert alert-info">
            <h5>У вас есть приглашение в команду!</h5>
            <p>Вас пригласили присоединиться к команде "{{ $pendingInvite->team->name }}"</p>
            <p>Приглашение от: {{ $pendingInvite->inviter->first_name }} {{ $pendingInvite->inviter->last_name }}</p>
            <form action="{{ route('team.invite.accept', $pendingInvite->uid) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-success me-2">
                    Присоединиться к команде
                </button>
                <a href="{{ route('team.invite.reject', $pendingInvite->uid) }}" class="btn btn-danger">
                    Отклонить приглашение
                </a>
            </form>
        </div>
    @elseif(!isset($user->team))
        <!-- Кнопка создания команды только если нет команды и нет приглашения -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createTeamModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-plus-circle me-2">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Создать свою команду
            </button>
        </div>
    @elseif($user->team->captain_id === $user->id)
        <!-- Кнопки управления для капитана команды -->
        <div class="text-center mb-4">
            <form action="{{ route('team.destroy', $user->team->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Вы уверены, что хотите удалить команду? Это действие нельзя отменить.')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-trash me-2">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                    Удалить команду
                </button>
            </form>
        </div>

        <!-- Форма приглашения участников -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Пригласить участника</h5>
                <form action="{{ route('team.invite') }}" method="POST">
                    @csrf
                    <input type="hidden" name="team_id" value="{{ $user->team->id }}">
                    <div class="mb-3">
                        <label for="inviteEmail" class="form-label">Email участника</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="inviteEmail" name="email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person-plus me-2">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        Отправить приглашение
                    </button>
                </form>
            </div>
        </div>
    @endif

    <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3 mt-xxl-0 ms-xxl-0 me-xxl-0 mt-0 ms-0 me-0">
        <!-- Информация о команде -->
        <div class="col mt-xxl-0 ps-xxl-0 pe-xxl-0">
            <div class="text-center d-flex flex-column align-items-center align-items-xl-center pt-xxl-0 pb-xxl-0">
                <div class="bs-icon-lg bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 bs-icon lg mb-xxl-2 ms-xxl-2 me-xxl-2 mt-xxl-0"
                    style="background: var(--bs-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-people-fill" style="color: var(--bs-light);">
                        <path d="M7 14s-1 0-1-1 1-4 4-4 4 3 4 4-1 1-1 1zm3-4a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 4 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                    </svg>
                </div>
                <div class="px-3 pt-xxl-3 pb-xxl-0">
                    <h1 class="mb-xxl-0 pt-xxl-3 pb-xxl-3">{{ $user->team->name ?? 'Нет команды' }}</h1>
                    <p class="text-uppercase mb-xxl-0" style="font-weight: bold;">Название команды</p>
                </div>
            </div>
        </div>

        <!-- Статистика команды -->
        <div class="col mt-xxl-0 ps-xxl-0 pe-xxl-0">
            <div class="text-center d-flex flex-column align-items-center align-items-xl-center pt-xxl-0 pb-xxl-0">
                <div class="bs-icon-lg bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 bs-icon lg mb-xxl-2 ms-xxl-2 me-xxl-2 mt-xxl-0"
                    style="background: var(--bs-success);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-trophy-fill" style="color: var(--bs-light);">
                        <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.9 3.023 5.003 5.003 0 0 1-4.132 4.132 3 3 0 1 1-1.9-3.023 4.979 4.979 0 0 1-1.51-3.228A5.033 5.033 0 0 1 2.5.5M4 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4m2.5 2a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m7 0a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1M12 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                    </svg>
                </div>
                <div class="px-3 pt-xxl-3 pb-xxl-0">
                    <h1 class="mb-xxl-0 pt-xxl-3 pb-xxl-3">{{ $user->team->total_weight ?? 0 }} кг</h1>
                    <p class="text-uppercase mb-xxl-0" style="font-weight: bold;">Всего сдано</p>
                </div>
            </div>
        </div>

        <!-- Место в рейтинге -->
        <div class="col mt-xxl-0 ps-xxl-0 pe-xxl-0">
            <div class="text-center d-flex flex-column align-items-center align-items-xl-center pt-xxl-0 pb-xxl-0">
                <div class="bs-icon-lg bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 bs-icon lg mb-xxl-2 ms-xxl-2 me-xxl-2 mt-xxl-0"
                    style="background: var(--bs-warning);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-flag-fill" style="color: var(--bs-light);">
                        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 1 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c7 0 4 6 4 6s-3 0-4-6c0 0 3-6 4-6z"/>
                    </svg>
                </div>
                <div class="px-3 pt-xxl-3 pb-xxl-0">
                    <h1 class="mb-xxl-0 pt-xxl-3 pb-xxl-3">#{{ $user->team->rank ?? '?' }}</h1>
                    <p class="text-uppercase mb-xxl-0" style="font-weight: bold;">Место в рейтинге</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Список участников команды -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Участники команды</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Участник</th>
                            <th>Роль</th>
                            <th>Сдано</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($user->team) && $user->team->members)
                            @foreach($user->team->members as $member)
                                <tr>
                                    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                                    <td>
                                        @if($member->id === $user->team->captain_id)
                                            <span class="badge bg-primary">Капитан</span>
                                        @else
                                            <span class="badge bg-secondary">Участник</span>
                                        @endif
                                    </td>
                                    <td>{{ $member->total_weight ?? 0 }} кг</td>
                                    <td>
                                        @if($member->is_active)
                                            <span class="badge bg-success">Активен</span>
                                        @else
                                            <span class="badge bg-warning">Неактивен</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">У вас пока нет команды</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('pages.profile.components.create-team-modal')

@push('scripts')
<script>
    // Автоматически скрываем уведомление через 5 секунд
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });
</script>
@endpush
