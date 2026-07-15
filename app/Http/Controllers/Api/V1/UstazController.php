<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UstazResource;
use App\Models\Ustaz;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UstazController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $ustazes = Ustaz::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        return UstazResource::collection($ustazes);
    }
}
