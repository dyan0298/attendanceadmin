<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Firestore\FirestoreClient;

class ViewController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    //

    $employees = app('firebase.firestore')->database()->collection('Employee')->document('CaDAPsTGJ7l8eYMpH8rd')->collection('Record')->documents();
    return view('User/index',compact('employees'));
         //return dd($employees);
  }

  public function view()
  {
    //

    $employees = app('firebase.firestore')->database()->collection('Employee')->document('4kn3oiTJyv2f9oQYuKJq')->collection('Record')->documents();
    return view('Crud/index',compact('employee'));
         //return dd($employees);
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
    if ($request->doc_id == null) {
      // Uplode Data
      $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
       ]);
      $stuRef = app('firebase.firestore')->database()->collection('Employee')->newDocument();
      $stuRef->set([
        'id'=>$request->id,
        'password'=>$request->password,
        'firstName' => $request->first_name,
        'lastName' => $request->last_name,
        'birthDate'    => $request->birthDate,
        'address'    => $request->address,
      ]);
      Session::flash('message', 'Information Uploaded');
      return back()->withInput();
    }
    else {

      $employee = app('firebase.firestore')->database()->collection('Employee')->document($request->doc_id)->snapshot();

      $id = $employee->data()['id'];
      $password = $employee->data()['password'];
      $name = $employee->data()['firstName'];
      $lname = $employee->data()['lastName'];
      $birthDate = $employee->data()['birthDate'];
      $address = $employee->data()['address'];

      $data = sprintf("Name : %s %s \n and Age : %s", $id, $password, $name, $lname, $birthDate, $address);

      Session::flash('message',  $data);
      return back()->withInput();

    }


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
    echo $id;
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
    $employee = app('firebase.firestore')->database()->collection('Employee')->document($id)
   ->update([
    ['path' => 'id', 'value' => $request->id],
    ['path' => 'password', 'value' => $request->password],
    ['path' => 'firstName', 'value' => $request->firstName],
    ['path' => 'lastName', 'value' => $request->lastName],
    ['path' => 'birthDate', 'value' => $request->birthDate],
    ['path' => 'address', 'value' => $request->address],
   ]);
   return back();
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
    app('firebase.firestore')->database()->collection('Employee')->document($id)->delete();
    return back();
  }
}
