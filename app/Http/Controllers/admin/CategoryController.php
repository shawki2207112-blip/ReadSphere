<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a searchable and paginated category list.
     */
    public function index(Request $request): View
    {
        $categories = Category::withCount('books')
            ->when(
                $request->search,
                fn ($query, $search) =>
                    $query->where(
                        'category_name',
                        'like',
                        "%{$search}%"
                    )
            )
            ->orderBy('category_name')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    /**
     * Display the form for creating a category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Validate and save a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,category_name',
            ],
        ]);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category added successfully.');
    }

    /**
     * Display the form for editing a category.
     */
    public function edit(Category $category): View
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }

    /**
     * Validate and update the selected category.
     */
    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,category_name,'.$category->id,
            ],
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a category only when it contains no books.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Include soft-deleted books when checking category usage.
        if ($category->books()->withTrashed()->exists()) {
            return back()->with(
                'error',
                'This category cannot be deleted because it contains books.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Category deleted successfully.'
        );
    }
}