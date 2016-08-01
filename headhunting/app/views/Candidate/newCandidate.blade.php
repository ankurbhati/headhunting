@extends('layouts.adminLayout')
@section('content')
<div class="content">
{{ Form::open(array('route' => 'add-candidate','class' =>
'form-horizontal','id' => 'login-form',  'method' => 'POST')) }}

    <div class="form-group">
        {{ Form::label('email', 'E-Mail: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('email', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidate Email')); }} 
            <span class='errorlogin email-login'>{{$errors->first('email');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('first_name', 'First Name: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('first_name', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates First Name')); }} 
            <span class='errorlogin email-login'>{{$errors->first('first_name');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('last_name', 'Last Name: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('last_name', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates Last Name')); }} 
            <span class='errorlogin email-login'>{{$errors->first('last_name');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('dob', 'Date Of Birth: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('dob', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates date of birth')); }} 
            <span class='errorlogin email-login'>{{$errors->first('dob');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('Password', 'Password: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter Candidate Password')); }} 
            <span class='errorlogin password-login'>{{$errors->first('password');}}</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Confirm Password', 'ConfirmPassword: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">
            {{ Form::password('confirm_password', array('class' => 'form-control', 'placeholder' => 'Confirm Password')); }} 
            <span class='errorlogin password-login'>{{$errors->first('confirm_password');}}</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('phone', 'Phone: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('phone', "", array('class' => 'form-control', 'placeholder' => 'ex. (704) 888-9999', "data-inputmask"=>'"mask": "(999) 999-9999"', "data-mask")); }} 
            <span class='errorlogin email-login'>{{$errors->first('phone');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('country_id', 'Country: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::select('country_id', $country, null, array('class' => 'form-control')) }} 
            <span class='errorlogin email-login'>{{$errors->first('country_id');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('state_id', 'State: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::select('state_id', $state, null, array('class' => 'form-control')) }} 
            <span class='errorlogin email-login'>{{$errors->first('state_id');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('citi_id', 'Citi: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::select('citi_id', $city, null, array('class' => 'form-control')) }} 
            <span class='errorlogin email-login'>{{$errors->first('country_id');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('zipcode', 'Zipcode: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('zipcode', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates zipcode')); }} 
            <span class='errorlogin email-login'>{{$errors->first('zipcode');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('address', 'Address: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('address', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates Address')); }} 
            <span class='errorlogin email-login'>{{$errors->first('address');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('ssn', 'SSN: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::text('ssn', "", array('class' =>
            'form-control', 'placeholder' => 'Enter Candidates ssn')); }} 
            <span class='errorlogin email-login'>{{$errors->first('ssn');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('visa_id', 'Visa: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::select('visa_id', $visa, null, array('class' => 'form-control')) }} 
            <span class='errorlogin email-login'>{{$errors->first('visa_id');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('vendor_id', 'Vendor: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8">{{ Form::select('vendor_id', $vendor, null, array('class' => 'form-control')) }} 
            <span class='errorlogin email-login'>{{$errors->first('vendor_id');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('resume', 'Upload Resume: ', array('class' => 'col-sm-3
        control-label')); }}
        <div class="col-sm-8"><input type="file" class="form-control">
            <span class='errorlogin email-login'>{{$errors->first('resume');}}@if(!empty($message)){{$message}}@endIf</span>
        </div>
    </div>
    <div class="form-group row ">
        <div class="col-sm-11">{{ Form::submit('Add Candidate', array('class' => 'btn
            btn-info pull-right', 'id' => 'login-button') ); }}</div>

   </div>
{{ Form::close() }}
</div>
@stop