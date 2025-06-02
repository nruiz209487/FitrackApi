<?php

namespace App\Http\Controllers;

use App\Models\TargetLocationEntity;
use OpenApi\Annotations as OA;

class TargetLocationEntityController
{
    public function getAll()
    {
        $list = TargetLocationEntity::all();
        return response()->json($list);
    }
}
