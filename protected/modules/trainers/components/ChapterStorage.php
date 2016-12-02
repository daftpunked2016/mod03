<?php 
class ChapterStorage {

	/**
	* 
	* @var array
	*
	* key = chapter_id  & value = chapter name
	*/
	public static $chapters;

	/**
	* 
	* @var ChapterStorage instance
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
        $chapters = Chapter::model()->findAll();

        foreach($chapters as $c) {
            static::$chapters[$c->id]['name'] =  $c->chapter;
            static::$chapters[$c->id]['region'] =  $c->region->region;
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