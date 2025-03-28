<?php

namespace App\Http\Controllers;

use App\Models\TeamInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamInviteController extends Controller
{
    /**
     * Показать страницу приглашения
     */
    public function show($uid)
    {
        $invite = TeamInvite::where('uid', $uid)
            ->where('is_accepted', false)
            ->where('expires_at', '>', now())
            ->first();

        return view('pages.team-invite', compact('invite'));
    }

    /**
     * Принять приглашение
     */
    public function accept($uid)
    {
        $invite = TeamInvite::where('uid', $uid)
            ->where('is_accepted', false)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // Проверяем, не превышен ли лимит участников
        if ($invite->team->members()->count() >= $invite->team->max_members) {
            return back()->with('error', 'К сожалению, команда уже заполнена.');
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
     * Отклонить приглашение
     */
    public function reject($uid)
    {
        $invite = TeamInvite::where('uid', $uid)
            ->where('is_accepted', false)
            ->firstOrFail();

        $invite->delete();

        return redirect()->route('profile.index', ['section' => 'team'])
            ->with('success', 'Приглашение отклонено.');
    }
}
