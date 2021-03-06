<?php
/**
 * CandidateResume.php
 *
 * This file contatins Model class to provide Data Logic for all CandidateResume Table
 *
 * @category   Models
 * @package    CandidateResume
 * @version    SVN: <svn_id>
 * @since      27th Feb 2016
 */

/**
 * Model class to provide Data Logic
 *
 * @category   Models
 * @package    CandidateResume
 *
 */
use Elasticquent\ElasticquentTrait;


class CandidateResume extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use ElasticquentTrait;

    protected $table = 'candidate_resumes';

    public $fillable = ['candidate_id', 'resume'];

	protected $mappingProperties = array(
	'candidate_id' => [
	  'type' => 'integer',
	  #"analyzer" => "standard",
	],
	'resume' => [
	  'type' => 'string',
	  "analyzer" => "standard",
	]
	);
	/*
	php artisan tinker
	
	CandidateResume::createIndex($shards = null, $replicas = null);

	CandidateResume::putMapping($ignoreConflicts = true);

	CandidateResume::addAllToIndex();

	*/

	/**
     *
     * countries : Relation between User & country.
     *
     * @return Object belongs to Relation User Country.
     */
    public function candidate() {
    
    	return $this->belongsTo('Candidate','candidate_id','id');
    }
 
}
