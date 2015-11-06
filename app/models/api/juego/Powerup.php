<?php namespace api\juego;

class Powerup extends \Eloquent {
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'powerup';
    protected $primaryKey = 'idPowerup';
    public $timestamps = false;

}