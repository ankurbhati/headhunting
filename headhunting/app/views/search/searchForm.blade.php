@extends('layouts.adminLayout')
@section('content')
<form class="form-horizontal" method="post">
  <div class="form-group">
    <label for="inputKeyskills" class="col-sm-2 control-label">Keyskills</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="inputKeyskills" placeholder="Skills,Designation,Companies">
    </div>
  </div>
  <div class="form-group">
    <label for="inputLocation" class="col-sm-2 control-label">Location</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="inputLocation" placeholder="Enter the cities you want to work in">
    </div>
  </div>
  <div>
 <div class="form-group">
   	 <label for="inputWorkexperience" class="col-sm-2 control-label">Work Experience</label>
       <div class="col-sm-3">
 		 <select class="form-control">
  			<option>Years</option>
  			<option>1</option>
  			<option>2</option>
  			<option>3</option>
  			<option>4</option>
  			<option>5</option>
			<option>6</option>
  			<option>7</option>
  			<option>8</option>
  			<option>9</option>
  			<option>10</option>
  			<option>11</option>
  			<option>12</option>
  			<option>13</option>
  			<option>14</option>
  			<option>15</option>
			<option>16</option>
  			<option>17</option>
  			<option>18</option>
  			<option>19</option>
  			<option>20</option>  
  			<option>21</option>
  			<option>22</option>
  			<option>23</option>
  			<option>24</option>
  			<option>25</option>
			<option>26</option>
  			<option>27</option>
  			<option>28</option>
  			<option>29</option>
  			<option>30</option>    			
   		</select>
  	</div>
 </div> 
 <div class="form-group">
   	 <label class="col-sm-2 control-label"></label>
       <div class="col-sm-2">
 		 <select class="form-control">
  			<option>Months</option>
  			<option>1</option>
  			<option>2</option>
  			<option>3</option>
  			<option>4</option>
  			<option>5</option>
			<option>6</option>
  			<option>7</option>
  			<option>8</option>
  			<option>9</option>
  			<option>10</option>
  			<option>11</option>			
   		</select>
  	</div>
 </div> 
 </div>
 
 <div class="form-group">
    <label for="inputQuery" class="col-sm-2 control-label">Query</label>
    <div class="col-sm-7">
      <textarea class="form-control" rows="2" name="query"></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>
</form>
@stop