@extends('layouts.punk')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Managers
          <span class="float-right">
            <a href="{{ route('punk.register') }}" class="btn btn-info">Add Manager </a>
          </span>
        </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Created At</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users ?? ''  as $key => $user)
             <tr>
              <th scope="row">{{ $key + 1 }}</th>
              <td>{{ ucfirst($user->name) }}</td>
              <td>{{ ucfirst($user->email) }}</td>
              <td>{{ Carbon\Carbon::parse($user->created_at)->format('Y M d') }}</td>
              <td>

              <a href="{{ route('punk.remove' , ['module' => 'users', 'user_id' => $user->id ]) }}" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> </a>
            </td>
            </tr>
          @empty
          <tr>
            <td class="text-center" colspan="8"> No Data Available </td>
          </tr>
          @endforelse
          </tbody>
        </table>
       </div>
      </div>
    </div>
    </div>
  </div>
@endsection
