<?php
namespace App\Services;

use App\Models\Burger;
use Illuminate\Support\Facades\Storage;

class BurgerService
{
    public function createBurger(array $data): Burger
    {
        if (isset($data['image'])) {
            $data['image'] = $this->handleImageUpload($data['image']);
        }

        return Burger::create($data);
    }
    public function updateBurger(Burger $burger, array $data): Burger
    {
        if (isset($data['image'])) {
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $data['image'] = $this->handleImageUpload($data['image']);
        }

        $burger->update($data);
        return $burger;
    }
    public function archiveBurger(Burger $burger): void
    {
        $burger->update(['is_active' => false]);
    }
    protected function handleImageUpload($imageFile): string
    {
        return $imageFile->store('burgers', 'public');
    }
    public function hasAvailableStock(Burger $burger, int $requestedQuantity): bool
    {
        return $burger->stock >= $requestedQuantity;
    }
}
