<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Colocation;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Afficher la gestion des categories
     */
    public function index(Colocation $colocation)
    {
        // Verifier que l'utilisateur est membre
        $membership = $colocation->memberships()->where('user_id', Auth::id())->whereNull('left_at')->first();

        if (!$membership) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'êtes pas membre de cette colocation.');
        }

        $isOwner = $membership->membership_role === 'owner';
        $categories = $this->categoryService->getCategories($colocation);



        return view('categories.index', compact('colocation', 'categories', 'isOwner'));
    }

    /**
     * Formulaire de creation
     */
    public function create(Colocation $colocation)
    {      
        return view('categories.create', compact('colocation'));
    }

    public function store(CategoryRequest $request, Colocation $colocation)
    {
        try {
            $category = Category::create([
                'colocation_id' => (int)$colocation->id,
                'name' => $request->validated()['name'],
            ]);
            return redirect()->route('categories.index', $colocation)->with('success', 'Categorie "' . $category->name . '" creee avec succes !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(Colocation $colocation, Category $category)
    {
        return view('categories.edit', compact('colocation', 'category'));
    }

    public function update(CategoryRequest $request, Colocation $colocation, Category $category)
    {
        try {
            $category->update($request->validated());
            return redirect()->route('categories.index', $colocation)->with('success', 'Categorie mise a jour avec succes !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Colocation $colocation, Category $category)
    {
        try {
            $this->categoryService->delete($category);
            return redirect()->route('categories.index', $colocation)->with('success', 'Categorie supprimee avec succes !');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}