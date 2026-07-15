<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TopicController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $topics = Topic::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        return TopicResource::collection($topics);
    }
}
