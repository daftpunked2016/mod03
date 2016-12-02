<?php 
class ScoresStorage {

	/**
	* 
	* @var array
	*
	* key = PEA CODE  & value = [SCORE][ITEM CODE / PAIR NUMBER (if have pair)]
	*/
	public static $scores;

	/**
	* 
	* @var ScoresStorage instance
	*
	*/
	private static $instance;

	public static function setup()
    {
        if (!static::$instance) {
            static::$instance = static::create();
        } else {	
        	static::iterate();
        }	

        return static::$instance;
    }

    private static function create()
    {
        $instance = new self();
        static::iterate();

        return $instance;
    }

    private static function iterate()
    {
        $scorecards = EtrainingScorecard::model()->findAll();

        foreach($scorecards as $s) {
            static::$scores[$s->id.'-'.$s->pea_code.':']['pea_code'] =  $s->pea_code;
            static::$scores[$s->id.'-'.$s->pea_code.':']['score'] =  $s->goal_point;
            static::$scores[$s->id.'-'.$s->pea_code.':']['group'] =  $s->grouping;
        }
    }

	/**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

}
?>