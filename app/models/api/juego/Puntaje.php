<?php namespace api\juego;

class Puntaje extends \Eloquent {
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'score';
    public $timestamps = false;

    /**
    * Set the keys for a save update query.
    * This is a fix for tables with composite keys
    * TODO: Investigate this later on
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query
            //Put appropriate values for your keys here:
            ->where('idPlayer', '=', $this->idPlayer)
            ->where('idLevel', '=', $this->idLevel);

        return $query;
    }
}
