<?php

namespace App\Http\Controllers\Api\V1\Zone;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Zone\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\Group;

#[Group(name: 'Zones')]
class ZoneController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ZoneResource::collection(Zone::all());
    }
}
