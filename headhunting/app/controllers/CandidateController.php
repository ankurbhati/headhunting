<?php

class CandidateController extends \BaseController {


	private $resume_target_dir = 'uploads/resumes/';
	private $resume_size = 50000;


	/**
	 * Show the form for creating a new Vendor.
	 *
	 * @return Response
	 */
	public function create()
	{
		$country = Country::all()->lists('country', 'id');
		$visa = Visa::all()->lists('title', 'id');
		//$vendor = Vendor::all()->lists('vendor_domain', 'id');
		$work_states = WorkStates::all()->lists('title', 'id');

		return View::make('Candidate.newCandidate')->with(array('title' => 'Add Candidate', 'country' => $country, 'visa' => $visa//, 'vendor' => $vendor
			, 'work_state' => $work_states));
	}


	/**
	 * Show the form for creating a new Vendor.
	 *
	 * @return Response
	 */
	public function createCandidate()
	{

		if(Auth::user()->getRole() <= 3) {
			Validator::extend('has', function($attr, $value, $params) {
	
				if(!count($params)) {
					
					throw new \InvalidArgumentException('The has validation rule expects at least one parameter, 0 given.');
				}
				
				foreach ($params as $param) {
					switch ($param) {
						case 'num':
							$regex = '/\pN/';
							break;
						case 'letter':
							$regex = '/\pL/';
							break;
						case 'lower':
							$regex = '/\p{Ll}/';
							break;
						case 'upper':
							$regex = '/\p{Lu}/';
							break;
						case 'special':
							$regex = '/[\pP\pS]/';
							break;
						default:
							$regex = $param;
					}
	
					if(! preg_match($regex, $value)) {
						return false;
					}
				}
	
				return true;
			});
			
			// Server Side Validation.
			$validate=Validator::make (
				Input::all(), array(
						'email' => 'required|email|max:50|email|unique:candidates,email',
						'first_name' => 'max:50',
						'last_name' => 'max:50',
						'phone' => 'max:14',
						//'password' =>  'min:6',
						//'confirm_password' =>  'min:6|same:password',
						//'dob' => 'required',
						'city' => 'max:100',
						'country_id' => 'max:9',
						'state_id' => 'max:9',
						'zipcode' => 'max:10',
						'address' => 'max:247',
						'ssn' => 'max:247|unique:candidates,ssn',
						'visa_id' => 'max:1'
						//'vendor_id' => 'required'
				)
			);
	
			if($validate->fails()) {

				return Redirect::to('add-candidate')
							   ->withErrors($validate)
							   ->withInput();
			} else {
				$fileType = false;
				//resume
				if(isset($_FILES['resume']['tmp_name']) && !empty($_FILES['resume']['tmp_name'])) {
					
					list($msg, $fileType) = $this->check_resume_validity();
					if($msg){
						# error
						Session::flash('resume_error', $msg); 
						return Redirect::route('add-candidate')->withInput();
					} else {
						# No error
						$resume_upload = true;
					}
				}
				
				$ssn = Input::get('ssn');
				$candidate = new Candidate();
				$candidate->email = Input::get('email');
				$candidate->first_name = Input::get('first_name');
				$candidate->last_name = Input::get('last_name');
				$candidate->phone = Input::get('phone');
				$candidate->dob = date('Y-m-d', strtotime(Input::get('dob')));
				$candidate->country_id = Input::get('country_id');
				$candidate->state_id = Input::get('state_id');
				$candidate->zipcode = Input::get('zipcode');
				$candidate->address = Input::get('address');
				$candidate->ssn = !empty($ssn) ? $ssn : Null;
				$candidate->visa_id = Input::get('visa_id');
				$candidate->work_state_id = Input::get('work_state_id');
				$candidate->visa_expiry = date('Y-m-d', strtotime(Input::get('visa_expiry')));
				//$candidate->vendor_id = Input::get('vendor_id');
				$candidate->added_by = Auth::user()->id;
				
				$city = Input::get('city');

				if(isset($city) && !empty($city)) {
					$city_record = City::where('name', 'like', $city)->first();

					if($city_record) {
						$candidate->city_id = $city_record->id;
					} else {

						$city_obj = new City();
						$city_obj->name = $city;
						$city_obj->save();
						$candidate->city_id = $city_obj->id;
					}

				}

				/*$password = Input::get('password');
				// Changing Password to Hash
				if(isset($password) && !empty($password)) {
					$candidate->password = Hash::make($password);
				}*/


				// Checking Authorised or not
				try {
					if($candidate->save()) {
						//resume
						if($fileType) {
							list($msg, $target_file) = $this->upload_resume($candidate);
							if($msg) {
								//error, delete candidate or set flash message
							} else {
								$candidate_resume = new CandidateResume();
								$candidate_resume->candidate_id = $candidate->id;
								$candidate_resume->resume = ($fileType == "doc") ? $this->read_doc($target_file) : $this->read_docx($target_file);
								if(!$candidate_resume->save()){
									//error, delete candidate or set flash message
								};
							}
						}
						return Redirect::route('candidate-list');
					} else {
					
						return Redirect::route('add-candidate')->withInput();
					}

				} catch(Exception $e) {
					
					return Redirect::route('add-candidate')->withInput();
				}

			}

		}

	}


