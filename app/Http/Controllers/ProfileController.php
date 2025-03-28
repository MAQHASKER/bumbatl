<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamInvite;

class ProfileController extends Controller
{
    /**
     * Показать профиль пользователя
     */
    public function index()
    {
        $user = Auth::user();

        // Проверяем наличие активного приглашения
        $pendingInvite = null;
        if (!$user->team) {
            $pendingInvite = TeamInvite::where('email', $user->email)
                ->where('is_accepted', false)
                ->where('expires_at', '>', now())
                ->first();
        }

        return view('pages.profile', compact('user', 'pendingInvite'));
    }

    /**
     * Показать форму редактирования профиля
     */
    public function edit()
    {
        return view('pages.profile.edit');
    }

    /**
     * Отменить последние изменения профиля
     */
    public function undo()
    {
        $previousData = session('previous_profile_data');
        $tempAvatar = session('temp_avatar');

        if ($previousData) {
            $user = auth()->user();

            // Если был изменен аватар
            if (isset($previousData['avatar']) && $user->avatar !== $previousData['avatar']) {
                // Удаляем текущий аватар
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Восстанавливаем предыдущий аватар из временной папки
                if ($tempAvatar && Storage::disk('public')->exists($tempAvatar)) {
                    // Копируем аватар обратно в основную папку
                    $newPath = 'avatars/' . basename($previousData['avatar']);
                    Storage::disk('public')->copy($tempAvatar, $newPath);

                    // Удаляем временный файл
                    Storage::disk('public')->delete($tempAvatar);

                    // Очищаем информацию о временном аватаре
                    session()->forget('temp_avatar');
                }
            }

            // Восстанавливаем предыдущие данные
            $user->update($previousData);

            // Очищаем сохраненные данные
            session()->forget('previous_profile_data');

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Обновить профиль пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Сохраняем текущие данные пользователя перед обновлением
        $previousData = $user->only(['first_name', 'last_name', 'email', 'avatar']);

        // Если загружается новый аватар и у пользователя уже есть аватар
        if ($request->hasFile('avatar') && $user->avatar) {
            // Создаем временную папку, если её нет
            $tempPath = storage_path('app/public/temp_avatars');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0777, true);
            }

            // Копируем текущий аватар во временную папку
            $oldAvatarPath = storage_path('app/public/' . $user->avatar);
            $tempAvatarPath = $tempPath . '/' . auth()->id() . '_' . basename($user->avatar);
            if (file_exists($oldAvatarPath)) {
                copy($oldAvatarPath, $tempAvatarPath);
            }

            // Сохраняем путь к временному файлу в сессии
            session(['temp_avatar' => 'temp_avatars/' . auth()->id() . '_' . basename($user->avatar)]);
        }

        session(['previous_profile_data' => $previousData]);

        $validationRules = [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if ($request->filled('password')) {
            $validationRules['current_password'] = ['required', 'current_password'];
            $validationRules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $request->validate($validationRules);

        // Обработка загрузки аватара
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар, если он существует
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новый аватар
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Обновляем данные пользователя
        $user->update($validated);

        $activeSection = $request->input('active_section', 'settings');
        return redirect()->route('profile.index', ['section' => $activeSection])->with('success', 'Профиль успешно обновлен');
    }

    /**
     * Очистка временных файлов
     */
    public function cleanup()
    {
        $tempAvatar = session('temp_avatar');

        if ($tempAvatar) {
            // Удаляем временный файл
            Storage::disk('public')->delete($tempAvatar);

            // Очищаем информацию о временном аватаре
            session()->forget('temp_avatar');
        }

        // Очищаем данные предыдущего состояния
        session()->forget('previous_profile_data');

        return response()->json(['success' => true]);
    }
}
