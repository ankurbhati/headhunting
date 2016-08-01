<?php

class CandidateController extends \BaseController {


	/**
	 * Show the form for creating a new Vendor.
	 *
	 * @return Response
	 */
	public function create()
	{
		$city = City::all();
		$countries = Country::all();
		$country = array();
		foreach( $countries as $key => $value) {
			$country[$value->id] = $value->country;
		}
		$state = State::all();
		$visa = ['0' => 'No Visa', '1' => 'H1', '2'=>'L1', '3' => 'Business'];
		$vendor = Vendor::all();
		return View::make('Candidate.newCandidate')->with(array('title' => 'Add Candidate', 'city' => $city, 'country' => $country, 'state' => $state, 'visa' => $visa, 'vendor' => $vendor));
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
							'email' =>  'required|max:50|email|unique:clients,email',
							'vendor_domain' => 'required|max:50',
							'phone' => 'max:14',
							'partner' => 'max:1'
					)
			);
	
			if($validate->fails()) {

				return Redirect::to('add-candidate')
							   ->withErrors($validate)
							   ->withInput();
			} else {

				$vendor = new Vendor();
				$vendor->vendor_domain = Input::get('vendor_domain');
				$vendor->email = Input::get('email');
				$vendor->phone = Input::get('phone');
				$vendor->partner = Input::get('partner');
				$vendor->created_by = Auth::user()->id;

				// Checking Authorised or not
				if($vendor->save()) {
					return Redirect::to('dashboard');
				} else {
					return Redirect::to('add-vendor')->withInput();
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
	public function vendorList() {
		$vendors = Vendor::all();
		return View::make('Vendor.vendorList')->with(array('title' => 'vendors List', 'vendors' => $vendors));
	}


	/**
	 *
	 * viewVendor() : View Vendor
	 *
	 * @return Object : View
	 *
	 */
	public function viewVendor($id) {

		if(Auth::user()->getRole() <= 3) {

			$vendor = Vendor::with(array('createdby'))->get();

			if(!$vendor->isEmpty()) {
				$vendor = $vendor->first();
				return View::make('Vendor.viewVendor')
						   ->with(array('title' => 'View Vendor', 'vendor' => $vendor));
			} else {

				return Redirect::route('dashboard-view');
			}

		} else {
			return Redirect::route('dashboard-view');
		}
	}


	/**
	 *
	 * editVendor() : Edit Vendor
	 *
	 * @return Object : View
	 *
	 */
	public function editVendor($id) {

		if(Auth::user()->getRole() <= 3) {

			$vendor = Vendor::with(array('createdby'))->where('id', '=', $id)->get();

			if(!$vendor->isEmpty()) {
				$vendor = $vendor->first();
				return View::make('Vendor.editVendor')
						   ->with(array('title' => 'Edit Vendor', 'vendor' => $vendor));
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
	public function updateVendor($id)
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
						'email' =>  'required|max:50|email|unique:clients,email',
						'vendor_domain' => 'required|max:50',
						'phone' => 'max:14',
						'partner' => 'max:1'
				)
			);
			if($validate->fails()) {
				
				return Redirect::route('edit-vendor', array('id' => $id))
								->withErrors($validate)
								->withInput();
			} else {

				$vendor = Vendor::find($id);
				$vendor->vendor_domain = Input::get('vendor_domain');
				$vendor->email = Input::get('email');
				$vendor->phone = Input::get('phone');
				$vendor->partner = Input::get('partner');
				$vendor->created_by = Auth::user()->id;
				// Checking Authorised or not
				if($vendor->save()) {
					
					return Redirect::route('vendor-list');
				} else {

					return Redirect::route('edit-client')->withInput();
				}
			}
		}
	}


	/**
	 *
	 * deleteVendor() : Delete Vendor
	 *
	 * @return Object : View
	 *
	 */
	public function deleteVendor($id) {
		if(Auth::user()->getRole() <= 3) {
			if(Vendor::find($id)->delete()) {
				return Redirect::route('vendor-list');
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

        return $striped_content(htmlspecialchars_decode($outtext));
	}

	private function read_docx($file){

        $striped_content = '';
        $content = '';

        $zip = zip_open($file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            //$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))."<br />";
            $content = $content.zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))."<br />";

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

	public function test() {
		
		//return $this->read_doc("/home/ubuntu/Projects/laravel practice/headhunting/media/AkanshaBhatiBioData.doc");
		return $this->read_docx("/home/ubuntu/Projects/laravel practice/headhunting/media/Ankur_Resume.docx");
	}

}
