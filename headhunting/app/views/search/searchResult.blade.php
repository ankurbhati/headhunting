@extends('layouts.adminLayout')
@section('content')
<section class="content">
          <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title col-sm-9">Search Results</h3>
                  <div class="col-sm-3">
                				<a class="btn btn-primary pull-right" href="{{ URL::route('advance-search', array($jobId)) }}">
                					<i class="fa fa-search"></i> <span>Back To Search Candidate</span>
                				</a>
                	</div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="employeeList" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Resume</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
	                    @forelse($candidate_resumes as $candidate)
		                      <tr>
                            <td>
                                {{$candidate->candidate->first_name." ".$candidate->candidate->last_name}}
                            </td>
                            <td>
                                {{$candidate->candidate->email}}
                            </td>
                            <td>
                                <p>{{str_replace("<br />", "", substr($candidate->resume, 0, 80))."..."}}</p>
                            </td>
		                        <td>
		                        	<a href="{{ URL::route('view-candidate', array('id' => $candidate->candidate_id, 'jobId' => $jobId )) }}" title="View Profile"><i class="fa fa-fw fa-eye"></i>View |</a>
                              @if(Auth::user()->getRole() <= 3)
                              <a href="{{'/uploads/resumes/'.$candidate->candidate_id.'/'.$candidate->resume_path}}" title="Download Resume"><i class="glyphicon glyphicon-download"></i>Download |</a>
                              @endif
                              <a href="{{ URL::route('job-submittel', array('jobId' => $jobId, 'userId' => $candidate->candidate_id)) }}" title="Mark Submittel"><i class="fa fa-fw fa-save"></i>Submittel</a>
		                        </td>
		                      </tr>
	                   	@empty
	                   		<p>No Candidate</p>
						@endforelse
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Resume</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

@stop
