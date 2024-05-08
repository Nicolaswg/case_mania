<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Filters\UserFilter;
use App\Models\Sortable;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, UserFilter $filters,Sortable $sortable)
    {
        $users = User::query()
            ->with( 'profile')
            ->filterBy($filters,$request->only(['state','role','search','order']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $users->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());


        return view('users.index', [
            'users' => $users,
            'view'=>'index',
            'sortable'=>$sortable,
        ]);
    }
    public function create(){
        return $this->form('users.create', new User,'create');
    }
    public function store(CreateUserRequest $request)
    {
        //dd($request->input('empleado'));
        $request->createUser();
        return redirect()->route('users.index')->with('success','Usuario Guardado con Exito');
    }
    private function form(string $view, User $user,$vista)
    {
        return view($view, [
            'user' => $user,
            'sucursales'=>Sucursal::orderBy('nombre')->get(),
            'vista'=>$vista
        ]);
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', ['user' => $user]);
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function edit(User $user)
    {
        return $this->form('users.edit', $user,'editar');
    }
    public function destroy(Request $request){
        $user_id=$request->user_id;
        $user= User::where('id',$user_id)->first();
        $user->forceDelete();
        return [
            'status'=>'ok'
        ];
    }


}
