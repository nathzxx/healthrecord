<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserRoleStats extends BaseWidget
{

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        $cards = [];

        foreach (Role::all() as $role) {
            $userCount = User::role($role->name)->count();

            $cards[] = Card::make(ucfirst($role->name) . 's', $userCount)
                ->description("Total {$role->name}s")
                ->color('primary')
                ->url(route('filament.admin.resources.users.index', [
                    'tableFilters[roles][value]' => $role->id,
                ]))
                ->extraAttributes(['class' => 'cursor-pointer']);
        }

        return $cards;
    }
}
