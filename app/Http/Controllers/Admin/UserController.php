<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FileTypeEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    private object $model;
    private string $table;
    private string $role = 'admin';

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(Request $request)
    {
        $query        = $this->model
            ->clone()
            ->latest();
        $selectedRole = $request->get('role');
        if (!empty($selectedRole) && $selectedRole !== 'Tất cả') {
            $query->where('role', $request->get('role'));
        }
        $query->with(['files' => function($q) {
            $q->whereIn('type', [
                FileTypeEnum::getValue('IDENTITY'),
                FileTypeEnum::getValue('LICENSE_CAR'),
            ]);
        }]);

        $data = $query->paginate();
        $roles = UserRoleEnum::asArray();

        return view("$this->role.$this->table.index", [
            'data'         => $data,
            'roles'        => $roles,
            'selectedRole' => $selectedRole,
        ]);
    }

    public function show($userId)
    {
        $data = $this->model->select('users.id', 'files.id', 'files.type', 'files.link')
            ->join("files", 'files.table_id', '=', 'users.id')
            ->where('files.table', 0)
            ->where('files.type', 0)
            ->orwhere('files.type', 1)
            ->get();
        return view("$this->role.$this->table.show", [
            'each' => $data,
        ]);
    }


    public function destroy($userId)
    {
        User::destroy($userId);

        return redirect()->back();
    }
}