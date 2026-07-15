<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DersResource;
use App\Models\Ders;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DersController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $derses = Ders::query()
            ->published()
            ->when($request->filled('ustaz_id'), fn ($query) => $query->where('ustaz_id', $request->integer('ustaz_id')))
            ->when($request->filled('topic_id'), fn ($query) => $query->where('topic_id', $request->integer('topic_id')))
            ->orderBy('sort_order')
            ->get();

        return DersResource::collection($derses);
    }

    public function show(int $id): DersResource
    {
        $ders = Ders::query()
            ->published()
            ->with(['episodes' => fn ($query) => $query->published()->orderBy('sort_order')])
            ->findOrFail($id);

        return new DersResource($ders);
    }
}
