<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return response()->json($sizes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('sizes')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'type' => 'required|in:number,clothing'
        ]);

        $size = Size::create($request->all());
        return response()->json([
            'success' => true,
            'size' => $size
        ]);
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('sizes')->where(function ($query) use ($request, $size) {
                    return $query->where('type', $request->type)
                                ->where('id', '!=', $size->id);
                })
            ],
            'type' => 'required|in:number,clothing'
        ]);

        $size->update($request->all());
        return response()->json([
            'success' => true,
            'size' => $size
        ]);
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return response()->json([
            'success' => true,
            'message' => 'Size deleted successfully'
        ]);
    }

    public function show()
    {
        return view('admin.sizes');
    }
} 