<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
Use Alert;
use App\User;
use Spatie\Permission\Models\Role;

class ManageuserController extends Controller
{
 
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manageusers.index')->only('index');
        $this->middleware('can:manageusers.create')->only('create','store');
        $this->middleware('can:manageusers.edit')->only('edit','update');
        $this->middleware('can:manageusers.show')->only('show');
        $this->middleware('can:manageusers.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // example:
        //alert()->error('Oops...', 'Something went wrong!')->footer('<a href="../www.google.com" tarjet="_blank">Why do I have this issue?</a>');
        //alert('Title','Lorem Lorem Lorem', 'success')->width('720px');

        $segment = 'users';

        $users =  User::buscarpor($request->get('tipo'), $request->get('buscarpor'))->where('username','<>','mavila')->paginate(10);

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        return view('manageusers.index',compact('users', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segment = 'users';

        $roles = Role::where('name','<>','Desarrollador')->get();
        return view('manageusers.create', compact('segment','roles'));
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
            'name.required' => 'El campo nombre completo es obligatorio.',
            'username.required' =>'El campo usuario es obligatorio.',
            //'tipouser_id.required' =>'El campo tipo de usuario es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'username' => 'required|unique:users|max:191',
            'email' => 'required|unique:users|max:191',
            //'tipouser_id' => 'required',
            
            //'body' => 'required',
        ], $messages);


        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make(123456),
        ])->assignRole($request->input('role_id'));

        Alert::success('Usuario Creado', 'La contraseña por defecto es 123456')->persistent();
        return redirect()->route('manageusers.index');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        $user = User::find($id);
        $segment = 'users';
        $show = 1;

        $roles = Role::where('name','<>','Desarrollador')->get();

        $rol_actual = $user->getRoleNames()[0]; 

        //Alert::toast('Toast Message', 'success');
        return view('manageusers.edit', compact('segment','user', 'show','roles','rol_actual'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        $user = User::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'users';

        $roles = Role::where('name','<>','Desarrollador')->get();

        $rol_actual = $user->getRoleNames()[0]; 

        return view('manageusers.edit', compact('segment', 'user','show','roles','rol_actual'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        $messages = [
            'name.required' => 'El campo nombre completo es obligatorio.',
            'username.required' =>'El campo usuario es obligatorio.',
            //'tipouser_id.required' =>'El campo tipo de usuario es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'name' => 'required|max:191',
            'username' => 'required|max:191|unique:users,username,' . $id,
            'email' => 'required|max:191|unique:users,email,' . $id,
            //'tipouser_id' => 'required',
            
            //'body' => 'required',
        ], $messages);

        $user = User::find($id);


        $user->update($request->all());

        //para los roles
        $user->roles()->sync($request->input('role_id'));
        //

        Alert::success('Usuario actualizado con exito')->persistent();
        return redirect()->route('manageusers.edit', $user->id);   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        Alert::success('Usuario Eliminado Correctamente')->persistent();
        return back();
    }


    public function showSetting($id)
    {

        $segment = 'setting';

        $user = User::find($id);

        //return $user;
        return view('manageusers.setting', compact('user','segment'));
    }


    public function setting(Request $request, $id)
    {
        //dd($request->input('password2'));

        if ($request->input('password') !== $request->input('password2')){
            //return back()->with('danger', 'Las contraseñas deben coincidir')->withInput();
            Alert::error('Las contraseñas deben coincidir')->persistent();
            return back();
        }

        

        /*if($request->file('image')){

            $input  = array('image' => $request->file('image'));

            $rules = array('image' => 'mimes:jpg,jpeg,png');

            $validator = Validator::make($input,  $rules);

            if ($validator->fails())
            {
                return back()->with('danger', 'La imagen no posee un formato valido')->withInput();
            }
        } */


        // contraseña
        $user = User::find($id);

        if ($request->input('password2')){
            $user->fill(['password' => bcrypt($request->input('password2'))])->save();
        }  
        /*
         //IMAGE 
        if($request->file('image')){
            $path = Storage::disk('public')->put('image',  $request->file('image'));
            $user->fill(['file' => asset($path)])->save();
        }*/

        $segment = 'setting';
        Alert::success('Usuario actualizado con exito')->persistent('Cerrar');
        return view('manageusers.setting', compact('user','segment'));

    }


}


//https://realrashid.github.io/sweet-alert/