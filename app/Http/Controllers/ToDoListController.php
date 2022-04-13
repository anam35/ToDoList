<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ToDoList;
use App\Models\User;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$id_usera = Auth::user()->id;
		$list = ToDoList::join('users', 'users.id', '=', 'to_do_lists.idKorisnika')
			->where("users.id", "=", $id_usera)
			->get(['users.name', 'to_do_lists.id', 'to_do_lists.zadatak', 'to_do_lists.stanje', 'to_do_lists.created_at', 'to_do_lists.updated_at']);
		return view('todolist')->with(['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$zadatak = new ToDoList();
        $zadatak->idKorisnika = $request->user()->id;
        $zadatak->zadatak = $request->zadatak;
        $zadatak->save();

        return redirect()->route('todolist.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$id_usera = Auth::user()->id;
		$zadatak = ToDoList::find($id);
		$list = ToDoList::join('users', 'users.id', '=', 'to_do_lists.idKorisnika')
			->where("users.id", "=", $id_usera)
			->get(['users.name', 'to_do_lists.id', 'to_do_lists.zadatak', 'to_do_lists.stanje', 'to_do_lists.created_at', 'to_do_lists.updated_at']);
		return view('todolist')->with(['list' => $list, 'edit' => $zadatak, 'id' => $id]);
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
        //
		$action = $request->action;
		if($action == "uredi"){
			$zadatak = ToDoList::find($id);
			$zadatak->zadatak = $request->zadatak;
			$zadatak->update();
			return redirect()->route('todolist.index');
		}else if($action == "zavrsi"){
			$zadatak = ToDoList::find($id);
			$zadatak->stanje = "0";
			$zadatak->save();
			return redirect()->route('todolist.index');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$zadatak = ToDoList::find($id);
        $zadatak->delete();
        return redirect()->route('todolist.index');
    }
}
