<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;

class PesageController extends Controller
{

    public function index()
    {
        $users = json_decode(file_get_contents(resource_path('js/dataTable.json')), true);
        $perPage = 5;
        $currentPage = request()->get('page', 1);
        $pagedData = array_slice($users, ($currentPage - 1) * $perPage, $perPage);
        $users = new LengthAwarePaginator($pagedData, count($users), $perPage, $currentPage);
        $users->setPath(request()->url());

        return view('dashboard.pesage', compact('users'));
    }
}
