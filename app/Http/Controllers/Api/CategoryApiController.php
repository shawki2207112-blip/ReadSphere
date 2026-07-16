<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    /**
     * Return all categories with their book counts.
     */
    public function index(): JsonResponse
    {
        $categories = Category::withCount('books')
            ->orderBy('category_name')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $categories->count(),
            'categories' => $categories,
        ]);
    }
}