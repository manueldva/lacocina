<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
Use Alert;
use App\User;
use App\Models\Persona;
use App\Models\Cliente;
use App\Models\Tipocliente;
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
        $fecha = date('Y-m-d'); 
        $segment = 'clientes';

        $tipoclientes = Tipocliente::all();
        return view('clientes.create', compact('segment','tipoclientes'));
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
            'fechaalta.required' =>'El campo Fecha de alta es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'numerodocumento' => 'max:20',
            'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);


        
        if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back()->withInput();
        }

    
        $carbon = new Carbon(); 
        if($request->input('fechaingreso') > $carbon ){
            alert()->error('Fecha de alta incorrecta', 'no pude ser mayor a la fecha actual');
            return redirect('clientes/create')->withInput();
        }

        //dd($request);

        $cliente = Cliente::create($request->all());
        $max = Cliente::max('codigo') + 1;
        $cliente->fill(['codigo' => $max ])->save();

        /* para crear varios registros
             $carbon = new Carbon(); 
                for ($i=0; 20 > $i; $i++) { 
                            
                    $miembro = Miembro::create($request->all());
                    $max = Miembro::max('codigo') + 1;
                    $miembro->fill(['codigo' => $max ])->save();
                }
        
        */

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

        return view('clientes.edit', compact('segment','cliente','show'));
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
        $messages = [
            'fechaalta.required' =>'El campo Fecha de ingreso es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'direccion' => 'max:200',
            'fechaalta' => 'required',
            'celular' => 'max:20'
            
            //'body' => 'required',
        ], $messages);



        if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back();
        }
  
        $cliente->update($request->all());
  
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
        alert()->success('Registro Eliminado', 'Exitosamente');
        return back();
    }
}
