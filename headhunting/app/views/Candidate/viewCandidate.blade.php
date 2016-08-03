@extends('layouts.adminLayout')
@section('content')
<div class="row user-view">
	<div class="col-sm-4 left-view">
		<div class="image text-center">
			<img class="img-circle" alt="User Image" src="../dist/img/user2-160x160.jpg">
		</div>
	</div>
	<div class="col-sm-8 right-view">
	    <div class="row"><div class="col-sm-4">
	        Email:
	        </div><div class="col-sm-8">
	        	{{$candidate->email}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        First Name:
	        </div><div class="col-sm-8">
	        	{{$candidate->first_name}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Last Name:
	        </div><div class="col-sm-8">
	        	{{$candidate->last_name}}
	        </div>
	    </div>

	    <div class="row"><div class="col-sm-4">
	        Phone:
	        </div><div class="col-sm-8">
	        	{{$candidate->phone}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Date Of Birth:
	        </div><div class="col-sm-8">
	        	{{$candidate->dob}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        City:
	        </div><div class="col-sm-8">
	        	{{$candidate->city->name}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        State:
	        </div><div class="col-sm-8">
	        	{{$candidate->state->state}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Country:
	        </div><div class="col-sm-8">
	        	{{$candidate->country->country}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Zipcode:
	        </div><div class="col-sm-8">
	        	{{$candidate->zipcode}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Address:
	        </div><div class="col-sm-8">
	        	{{$candidate->address}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Ssn:
	        </div><div class="col-sm-8">
	        	{{$candidate->ssn}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Visa:
	        </div><div class="col-sm-8">
	        	{{$candidate->visa->title}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Vendor:
	        </div><div class="col-sm-8">
	        	{{$candidate->vendor->vendor_domain}}
	        </div>
	    </div>
		<div class="row"><div class="col-sm-4">
	        Created By:
	        </div><div class="col-sm-8">
	        	{{$candidate->createdby->first_name. " ".$candidate->createdby->last_name }}
	        </div>
	    </div>    
	    <div class="row"><div class="col-sm-4">
	        Created At:
	        </div><div class="col-sm-8">
	        	{{($candidate->created_at != "" && $candidate->created_at != "0000-00-00 00:00:00")?date("Y-m-d", strtotime($candidate->created_at)):"-"}}
	        </div>
	    </div>
	    <div class="row"><div class="col-sm-4">
	        Last Updated At:
	        </div><div class="col-sm-8">
	        	{{($candidate->updated_at != "" && $candidate->updated_at != "0000-00-00 00:00:00")?date("Y-m-d", strtotime($candidate->updated_at)):"-"}}
	        </div>
	    </div>
	    @if($resume)
        	<div class="row"><div class="col-sm-4">
	        Resume:
	        </div><div class="col-sm-8">
	        	{{htmlspecialchars_decode($resume->resume)}}
	        </div>
	    </div>
        @else
        @endif
	</div>
</div>
@stop