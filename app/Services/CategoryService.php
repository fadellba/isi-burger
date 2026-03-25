<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllForCatalogue(): Collection
    {
        return Category::with(['burgers' => function($query) {
            $query->where('stock', '>', 0);
        }])->get();
    }

    public function createCategory(array $data)
    {
        return Category::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function getCategoryWithFilters(int $id, array $filters): array
    {
        $category = Category::findOrFail($id);

        $query = $category->burgers();

        if (isset($filters['prix_max'])) {
            $query->where('prix', '<=', $filters['prix_max']);
        }

        if (isset($filters['libelle'])) {
            $query->where('nom', 'like', '%' . $filters['libelle'] . '%');
        }

        return [
            'category' => $category,
            'burgers' => $query->get()
        ];
    }
}
