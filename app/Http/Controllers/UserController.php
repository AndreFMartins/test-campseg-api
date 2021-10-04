<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query()->join('roles', 'users.role_id', '=', 'roles.id');
        if ($search = trim($request->input('search'))) {
            $query->where('users.name', 'like', "%$search%")->orWhere('users.username', 'like', "%$search%");
        }

        $query->select(['users.name', 'users.id', 'users.username', 'roles.description as role', 'roles.name as role_name', 'roles.id as role_id',]);
        return response()->json($query->paginate(5), 200);
    }

    public function create(UserRequest $request)
    {
        $commonRoleId = Role::query()->where('name', 'common')->first()->id;

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'role_id' => $request->role_id ?? $commonRoleId,
        ]);

        return response()->json($user, 201);
    }

    public function show(Request $request)
    {
        try {
            return response()->json(User::findOrFail($request->id), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Usuário não encontrado',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
    public function update(Request $request, int $useId)
    {

        $commonRoleId = Role::query()->where('name', 'common')->first()->id;

        try {
            $user = User::findOrFail($useId);
            $user->name = $request->name;
            $user->role_id = $request->role_id ?? $commonRoleId;
            if ($request->password) {
                $user->password = $request->password;
            }
            $user->update();
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Falha na atualização de dados do usuário',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Falha ao remover usuário',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function totalUsers()
    {
        try {
            return response()->json(User::count(), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Falha ao obter o número de usuários',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
