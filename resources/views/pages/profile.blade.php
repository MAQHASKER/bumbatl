@extends('layouts.app')

@section('content')



    <!-- Вот сюда нужно импрортировать навигацию -->
    @include('pages.profile.components.navigation-wrapper')




    <!-- Уведомление об успешном обновлении -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successNotification" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Профиль успешно обновлен
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
            </div>
            <div class="mt-2 text-center">
                <button type="button" class="btn btn-sm btn-light" id="profileUndoButton">Отменить изменения</button>
            </div>
        </div>
    </div>

    <!-- Модальное окно создания команды -->
    @include('pages.profile.components.create-team-modal')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navLinks = document.querySelectorAll('.profile-nav');
                const sections = document.querySelectorAll('.profile-section');

                // Получаем активную вкладку из URL
                const urlParams = new URLSearchParams(window.location.search);
                const activeSection = urlParams.get('section') || 'main';

                // Скрываем все секции
                sections.forEach(section => {
                    section.classList.add('d-none');
                });

                // Показываем активную секцию
                const activeElement = document.querySelector(`.profile-section[data-section="${activeSection}"]`);
                if (activeElement) {
                    activeElement.classList.remove('d-none');
                }

                // Устанавливаем активную ссылку
                const activeLink = document.querySelector(`.profile-nav[data-section="${activeSection}"]`);
                if (activeLink) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    activeLink.classList.add('active');
                }

                navLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                        const targetSection = this.getAttribute('data-section');

                        // Обновляем URL с новой активной вкладкой
                        const url = new URL(window.location);
                        url.searchParams.set('section', targetSection);
                        window.history.pushState({}, '', url);

                        sections.forEach(section => {
                            section.classList.add('d-none');
                        });
                        const sectionToShow = document.querySelector(`.profile-section[data-section="${targetSection}"]`);
                        if (sectionToShow) {
                            sectionToShow.classList.remove('d-none');
                        }
                    });
                });

                // Код для управления редактированием полей
                const editButtons = document.querySelectorAll('.edit-toggle');

                editButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const fieldsClass = this.getAttribute('data-fields');
                        const fields = document.querySelectorAll('.' + fieldsClass);

                        fields.forEach(field => {
                            const inputs = field.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.disabled = !input.disabled;
                                field.style.opacity = input.disabled ? '0.7' : '1';
                            });
                        });
                    });
                });

                // Управление уведомлением об успешном обновлении
                const successNotification = document.getElementById('successNotification');
                const profileUndoButton = document.getElementById('profileUndoButton');

                if (profileUndoButton) {
                    profileUndoButton.addEventListener('click', function () {
                        // Отправляем запрос на отмену изменений
                        fetch('{{ route("profile.undo") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Показываем уведомление об ошибке
                            const errorAlert = document.createElement('div');
                            errorAlert.className = 'alert alert-danger mt-3';
                            errorAlert.textContent = 'Произошла ошибка при отмене изменений';
                            successNotification.parentNode.insertBefore(errorAlert, successNotification.nextSibling);
                        });
                    });
                }
            });

            // Функция предпросмотра аватара
            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Проверяем тип файла
                    if (!file.type.startsWith('image/')) {
                        alert('Пожалуйста, выберите изображение');
                        input.value = '';
                        return;
                    }

                    // Проверяем размер файла (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Размер файла не должен превышать 2MB');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Находим контейнер аватара в секции настроек
                        const avatarContainer = document.querySelector('.profile-section[data-section="settings"] .bs-icon-xl');

                        if (!avatarContainer) {
                            console.error('Контейнер аватара не найден');
                            return;
                        }

                        // Очищаем контейнер
                        avatarContainer.innerHTML = '';

                        // Создаем и добавляем изображение
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Аватар';
                        img.className = 'w-100 h-100 object-fit-cover';
                        avatarContainer.appendChild(img);

                        // Добавляем параметр section к форме
                        const form = input.closest('form');
                        const urlParams = new URLSearchParams(window.location.search);
                        const activeSection = urlParams.get('section') || 'settings';

                        // Добавляем скрытое поле с текущей секцией
                        let sectionInput = form.querySelector('input[name="active_section"]');
                        if (!sectionInput) {
                            sectionInput = document.createElement('input');
                            sectionInput.type = 'hidden';
                            sectionInput.name = 'active_section';
                            form.appendChild(sectionInput);
                        }
                        sectionInput.value = activeSection;
                    }

                    reader.readAsDataURL(file);
                }
            }
        </script>

        <style>
            .alert {
                transition: opacity 0.15s linear;
            }

            .alert.fade {
                opacity: 0;
            }

            .alert.fade.show {
                opacity: 1;
            }

            .progress-bar {
                transition: width 0.1s linear;
            }

            #undoButton {
                transition: all 0.3s ease;
            }

            #undoButton:hover {
                background-color: var(--bs-success);
                color: white;
            }
        </style>
    @endpush

@endsection
