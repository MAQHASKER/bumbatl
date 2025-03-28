<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamInviteMail;

class TeamController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'description' => 'nullable|string',
            'max_members' => 'required|integer|min:2|max:10'
        ], [
            'name.required' => 'Пожалуйста, введите название команды',
            'name.unique' => 'Команда с таким названием уже существует',
            'name.max' => 'Название команды не должно превышать 255 символов',
            'max_members.required' => 'Пожалуйста, укажите максимальное количество участников',
            'max_members.min' => 'Минимальное количество участников - 2',
            'max_members.max' => 'Максимальное количество участников - 10'
        ]);

        // Создаем новую команду
        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'max_members' => $request->max_members,
            'captain_id' => Auth::id(),
            'total_weight' => 0,
            'rank' => null
        ]);

        // Добавляем создателя в команду
        $team->members()->attach(Auth::id(), ['is_active' => true]);

        // Обновляем team_id пользователя
        $user = Auth::user();
        $user->team_id = $team->id;
        $user->save();

        return redirect()->route('profile.index', ['section' => 'team'])
            ->with('success', 'Команда успешно создана!');
    }

    /**
     * Удаление команды
     */
    public function destroy(Team $team)
    {
        // Проверяем, является ли пользователь капитаном команды
        if ($team->captain_id !== auth()->id()) {
            return back()->with('error', 'У вас нет прав для удаления этой команды.');
        }

        // Удаляем команду
        $team->delete();

        return back()->with('success', 'Команда успешно удалена.');
    }

    /**
     * Создание приглашения в команду
     */
    public function createInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'team_id' => 'required|exists:teams,id'
        ]);

        $team = Team::findOrFail($request->team_id);

        // Проверяем, является ли пользователь капитаном команды
        if ($team->captain_id !== Auth::id()) {
            return back()->with('error', 'У вас нет прав для приглашения участников.');
        }

        // Проверяем, не превышен ли лимит участников
        if ($team->members()->count() >= $team->max_members) {
            return back()->with('error', 'Достигнут лимит участников в команде.');
        }

        // Проверяем, не существует ли уже приглашение для этого email
        $existingInvite = TeamInvite::where('email', $request->email)
            ->where('team_id', $team->id)
            ->where('is_accepted', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingInvite) {
            return back()->with('error', 'Приглашение для этого email уже существует.');
        }

        // Проверяем, не состоит ли пользователь уже в команде
        $user = User::where('email', $request->email)->first();
        if ($user && $user->team_id) {
            return back()->with('error', 'Этот пользователь уже состоит в команде.');
        }

        // Создаем приглашение
        $invite = TeamInvite::create([
            'team_id' => $team->id,
            'inviter_id' => Auth::id(),
            'email' => $request->email,
            'expires_at' => Carbon::now()->addDays(7) // Приглашение действует 7 дней
        ]);

        return back()->with('success', 'Приглашение успешно отправлено.');
    }

    /**
     * Принятие приглашения
     */
    public function acceptInvite($uid)
    {
        $invite = TeamInvite::where('uid', $uid)
            ->where('is_accepted', false)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // Проверяем, не превышен ли лимит участников
        if ($invite->team->members()->count() >= $invite->team->max_members) {
            return back()->with('error', 'К сожалению, команда уже заполнена.');
        }

        // Если пользователь не авторизован, сохраняем приглашение в сессии
        if (!Auth::check()) {
            session(['pending_invite' => $uid]);
            return redirect()->route('login');
        }

        // Добавляем пользователя в команду
        $invite->team->members()->attach(Auth::id(), ['is_active' => true]);

        // Обновляем team_id пользователя
        $user = Auth::user();
        $user->team_id = $invite->team->id;
        $user->save();

        // Отмечаем приглашение как принятое
        $invite->update([
            'is_accepted' => true,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('profile.index', ['section' => 'team'])
            ->with('success', 'Вы успешно присоединились к команде!');
    }

    /**
     * Отклонение приглашения
     */
    public function rejectInvite($uid)
    {
        $invite = TeamInvite::where('uid', $uid)
            ->where('is_accepted', false)
            ->firstOrFail();

        $invite->delete();

        return back()->with('success', 'Приглашение отклонено.');
    }
}
