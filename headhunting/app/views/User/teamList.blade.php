@extends('layouts.adminLayout')
@section('content')
<section class="content">
          <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">My Team Area</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="employeeList" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Roles</th>
                      </tr>
                    </thead>
                    <tbody>
	                    @forelse($users as $user)
		                      <tr>
		                        <td>{{$user->peer->first_name. " ".$user->peer->last_name }}</td>
		                        <td>{{$user->peer->email}}</td>
		                        <td>{{$user->peer->designation}}</td>
		                        <td>{{$user->peer->userRoles[0]->roles->role}}</td>
		                      </tr>
	                   	@empty
	                   		<p>No users</p>
						@endforelse
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Roles</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

@stop