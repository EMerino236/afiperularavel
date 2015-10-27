<?php namespace api\juego;

class Nivel extends \Eloquent {
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'level';
    protected $primaryKey = 'idLevel';
    public $timestamps = false;

}
