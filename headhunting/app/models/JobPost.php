<?php
/**
 * JobPost.php
 *
 * This file contatins Model class to provide Data Logic for all JobPost Table
 *
 * @category   Models
 * @package    JobPost
 * @version    SVN: <svn_id>
 * @since      27th Feb 2016
 */

/**
 * Model class to provide Data Logic
 *
 * @category   Models
 * @package    JobPost
 *
 */
class JobPost extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_posts';
    
    /**
     *
     * user : Relation between User Sales & Job Posts.
     *
     * @return Object belongs to Relation User Job Posts.
     */
    public function user() {
    
    	return $this->belongsTo('User','created_by','id');
    }
    
    
    /**
     *
     * countries : Relation between Job Posts & country.
     *
     * @return Object belongs to Relation User Country.
     */
    public function country() {
    
    	return $this->belongsTo('Country','country_id','id');
    }
    
    /**
     *
     * state : Relation between Job Posts & State.
     *
     * @return Object belongs to Relation User State.
     */
    public function state() {
    
    	return $this->belongsTo('State','state_id','id');
    }
    
    /**
     *
     * jobsAssigned : Relation between jobs Assigned.
     *
     * @return Object hasMany Relation jobs Assigned.
     */
    public function jobsAssigned() {
    
    	return $this->hasMany('JobPostAssignment','job_post_id','id');
    }

    /**
     *
     * jobsAssigned : Relation between jobs Assigned.
     *
     * @return Object hasMany Relation jobs Assigned.
     */
    public function jobsAssignedToMe() {
    
    	return $this->hasMany('JobPostAssignment','job_post_id','id')->where('assigned_to_id', '=', Auth::user()->id);
    }

    /**
     *
     * client : Relation between Client & Job Posts.
     *
     * @return Object belongs to Relation User Job Posts.
     */
    public function client() {
    
        return $this->belongsTo('Client','client_id','id');
    }

    /**
     *
     * vendor : Relation between Vendor & Job Posts.
     *
     * @return Object belongs to Relation User Job Posts.
     */
    public function vendor() {
    
        return $this->belongsTo('Vendor','vendor_id','id');
    }

    /**
     *
     * countries : Relation between Job Posts & country.
     *
     * @return Object belongs to Relation User Country.
     */
    public function city() {
    
        return $this->belongsTo('City','city_id','id');
    }
}