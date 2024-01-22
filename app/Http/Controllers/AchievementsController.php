<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
{
    $unlockedAchievements = $this->getUnlockedAchievements($user);
    $nextAvailableAchievements = $this->getNextAvailableAchievements($user);
    $currentBadge = $this->getCurrentBadge($user);
    $nextBadge = $this->getNextBadge($user);
    $remainingToUnlockNextBadge = $this->getRemainingToUnlockNextBadge($user);

    return response()->json([
        'unlocked_achievements' => $unlockedAchievements,
        'next_available_achievements' => $nextAvailableAchievements,
        'current_badge' => $currentBadge,
        'next_badge' => $nextBadge,
        'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge
    ]);
}

}
