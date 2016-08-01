<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Routes For REST API for New Payment Form.
 */
Route::match(array('GET'), '/', array(
		'as'    =>    'login-view',
		'uses'    =>    'UserController@loginView'
));

/**
 * Routes For REST API for New Payment Form.
 */
Route::match(array('GET'), 'login', array(
	'as'    =>    'login-views',
	'uses'    =>    'UserController@loginView'
));

/**
 * Routes For REST API for New Payment Form.
 */
Route::match(array('POST'), 'login', array(
		'as'    =>    'login-member',
		'uses'    =>    'UserController@login'
), array('before' => 'csrf', function(){}));


Route::group(array('before' => 'auth'), function() {


	/**
	 * Routes for post-requirement
	 */
	Route::match(array('POST'), '/get-assignee', array(
			'as'    =>    'get-assignee',
			'uses'    =>    'UserController@postRequirement'
	));

	/**
	 * Routes For REST API for New Payment Form.
	 */
	Route::match(array('GET'), 'logout', array(
			'as'    =>    'logout-member',
			'uses'    =>    'UserController@logout'
	));
	/**
	 * Routes For REST API for New Payment Form.
	 */
	Route::match(array('GET'), 'dashboard', array(
			'as'    =>    'dashboard-view',
			'uses'    =>    'UserController@home'
	));
	
	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/add-employee', array(
			'as'    =>    'add-employee',
			'uses'    =>    'UserController@addEmployee'
	));
	
	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('POST'), '/add-employee', array(
			'as'    =>    'add-member',
			'uses'    =>    'UserController@addEmp'
	));
	
	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/delete-employee/{id}', array(
			'as'    =>    'delete-member',
			'uses'    =>    'UserController@deleteEmp'
	));
	
	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/edit-employee/{id}', array(
			'as'    =>    'edit-member',
			'uses'    =>    'UserController@editEmp'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('POST'), '/edit-employee/{id}', array(
			'as'    =>    'update-member',
			'uses'    =>    'UserController@updateEmp'
	));

	/**
	 * Routes For REST API for states
	 */
	Route::match(array('GET'), '/states/{id}', array(
			'as'    =>    'get-states',
			'uses'    =>    'UserController@getStates'
	));

	/**
	 * Routes For REST API for states
	 */
	Route::match(array('GET'), '/peers/{id}', array(
			'as'    =>    'get-peers',
			'uses'    =>    'UserController@getPeers'
	));

	/**
	 * Routes For REST API for states
	 */
	Route::match(array('GET'), '/team', array(
			'as'    =>    'peers',
			'uses'    =>    'UserController@getTeam'
	));

	/**
	 * Routes For REST API for states
	 */
	Route::match(array('GET'), '/cities/{id}', array(
			'as'    =>    'get-cities',
			'uses'    =>    'UserController@getCities'
	));

	
	/**
	 * Routes For REST API for Change Password
	 */
	Route::match(array('GET'), '/change-password/{id}', array(
			'as'    =>    'change-password',
			'uses'    =>    'UserController@updatePassView'
	));
	
	/**
	 * Routes For REST API for Change Password
	 */
	Route::match(array('POST'), '/change-password/{id}', array(
			'as'    =>    'update-password',
			'uses'    =>    'UserController@updatePass'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('POST'), '/edit-employee/{id}', array(
			'as'    =>    'update-member',
			'uses'    =>    'UserController@updateEmp'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/view-employee/{id}', array(
		'as'    =>    'view-member',
		'uses'    =>    'UserController@viewEmp'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/employees', array(
			'as'    =>    'employee-list',
			'uses'    =>    'UserController@employeeList'
	));
	
	
	/**
	 * Routes for post-requirement
	 */
	Route::match(array('GET'), '/post-requirement', array(
			'as'    =>    'post-requirement',
			'uses'    =>    'SaleController@postRequirementView'
	));
	
	/**
	 * Routes for post-requirement
	 */
	Route::match(array('GET'), '/edit-requirement/{id}', array(
			'as'    =>    'edit-requirement',
			'uses'    =>    'SaleController@editRequirementView'
	));
	
	/**
	 * Routes for list-requirement
	 */
	Route::match(array('GET'), '/list-requirement', array(
			'as'    =>    'list-requirement',
			'uses'    =>    'SaleController@listRequirement'
	));
	
	/**
	 * Routes for list-requirement
	 */
	Route::match(array('GET'), '/assigned-requirement/{id?}', array(
			'as'    =>    'assigned-requirement',
			'uses'    =>    'SaleController@listRequirement'
	));
	
	/**
	 * Routes for list-requirement
	 */
	Route::match(array('GET'), '/delete-requirement/{id}', array(
			'as'    =>    'delete-requirement',
			'uses'    =>    'SaleController@deleteRequirement'
	));

	/**
	 * Routes for list-requirement
	 */
	Route::match(array('GET'), '/assign-requirement/{id}/{assignedTo?}', array(
			'as'    =>    'assign-requirement',
			'uses'    =>    'SaleController@assignRequirement'
	));
	
	/**
	 * Routes for post-requirement
	 */
	Route::match(array('POST'), '/post-requirement', array(
			'as'    =>    'post-requirement-action',
			'uses'    =>    'SaleController@postRequirement'
	));

	/**
	 * Routes for post-requirement
	 */
	Route::match(array('POST'), '/update-requirement/{id}', array(
			'as'    =>    'update-requirement-action',
			'uses'    =>    'SaleController@updateRequirement'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/advance-search', array(
			'as'    =>    'advance-search',
			'uses'    =>    'SearchController@advanceSearch'
	));

	/** ANKUR BHATI **/


	/**
	 * Routes For REST API for new Client
	 */
	Route::match(array('GET'), '/add-client', array(
			'as'    =>    'add-client',
			'uses'    =>    'ClientController@create'
	));
	
	/**
	 * Routes For REST API for new Client
	 */
	Route::match(array('POST'), '/add-client', array(
			'as'    =>    'add-client',
			'uses'    =>    'ClientController@createClient'
	));

	/**
	 * Routes For REST API for new Client
	 */
	Route::match(array('GET'), '/clients', array(
			'as'    =>    'client-list',
			'uses'    =>    'ClientController@clientList'
	));

	/**
	 * Routes For REST API for new Client
	 */
	Route::match(array('GET'), '/view-client/{id}', array(
		'as'    =>    'view-client',
		'uses'    =>    'ClientController@viewClient'
	));

	/**
	 * Routes For REST API for edit Client
	 */
	Route::match(array('GET'), '/edit-client/{id}', array(
			'as'    =>    'edit-client',
			'uses'    =>    'ClientController@editClient'
	));

	/**
	 * Routes For REST API for edit Client
	 */
	Route::match(array('POST'), '/edit-client/{id}', array(
			'as'    =>    'update-client',
			'uses'    =>    'ClientController@updateClient'
	));

	/**
	 * Routes For REST API for new Employee
	 */
	Route::match(array('GET'), '/delete-client/{id}', array(
			'as'    =>    'delete-client',
			'uses'    =>    'ClientController@deleteClient'
	));


	/**
	 * Routes For REST API for new Vendor
	 */
	Route::match(array('GET'), '/add-vendor', array(
			'as'    =>    'add-vendor',
			'uses'    =>    'VendorController@create'
	));
	
	/**
	 * Routes For REST API for new Vendor
	 */
	Route::match(array('POST'), '/add-vendor', array(
			'as'    =>    'add-vendor',
			'uses'    =>    'VendorController@createVendor'
	));

	/**
	 * Routes For REST API for new Vendor
	 */
	Route::match(array('GET'), '/vendors', array(
			'as'    =>    'vendor-list',
			'uses'    =>    'VendorController@vendorList'
	));

	/**
	 * Routes For REST API for new Vendor
	 */
	Route::match(array('GET'), '/view-vendor/{id}', array(
		'as'    =>    'view-vendor',
		'uses'    =>    'VendorController@viewVendor'
	));

	/**
	 * Routes For REST API for edit Vendor
	 */
	Route::match(array('GET'), '/edit-vendor/{id}', array(
			'as'    =>    'edit-vendor',
			'uses'    =>    'VendorController@editVendor'
	));

	/**
	 * Routes For REST API for edit Vendor
	 */
	Route::match(array('POST'), '/edit-vendor/{id}', array(
			'as'    =>    'update-vendor',
			'uses'    =>    'VendorController@updateVendor'
	));

	/**
	 * Routes For REST API for new Vendor
	 */
	Route::match(array('GET'), '/delete-vendor/{id}', array(
			'as'    =>    'delete-vendor',
			'uses'    =>    'VendorController@deleteVendor'
	));

	Route::match(array('GET'), 'test', array(
			'as'    =>    'test',
			'uses'    =>    'CandidateController@test'
	));

		/**
	 * Routes For REST API for new Candidate
	 */
	Route::match(array('GET'), '/add-candidate', array(
			'as'    =>    'add-candidate',
			'uses'    =>    'CandidateController@create'
	));
	
	/**
	 * Routes For REST API for new Candidate
	 */
	Route::match(array('POST'), '/add-candidate', array(
			'as'    =>    'add-candidate',
			'uses'    =>    'CandidateController@createCandidate'
	));

	/**
	 * Routes For REST API for new Candidate
	 */
	Route::match(array('GET'), '/candidates', array(
			'as'    =>    'candidate-list',
			'uses'    =>    'CandidateController@candidateList'
	));

	/**
	 * Routes For REST API for new Candidate
	 */
	Route::match(array('GET'), '/view-candidate/{id}', array(
		'as'    =>    'view-candidate',
		'uses'    =>    'CandidateController@viewCandidate'
	));

	/**
	 * Routes For REST API for edit Candidate
	 */
	Route::match(array('GET'), '/edit-candidate/{id}', array(
			'as'    =>    'edit-candidate',
			'uses'    =>    'CandidateController@editCandidate'
	));

	/**
	 * Routes For REST API for edit Candidate
	 */
	Route::match(array('POST'), '/edit-candidate/{id}', array(
			'as'    =>    'update-candidate',
			'uses'    =>    'CandidateController@updateCandidate'
	));

	/**
	 * Routes For REST API for new Candidate
	 */
	Route::match(array('GET'), '/delete-candidate/{id}', array(
			'as'    =>    'delete-candidate',
			'uses'    =>    'CandidateController@deleteCandidate'
	));
	/** ANKUR BHATI **/
});
