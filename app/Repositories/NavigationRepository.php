<?php

namespace App\Repositories;

use App\Models\NavigationItem;
use Illuminate\Database\Eloquent\Collection;

class NavigationRepository
{
    public function getActiveNavigation(string $section = 'main'): Collection
    {
        return NavigationItem::active()
            ->forSection($section)
            ->rootItems()
            ->ordered()
            ->with(['children' => function ($query) use ($section) {
                $query->active()->forSection($section)->ordered();
            }])
            ->get();
    }

    public function getAllNavigationItems(string $section = 'main'): Collection
    {
        return NavigationItem::active()
            ->forSection($section)
            ->ordered()
            ->with('children')
            ->get();
    }

    public function findById(int $id): ?NavigationItem
    {
        return NavigationItem::find($id);
    }

    public function getRootItems(string $section = 'main'): Collection
    {
        return NavigationItem::active()
            ->forSection($section)
            ->rootItems()
            ->ordered()
            ->get();
    }
}
