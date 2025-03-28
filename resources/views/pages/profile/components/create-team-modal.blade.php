<!-- Модальное окно создания команды -->
<div class="modal fade" id="createTeamModal" tabindex="-1" aria-labelledby="createTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTeamModalLabel">Создание новой команды</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('team.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Вывод ошибок валидации -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <div class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-exclamation-triangle-fill me-2">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                                <h6 class="mb-0">Пожалуйста, исправьте следующие ошибки:</h6>
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="createTeamName" class="form-label">Название команды</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="createTeamName" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="createTeamDescription" class="form-label">Описание команды</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="createTeamDescription" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="createTeamMaxMembers" class="form-label">Максимальное количество участников</label>
                        <input type="number" class="form-control @error('max_members') is-invalid @enderror"
                               id="createTeamMaxMembers" name="max_members" min="2" max="10"
                               value="{{ old('max_members', 5) }}" required>
                        @error('max_members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Создать команду</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Автоматически открываем модальное окно, если есть ошибки
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('createTeamModal'));
            modal.show();
        });
    @endif
</script>
@endpush
