<?php
// app/Services/CategoryService.php

namespace App\Services;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public function getCategories(Colocation $colocation)
    {
        return Category::where('colocation_id', $colocation->id)->orderBy('name')->get();
    }

        public function create(array $data, Colocation $colocation): Category
        {
            // dd($colocation->id);
            return Category::create([
                'colocation_id' => (int)$colocation->id,
                'name' => $data['name'],
            ]);
        }

    public function delete(Category $category): void
    {
        $expensesCount = $category->expenses()->count();

        if ($expensesCount > 0) {
            throw new \Exception('Cette categorie est utilisee par ' . $expensesCount . ' depense(s).');
        }

        $category->delete();
    }

}