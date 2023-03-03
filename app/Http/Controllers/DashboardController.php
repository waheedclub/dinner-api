<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Models\Food_users;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardData() {
        $data['dashboard_users'] = User::all();
        return $this->respond()
        ->data($data)
        ->send();
    }
}
