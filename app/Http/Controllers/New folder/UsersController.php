<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\User;

class UsersController extends Controller
{
    const PAGE_NAME = "users";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users/index', ['users' => auth()->user()->users, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users/create', ['page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|string|max:255',
            'gender' => 'required|boolean|max:255',
            'status' => 'required|boolean|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        

        $user = new User($request->all());
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->client_id = auth()->user()->id;
        $user->type = 'user';
        $user->save();

        return redirect(route('users'))->with('success', 'A new user was created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users'))->with('warning', 'warning.');
        }

        return view('users/edit', ['user' => $user, 'page_name' => self::PAGE_NAME]);
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
        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => [
                            'required',
                            'string',
                            'email',
                            'max:255',
                            Rule::unique('users')->ignore($id),
                        ],
            'phone' => 'required|string|max:255',
            'gender' => 'required|boolean|max:255',
            'status' => 'required|boolean|max:255',
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);


        $user = User::find($id);
        $user->fill($request->all());

        $user->status = $request->status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect(url('users/' . $id . '/edit'))->with('success', 'A user was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect(url('users'))->with('success', 'A user was deleted.');
    }
}