	/**
	 *
	 * vendorList() : Vendor List
	 *
	 * @return Object : View
	 *
	 */
	public function candidateList() {
		$candidates = Candidate::all();
		return View::make('Candidate.candidateList')->with(array('title' => 'Candidates List', 'candidates' => $candidates));
	}


	/**
	 *
	 * viewCandidate() : View Candidate
	 *
	 * @return Object : View
	 *
	 */
	public function viewCandidate($id) {

		if(Auth::user()->getRole() <= 3) {

			$candidate = Candidate::with(array('visa', 'createdby', 'city', 'state', 'country', 'workstate'))->where('id', '=', $id)->get();

			if(!$candidate->isEmpty()) {
				$candidate = $candidate->first();
				$resume = CandidateResume::where('candidate_id', $candidate->id)->first();
				return View::make('Candidate.viewCandidate')
						   ->with(array('title' => 'View Candidate', 'candidate' => $candidate, 'resume' => $resume));
			} else {

				return Redirect::route('dashboard-view');
			}

		} else {
			return Redirect::route('dashboard-view');
		}
	}


	/**
	 *
	 * editCandidate() : Edit Candidate
	 *
	 * @return Object : View
	 *
	 */
	public function editCandidate($id) {

		if(Auth::user()->getRole() <= 3) {

			$country = Country::all()->lists('country', 'id');
			$visa = Visa::all()->lists('title', 'id');
			$work_states = WorkStates::all()->lists('title', 'id');
			//$vendor = Vendor::all()->lists('vendor_domain', 'id');

			$candidate = Candidate::with(array('visa', 'createdby', 'city', 'state', 'country', 'workstate'))->where('id', '=', $id)->get();

			if(!$candidate->isEmpty()) {
				$candidate = $candidate->first();
				$resume = CandidateResume::where('candidate_id', $candidate->id)->first();
				return View::make('Candidate.editCandidate')
						   ->with(
						   		array('title' => 'Edit Candidate', 'candidate' => $candidate, 'resume' => $resume, 'country' => $country, 'visa' => $visa,
						   			'work_state' => $work_states
						   			//, 'vendor' => $vendor
				));
			} else {

				return Redirect::route('dashboard');
			}

		} else {

			return Redirect::route('dashboard');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateCandidate($id)
	{
		if(Auth::user()->getRole() <= 3) {
			Validator::extend('has', function($attr, $value, $params) {
		
				if(!count($params)) {
		
					throw new \InvalidArgumentException('The has validation rule expects at least one parameter, 0 given.');
				}
		
				foreach ($params as $param) {
					switch ($param) {
						case 'num':
							$regex = '/\pN/';
							break;
						case 'letter':
							$regex = '/\pL/';
							break;
						case 'lower':
							$regex = '/\p{Ll}/';
							break;
						case 'upper':
							$regex = '/\p{Lu}/';
							break;
						case 'special':
							$regex = '/[\pP\pS]/';
							break;
						default:
							$regex = $param;
					}

					if(! preg_match($regex, $value)) {
						return false;
					}
				}

				return true;
			});
			
			// Server Side Validation.
			$validate=Validator::make (
				Input::all(), array(
						'email' => 'required|email|max:50|email',
						'first_name' => 'max:50',
						'last_name' => 'max:50',
						'phone' => 'max:14',
						//'password' =>  'min:6',
						//'confirm_password' =>  'min:6|same:password',
						//'dob' => 'required',
						'city' => 'max:100',
						'country_id' => 'max:9',
						'state_id' => 'max:9',
						'zipcode' => 'max:10',
						'address' => 'max:247',
						'ssn' => 'max:247',
						'visa_id' => 'max:1',
						//'vendor_id' => 'required'
				)
			);
			if($validate->fails()) {
				
				return Redirect::route('edit-candidate', array('id' => $id))
								->withErrors($validate)
								->withInput();
			} else {

				$fileType = false;
				//resume
				if(isset($_FILES['resume']['tmp_name']) && !empty($_FILES['resume']['tmp_name'])) {
					list($msg, $fileType) = $this->check_resume_validity();
					if($msg){
						# error
						Session::flash('resume_error', $msg); 
						return Redirect::route('edit-candidate')->withInput();
					} else {
						# No error
						$resume_upload = true;
					}
				}
				
				$candidate = Candidate::find($id);

				$email = Input::get('email');
				if($email && $email != $candidate->email){
					if(!Candidate::where('email', '=', $email)->get()->isEmpty()) {
						return Redirect::route('edit-candidate', array('id' => $id))
						               ->withInput()
									   ->withErrors(array('email' => "Email is already in use"));
					}
					$candidate->email = $email;
				}

				$ssn = Input::get('ssn');
				if($ssn != $candidate->ssn){
					if(!Candidate::where('ssn', '=', $ssn)->get()->isEmpty()) {
						return Redirect::route('edit-candidate', array('id' => $id))
						               ->withInput()
									   ->withErrors(array('ssn' => "ssn is already in use"));
					}
				}
				$candidate->ssn = !empty($ssn) ? $ssn : Null;
				
				$candidate->first_name = Input::get('first_name');
				$candidate->last_name = Input::get('last_name');
				$candidate->phone = Input::get('phone');
				$candidate->dob = date('Y-m-d', strtotime(Input::get('dob')));
				$candidate->country_id = Input::get('country_id');
				$candidate->state_id = Input::get('state_id');
				$candidate->zipcode = Input::get('zipcode');
				$candidate->address = Input::get('address');
				$candidate->visa_id = Input::get('visa_id');
				$candidate->work_state_id = Input::get('work_state_id');
				$candidate->visa_expiry = date('Y-m-d', strtotime(Input::get('visa_expiry')));
				//$candidate->vendor_id = Input::get('vendor_id');
				$candidate->added_by = Auth::user()->id;
			
				$city = Input::get('city');

				if(isset($city) && !empty($city)) {
					$city_record = City::where('name', 'like', $city)->first();

					if($city_record) {
						$candidate->city_id = $city_record->id;
					} else {

						$city_obj = new City();
						$city_obj->name = $city;
						$city_obj->save();
						$candidate->city_id = $city_obj->id;
					}

				}

				/*$password = Input::get('password');
				// Changing Password to Hash
				if(isset($password) && !empty($password)) {
					$candidate->password = Hash::make($password);
				}*/


				// Checking Authorised or not
				try {
					if($candidate->save()) {
						//resume
						if($fileType) {
							list($msg, $target_file) = $this->upload_resume($candidate);
							if($msg) {
								//error, delete candidate or set flash message
							} else {
								$candidate_resume = CandidateResume::where('candidate_id', '=', $candidate->id)->first();
								if(!$candidate_resume) {
									print 'In new candidate';
									$candidate_resume = new CandidateResume();
								}
								$candidate_resume->candidate_id = $candidate->id;
								$candidate_resume->resume = ($fileType == "doc") ? $this->read_doc($target_file) : $this->read_docx($target_file);
								if(!$candidate_resume->save()){
									//error, delete candidate or set flash message
								};
							}
						}
						return Redirect::route('candidate-list');
					} else {
					
						return Redirect::route('edit-candidate')->withInput();
					}

				} catch(Exception $e) {
					
					return Redirect::route('edit-candidate')->withInput();
				}
			}
		}
	}


	/**
	 *
	 * deleteCandidate() : Delete Candidate
	 *
	 * @return Object : View
	 *
	 */
	public function deleteCandidate($id) {
		if(Auth::user()->getRole() <= 3) {
			if(Candidate::find($id)->delete()) {
				return Redirect::route('candidate-list');
			}
		}
	}


	private function read_doc($file){
		$fileHandle = fopen($file, "r");
        $line = @fread($fileHandle, filesize($file));
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0)) {
            } else {
            	$outtext .= htmlspecialchars($thisline."<br />", ENT_QUOTES);
            }
        }

        return $outtext;
        //return $striped_content(htmlspecialchars_decode($outtext));
	}

	private function read_docx($file){

        $striped_content = '';
        $content = '';

        $zip = zip_open($file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            //$content = $content.zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))."<br />";

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);
        
        return $striped_content;
    }


	private function check_resume_validity(){
		$msg = false;
		$fileType = pathinfo($_FILES["resume"]["name"],PATHINFO_EXTENSION);

		// Check file size
		if ($_FILES["resume"]["size"] > $this->resume_size) {
		    $msg = "Sorry, your file is too large.";
		}

		// Allow certain file formats
		if($fileType != "doc" && $fileType != "docx") {
		    $msg = "Sorry, only doc, docx files are allowed.";
		}

		return array($msg, $fileType);
	}

	private function upload_resume($candidate) {
		$msg = false;
		$target_dir = DOCROOT.$this->resume_target_dir.$candidate->id.'/';
		$target_file = $target_dir . basename($_FILES["resume"]["name"]);

		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		// if everything is ok, try to upload file
	    if (!move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
	        $msg = "Sorry, there was an error uploading your file.";
	    }
	
		return array($msg, $target_file);	
	}

}
