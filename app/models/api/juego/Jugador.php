<?php namespace api\juego;

class Jugador extends \Eloquent {
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'player';
    protected $primaryKey = 'idPlayer';
    public $timestamps = false;

}
