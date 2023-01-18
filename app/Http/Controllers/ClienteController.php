<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
Use Alert;
use App\User;
use App\Models\Persona;
use App\Models\Cliente;
//use App\Models\Tipocliente;
use App\Models\Tipocontacto;
//use App\Models\Dia;
use Auth;
use Carbon\Carbon;

class ClienteController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segment = 'clientes';
        //$clientes = Cliente::paginate(10);
        
        $clientes =  Cliente::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);
        
    

        return view('clientes.index',compact('clientes', 'segment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$fecha = date('Y-m-d'); 
        $segment = 'clientes';

        //$tipoclientes = Tipocliente::where('activo',1)->get();
        $tipocontactos = Tipocontacto::where('activo',1)->get();
        //$dias = Dia::where('activo',1)->get();

        return view('clientes.create', compact('segment','tipocontactos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $messages = [
            'fechanacimiento.required' =>'El campo Fecha de nacimiento es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'documento' => 'max:20',
            'domicilio' => 'max:200'
            //'tipocliente_id' => 'required',
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);
        
        /*if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back()->withInput();
        }*/

        $existe = Persona::where('apellido',$request->apellido)->where('nombre', $request->nombre)->count();

        //dd($existe);

        if($existe > 0) 
        {
            alert()->error('Error', 'Ya existe un cliente con ese apellido y nombre');
            return back()->withInput();
        }


        $persona = Persona::create($request->all());
        
        $cliente = new Cliente;
            //$cliente->tipocliente_id = $request->input('tipocliente_id');
            $cliente->persona_id = $persona->id;
        $cliente->save();

        alert()->success('Cliente Creado', 'Exitosamente');
        return redirect()->route('clientes.edit', $cliente->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $segment = 'clientes';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('clientes.edit', compact('segment','cliente', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {

        //$miembro = Miembro::find($id);
        $show = 0;
        $segment = 'clientes';

        //$tipoclientes = Tipocliente::where('activo',1)->get();
        $tipocontactos = Tipocontacto::where('activo',1)->get();
        //$dias = Dia::where('activo',1)->get();

        return view('clientes.edit', compact('cliente', 'segment','tipocontactos', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        
        //dd($request->all());
        $messages = [
            'fechanacimiento.required' =>'El campo Fecha de nacimiento es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'documento' => 'max:20',
            'domicilio' => 'max:200'
            //'tipocliente_id' => 'required',
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);



        if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back();
        }
  
        $cliente->update($request->all());
        $persona = Persona::find($cliente->persona_id);
        $persona->update($request->all());
  
        alert()->success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('clientes.edit', $cliente->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        Persona::where('id', $cliente->persona_id)->delete();
        alert()->success('Registro Eliminado', 'Exitosamente');
        return back();
    }
}
