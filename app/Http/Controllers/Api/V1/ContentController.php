<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DersResource;
use App\Http\Resources\V1\TopicResource;
use App\Http\Resources\V1\UstazResource;
use App\Models\Ders;
use App\Models\Topic;
use App\Models\Ustaz;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $ustazes = Ustaz::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $topics = Topic::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $derses = Ders::query()
            ->published()
            ->with(['episodes' => fn ($query) => $query->published()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'ustazes' => UstazResource::collection($ustazes)->resolve(),
            'topics' => TopicResource::collection($topics)->resolve(),
            'derses' => DersResource::collection($derses)->resolve(),
        ]);
    }
}
