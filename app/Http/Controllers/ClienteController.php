<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\filters\ClienteFilter;
use App\Models\Sortable;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request, ClienteFilter $filters,Sortable $sortable)
    {
        $clientes = Cliente::query() //Función para la cantidad de registros por página
            ->filterBy($filters,$request->only(['status','search','order']))
            ->orderByDesc('created_at')
            ->paginate(10); //Cantidad de registros por página

        $clientes->appends($filters->valid());//para concatenar a la paginación en búsqueda
        $sortable->appends($filters->valid());


        return view('clientes.index', [
            'clientes' => $clientes,
            'sortable'=>$sortable,
        ]);
    }
    public function create(){
        return $this->form('clientes.create', new Cliente(),'create');
    }
    private function form(string $view, Cliente $cliente,$vista)
    {
        return view($view, [
            'cliente' => $cliente,
            'vista'=>$vista
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([ //Función para validar los campos solicitados
            'num_documento'=>'required',
            'telefono'=>'required',
            'tipo_documento'=>'required',
            'nombre'=>'required',
            'direccion'=>'',
            'email'=>'',

        ]);

        Cliente::create([ //Función para crear los clientes
            'nombre'=>$request->nombre,
            'telefono'=>$request->telefono,
            'tipo_documento'=>$request->tipo_documento,
            'num_documento'=>$request->num_documento,
            'status'=>$request->state,
            'direccion'=>$request->direccion,
            'email'=>$request->email,
        ]);

        return redirect()->route('clientes.index')->with('success','Cliente Creado Exitosamente');
    }
    public function edit(Cliente $cliente) //Función para editar los clientes
    {
        return $this->form('clientes.edit', $cliente,'editar');
    }
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([ //Función para validar los campos solicitados
            'num_documento'=>'required',
            'telefono'=>'required',
            'tipo_documento'=>'required',
            'nombre'=>'required',
            'direccion'=>'',
            'email'=>'',

        ]);
        $cliente->update([ //Función para actualizar al cliente
            'nombre'=>$request->nombre,
            'telefono'=>$request->telefono,
            'tipo_documento'=>$request->tipo_documento,
            'num_documento'=>$request->num_documento,
            'status'=>$request->state,
            'direccion'=>$request->direccion,
            'email'=>$request->email,
        ]);
        $cliente->save();

        return redirect()->route('clientes.index')->with('success','Cliente Actualizado Exitosamente');
    }

    public function delete(Request $request) //Función para inactivar al cliente
    {
        $cliente = Cliente::query()->where('id', $request->cliente_id)->first();
        $cliente->status = 'inactive';
        $cliente->save();
        return [
            'status'=>true,
        ];
    }

}
