<?php

namespace App\Http\Controllers;

use App\Models\ExerciseEntity;
use App\Models\TargetLocationEntity;
use Illuminate\View\View;

class HomeController
{
    public function home(): View
    {
        $ExerciseEntity = ExerciseEntity::paginate(12, ['*'], 'exercises');
        $TargetLocationEntity = TargetLocationEntity::paginate(12, ['*'], 'locations');

        return view('home', compact('ExerciseEntity', 'TargetLocationEntity'));
    }
}