

@extends('layouts.app')

@section('content')

  {{-- Error and Status Card --}}

  @if(Session::has('message'))
    <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
      <strong>{{ Session::get('message') }}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <strong>{{$error}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endforeach
  @endif


  <div class="container">
    <div class="row">
      {{-- Uplode form and picture  --}}
      <div class="col-lg-6">
        <div class="card shadow rounded">
          <div class="card-body">
            <h3 class="text-primary">Create User</h3><br>
            {!! Form::open(['action' => 'App\Http\Controllers\CrudController@store', 'method' => 'POST']) !!}

            <div class="form-group">
                {!! Form::label('id', 'ID') !!}
                {!! Form::text('id', null, ['class'=>'form-control'])!!}
              </div>

              <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::text('password', null, ['class'=>'form-control'])!!}
              </div>

            <div class="form-group">
              {!! Form::label('first_name', 'First Name') !!}
              {!! Form::text('first_name', null, ['class'=>'form-control'])!!}
            </div>

            <div class="form-group">
              {!! Form::label('last_name', 'Last Name') !!}
              {!! Form::text('last_name', null, ['class'=>'form-control'])!!}
            </div>

            <div class="form-group">
              {!! Form::label('birthDate', 'Birth Date (MM/DD/YYYY)') !!}
              {!! Form::text('birthDate', null, ['class'=>'form-control'])!!}
            </div>

            <div class="form-group">
                {!! Form::label('address', 'address') !!}
                {!! Form::text('address', null, ['class'=>'form-control'])!!}
              </div>



            <div class="form-group">
              {!! Form::submit('Upload', ['class'=>'btn btn-primary']) !!}
            </div>

          </div>
        </div>
      </div>

            {!! Form::close() !!}


    {{-- Table --}}

    <div class="mt-5">
      <table class="table table-bordered">
        <thead>
          <th>Document Id</th>
          <th>ID</th>
          <th>Password</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Date of Birth</th>
          <th>Address</th>

        </thead>
        @foreach ($employees as $employee)
          <tbody>
            <td>{{ $employee->id() }}</td>
            <td>{{$employee->data()['id']}}</td>
            <td>{{$employee->data()['password']}}</td>
            <td>{{$employee->data()['firstName']}}</td>
            <td>{{$employee->data()['lastName']}}</td>
            <td>{{$employee->data()['birthDate']}}</td>
            <td>{{$employee->data()['address']}}</td>
            <td>
              <div class="btn-group">
                <button class="btn btn-sm rounded-0" type="button" data-toggle="modal" data-target="#update{{ $employee->id() }}" data-toggle="tooltip" data-placement="left" title="Edit">&#9998;</button>
                <button class="btn btn-sm rounded-0 ml-2" type="button" data-toggle="modal" data-target="#delete{{ $employee->id() }}" data-toggle="tooltip" data-placement="top" title="Delete">🗑️</button>
              </div>
            </td>
          </tbody>



          <!-- Update Modal -->

          <div class="modal fade bd-example-modal-lg" id="update{{ $employee->id() }}"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Update Employee's Information</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body pl-4">

                  {!! Form::model($employee->data(), ['method'=>'PATCH', 'action'=> ['App\Http\Controllers\CrudController@update', $employee->id()]]) !!}


                  <div class="form-group">
                    {!! Form::label('id', 'ID') !!}
                    {!! Form::text('id', null, ['class'=>'form-control'])!!}
                  </div>

                  <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::text('password', null, ['class'=>'form-control'])!!}
                  </div>

                  <div class="form-group">
                    {!! Form::label('firstName', 'First Name') !!}
                    {!! Form::text('firstName', null, ['class'=>'form-control'])!!}
                  </div>

                  <div class="form-group">
                    {!! Form::label('lastName', 'Last Name') !!}
                    {!! Form::text('lastName', null, ['class'=>'form-control'])!!}
                  </div>

                  <div class="form-group">
                    {!! Form::label('birthDate', 'Birth Date') !!}
                    {!! Form::text('birthDate', null, ['class'=>'form-control '])!!}
                  </div>

                  <div class="form-group">
                    {!! Form::label('address', 'ddress') !!}
                    {!! Form::text('address', null, ['class'=>'form-control '])!!}
                  </div>

                </div>

                <div class="modal-footer">
                  {{-- <button type="button" class="btn btn-success">Save changes</button> --}}
                  {!! Form::submit('Save changes', ['class'=>'btn btn-success']) !!}
                  {!! Form::close() !!}
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Modal -->
          <div class="modal fade" id="delete{{ $employee->id() }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Do you really want to delete these records? This process cannot be undone.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>

                  {!! Form::open(['method'=>'DELETE', 'action'=> ['App\Http\Controllers\CrudController@destroy',$employee->id()]]) !!}
                  <div class="form-group">
                    {!! Form::submit('Delete User', ['class'=>'btn btn-danger']) !!}
                  </div>
                  {!! Form::close() !!}

                </div>
              </div>
            </div>
          </div>

        @endforeach
      </table>
    </div>
  </div>




@endsection()
