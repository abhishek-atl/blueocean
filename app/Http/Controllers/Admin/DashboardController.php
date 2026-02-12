<?php

namespace App\Http\Controllers\Admin;

class DashboardController
{
    public function dashboard()
    {
        return view('admin.modules.dashboard.index');
    }
}
