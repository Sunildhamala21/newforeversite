<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::get();

        return view('admin.faqCategories.index', [
            'categories' => $categories,
        ]);
    }

    public function categoryList(): JsonResponse
    {
        $categories = FaqCategory::orderBy('order')->get();

        $categories = $categories->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'icon' => $item->getFirstMediaUrl('icon', 'webp'),
            ];
        });

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:faq_categories,name',
            'icon' => 'required|string',
        ], [
            'name.unique' => 'The name has already been taken.',
        ]);

        $category = FaqCategory::create($request->only('name', 'icon'));

        return redirect()->back();
    }

    public function update(Request $request, FaqCategory $faqCategory): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'icon' => 'required|string',
        ]);

        $faqCategory->update([
            'name' => $request->string('name'),
            'icon' => $request->string('icon'),
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'FAQ Category updated!',
        ]);
    }

    public function destroy(FaqCategory $faqCategory): JsonResponse
    {
        $faqCategory->delete();

        return response()->json([
            'status' => 1,
            'message' => 'FAQ Category deleted!',
        ]);
    }

    public function list(): JsonResponse {
        return response()->json(['data' => FaqCategory::all()->toArray()]);
    }
}
