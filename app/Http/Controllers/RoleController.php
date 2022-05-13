<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
Use Alert;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create','store');
        $this->middleware('can:roles.edit')->only('edit','update');
        $this->middleware('can:roles.show')->only('show');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segment = 'roles';

        //$users =  User::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);
        $roles = Role::where('name','<>','Desarrollador')->paginate(10);
        //$roles =  Role::buscarpor($request->get('tipo'), $request->get('buscarpor'))->where('name','<>','Desarrollador')->paginate(10);

        //dd($roles);

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        return view('roles.index',compact('roles', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::OrderBy('name')->get();

        $padre = Permission::query()
            ->select(['father'])
            ->groupBy('father')
            ->orderby('father')
            ->get();
            //dd($padre);

        $segment = 'roles';

        return view('roles.create', compact('segment','permissions','padre'));
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
            'name.required' => 'El campo nombre es obligatorio.',
            //'username.required' =>'El campo usuario es obligatorio.',
            //'tipouser_id.required' =>'El campo tipo de usuario es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'name' => 'required|max:191|unique:roles,name',
            /*'username' => 'required|unique:users|max:191',
            'email' => 'required|unique:users|max:191',*/
            //'tipouser_id' => 'required',
            
            //'body' => 'required',
        ], $messages);


        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        Alert::success('Rol Creado')->persistent();
        return redirect()->route('roles.edit', $role->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        //dd($plan);
        $show = 1;
        $segment = 'roles';

        $permissions = Permission::OrderBy('name')->get();

        $padre = Permission::query()
            ->select(['father'])
            ->groupBy('father')
            ->orderby('father')
            ->get();

        $roles = Role::all();

        $selected_permissions = [];
        foreach ($role->permissions as $permission) {
            array_push($selected_permissions, $permission->id);
        }

        return view('roles.edit', compact('segment', 'role','permissions','selected_permissions','padre','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $role = Role::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'roles';

        $permissions = Permission::OrderBy('name')->get();
        
        $padre = Permission::query()
        ->select(['father'])
        ->groupBy('father')
        ->orderby('father')
        ->get();

        $roles = Role::all();


        $selected_permissions = [];
        foreach ($role->permissions as $permission) {
            array_push($selected_permissions, $permission->id);
        }

        return view('roles.edit', compact('segment', 'role','permissions','selected_permissions','padre','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            //'username.required' =>'El campo usuario es obligatorio.',
            //'tipouser_id.required' =>'El campo tipo de usuario es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'name' => 'required|max:191|unique:roles,name,' . $id,
            /*'username' => 'required|unique:users|max:191',
            'email' => 'required|unique:users|max:191',*/
            //'tipouser_id' => 'required',
            
            //'body' => 'required',
        ], $messages);

        $role = Role::find($id);

        $role->update($request->all());

        $role->permissions()->sync($request->permissions);

        Alert::success('Rol Editado')->persistent();
        return redirect()->route('roles.edit', $role->id); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(User::role($id)->count() > 0) {
            Alert::error('Este registro no se puede eliminar','Usuarios Asociados')->persistent();
            return back();
        } else {
            Role::find($id)->delete();
            Alert::success('Rol Eliminado Correctamente')->persistent();
            return back();
        }

       //dd($users);
        /*

        Role::find($id)->delete();
        Alert::success('Rol Eliminado Correctamente')->persistent();
        return back();*/
    }

}
