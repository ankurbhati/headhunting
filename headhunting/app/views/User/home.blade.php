@extends('layouts.adminLayout')
@section('content')
<div class="box box-primary">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Today Requirements</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="todo-list">
                  	@forelse($jobPosts as $jobPost)
	                    <li>
	                      <span class="text">{{$jobPost->title}}</span>
	                      <!-- General tools such as edit or delete-->
	                      <div class="tools">
	                      		<a href="{{ URL::route('edit-requirement', array($jobPost->id)) }}" class="text-info" title="Edit Job Post"><i class="fa fa-edit"></i> &nbsp; Edit Requirement</a> &nbsp;&nbsp; &nbsp; &nbsp;
	                        	@if($jobPost->jobsAssignedToMe()->count() == 0)
	                        		<a href="{{ URL::route('assign-requirement', array($jobPost->id)) }}" class="text-success" title="Assign To me"><i class="fa fa-plus"></i>&nbsp; Assign To Me</a>&nbsp;&nbsp; &nbsp; &nbsp;
	                        	@endif
	                        	@if(Auth::user()->getRole() <= 2)
	                        		<a href="{{ URL::route('delete-requirement', array($jobPost->id)) }}" class="text-danger" title="Delete Job Post"><i class="fa fa-trash-o text-danger"></i>&nbsp; Delete Requirement</a>
	                        	@endif
	                      </div>
	                    </li>
                    @empty
	                	<p>No Job Post Today</p>
					@endforelse
                  </ul>
                </div><!-- /.box-body -->
              </div>
@stop