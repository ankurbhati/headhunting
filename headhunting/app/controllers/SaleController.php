<?php
/**
 * SaleController.php
 *
 * This file contatins controller class to provide APIs for Users
 *
 * @category   Controller
 * @package    User Management
 * @version    SVN: <svn_id>
 * @since      29th May 2014
 *
 */

/**
 * Contrller class will be responsible for All User management Related Actions
 *
 * @category   Controller
 * @package    User Management
 *
 */
class SaleController extends HelperController {

	/**
	 *
	 * postRequirement() : postRequirement
	 *
	 * @return Object : View
	 *
	 */
	public function postRequirementView() {
		if(Auth::user()->getRole() <= 2) {
			$jobPost = new JobPost();
			$country = Country::all();
			
			$count = array();
			foreach( $country as $key => $value) {
				$count[$value->id] = $value->country;
			}

			$clients = Client::all();
			$client = array();
			foreach( $clients as $key => $value) {
				$client[$value->id] = $value->first_name."-".$value->email;
			}

			$vendors = Vendor::all();
			$vendor = array();
			foreach( $vendors as $key => $value) {
				$vendor[$value->id] = $value->vendor_domain."-".$value->email;
			}

			return View::make('sales.postRequirement')->with(array('title' => 'Post Requirement - Headhunting', 'country' => $count, 'jobPost' => $jobPost, 'client' => $client, 'vendor' => $vendor));
		} else {
			return Redirect::to('dashboard');
		}
	}

	/**
	 *
	 * assignRequirement() : assignRequirement
	 *
	 * @return Object : View
	 *
	 */
	public function assignRequirement($id, $assignedTo = "") {
		$jobPostAssignment = new JobPostAssignment();
		$jobPostAssignment->setConnection("master");
		$jobPostAssignment->job_post_id = $id;
		$jobPostAssignment->assigned_by_id = Auth::user()->id;
		$jobPostAssignment->assigned_to_id = ($assignedTo == "")?$jobPostAssignment->assigned_by_id:$assignedTo;
		$jobPostAssignment->status = 2;
		if($jobPostAssignment->save()) {
			if(Auth::user()->id == $jobPostAssignment->assigned_to_id) {

				return Redirect::route('assigned-requirement', array($jobPostAssignment->assigned_to_id));
			} else {
				return Redirect::route('list-requirement');
			}
		} else {
			return Redirect::to('dashboard')->with(array("message" => "error"));
		}
	}
	/**
	 *
	 * listRequirement() : listRequirement
	 *
	 * @return Object : View
	 *
	 */
	public function deleteRequirement($id) {
		if(Auth::user()->getRole() <= 3) {
			$jobPost = JobPost::find($id)->delete();
		}
		return Redirect::route('list-requirement');
	}

	/**
	 *
	 * viewRequirement() : viewRequirement
	 *
	 * @return Object : View
	 *
	 */
	public function viewRequirement($id) {
		$jobPost = JobPost::with(array('country', 'state', 'client', 'vendor', 'city'))->find($id);
		return View::make('sales.viewRequirement')->with(array('title' => 'View Requirement - Headhunting', 'jobPost' => $jobPost,));
	}

	/**
	 *
	 * listRequirement() : listRequirement
	 *
	 * @return Object : View
	 *
	 */
	public function listRequirement($id=0) {
		if($id == 0) {
			$jobPost = JobPost::all();
		} else {
			$jobPost = JobPost::with(array('country', 'state', 'client'))->whereHas('jobsAssigned', function($q) use ($id)
			{
			    $q->where('assigned_to_id','=', $id);
			})->get();
		}
		return View::make('sales.listRequirements')->with(array('title' => 'List Requirement - Headhunting', 'jobPost' => $jobPost, 'id' => $id));
	}

	/**
	 * postRequirement() :  Post Requirements
	 *
	 * @param String Email : REQUIRED Email
	 * @param String Password : REQUIRED User Password
	 * @param Integer type : OPTIONAL TYPE of User Account.
	 *
	 * @return Object Json
	 */
	public function postRequirement() {

		if(Auth::user()->getRole() <= 3) {
			// Server Side Validation.
			$validate=Validator::make (
					Input::all(), array(
							'title' =>  'required|max:50',
							'type_of_employment' => 'required|numeric',
							'client_name' => 'required|max:50',
							'country_id' => 'required',
							'state_id' =>  'required',
							'description' =>  'required|max:1000',
					)
			);

			if($validate->fails()) {

				return Redirect::to('post-requirement')
								->withErrors($validate)
								->withInput();
			} else {

				$inputs = Input::except(array('_token', '_wysihtml5_mode'));
				$jobPost = new JobPost();
				$jobPost->setConnection('master');
				foreach($inputs as $key => $value) {
					$jobPost->$key = $value;
				}
				$jobPost->created_by = Auth::user()->id;
				$jobPost->status = 2;

				if($jobPost->save()) {
					return Redirect::route('list-requirement');
				} else {
					return Redirect::route('post-requirement')->withInput();
				}
			}
		}
	}

	/**
	 * updateRequirement() :  Update Requirements
	 *
	 * @param String Email : REQUIRED Email
	 * @param String Password : REQUIRED User Password
	 * @param Integer type : OPTIONAL TYPE of User Account.
	 *
	 * @return Object Json
	 */
	public function updateRequirement($id) {
		if($id != "") {
			$jobPost = JobPost::find($id);
		}
		if(Auth::user()->getRole() <= 3 && !empty($jobPost) && Auth::user()->id == $jobPost->created_by) {
			// Server Side Validation.
			$validate=Validator::make (
					Input::all(), array(
							'title' =>  'required|max:50',
							'type_of_employment' => 'required|numeric',
							'client_name' => 'required|max:50',
							'country_id' => 'required',
							'state_id' =>  'required',
							'description' =>  'required|max:1000',
					)
			);

			if($validate->fails()) {

				return Redirect::to('post-requirement')
				->withErrors($validate)
				->withInput();
			} else {

				$inputs = Input::except(array('_token', '_wysihtml5_mode', 'status', 'created_by'));
				$jobPost->setConnection('master');
				foreach($inputs as $key => $value) {
					$jobPost->$key = $value;
				}
				$jobPost->created_by = Auth::user()->id;
				$jobPost->status = $jobPost->status;

				if($jobPost->save()) {
					return Redirect::route('list-requirement');
				} else {
					return Redirect::route('post-requirement', array($id))->withInput();
				}
			}
		}
	}


	/**
	 *
	 * editRequirementView() : editRequirementView
	 *
	 * @return Object : View
	 *
	 */
	public function editRequirementView($id) {
		if($id != "") {
			$jobPost = JobPost::find($id);
		}
		if(Auth::user()->getRole() <= 2 && !empty($jobPost) && Auth::user()->id == $jobPost->created_by) {
			$country = Country::all();
			$count = array();
			foreach( $country as $key => $value) {
				$count[$value->id] = $value->country;
			}
			return View::make('sales.postRequirement')->with(array('title' => 'Post Requirement - Headhunting', 'country' => $count, 'jobPost' => $jobPost));
		} else {
			return Redirect::to('dashboard');
		}
	}

}
