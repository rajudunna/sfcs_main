<?php

/**
 * App-Confr
 */

class confr{


    /**
     * @var Array.
     * 
     * Value assigned from class constructor function.
     */
    private $configItems = [];


    protected $configFilePath = "";

    /**
     * Constructor function
     * 
     * This Constructor function takes "fields.json" path to read config items
     * 
     * @param string $path 
     * 
     * @return boolean
     * 
     * @example $confr = new confr("file/path.json");
     */
    function __construct($path){
        $this->configFilePath = $path;
        $jsonFile = file_get_contents(realpath($this->configFilePath));
        $this->configItems = json_decode($jsonFile, true);
        return true;
    }


    /**
     * Distructor function
     * 
     * This Distructor function nulls the "$configItems"
     * 
     * @param string $path 
     * 
     * @return boolean
     */
    function __distruct(){
        $this->configItems = null;
    }

    /**
     * searchConfigItem function.
     *
     * This function searches the configItem
     * 
     * @param string $configItem 
     *
     * @return string|null The config item value or null if none provided
     * 
     */
    private function searchConfigItem($configItem){
        $tmp = null;
        foreach($this->configItems['steps'] as $key => $step){
            foreach ($step as $stepKey => $stepValue) {
                if(isset($stepValue['name']) && $stepValue['name'] == $configItem){
                    $tmp = $stepValue['value'];
                    break;
                }
            }
        }
        return $tmp;
    }

    /**
     * get function
     *
     * This function gets the config iterm value
     * 
     * @param string $configItem it is config item name
     * 
     * @return string|null The config item value or null if none provided
     *
     * @example $confr = new confr("file/path.json");
     * @example $confr->get("your_confit_Item_Name");
     * 
     */
    public function get($configItem = null){
        if($configItem){
            return $this->searchConfigItem($configItem);
        }
        return null;
    }

    /**
     * getDBConfig function
     *
     * This function gets database configuration details
     * 
     * @return Array|null The config item value or null if none provided
     *
     * @example $confr = new confr("file/path.json");
     * @example $confr->getDBConfig();
     * @example "output"
     * @example "db_host": "localhost",
     * @example "db_user": "root",
     * @example "db_pass": "johnBaker",
     * @example "db_port": "3306"
     * 
     * 
     */
    public function getDBConfig(){
        return $this->configItems['database_info'];
    }


    /**
     * Returns the database mysqli connection object.
     *
     * If $db_name is not null, returns db selected mysql connection object.
     * 
     * else returns just mysql connection object.
     * 
     * returns null if config details are wrong
     *
     */
    public function getConnection($db_name = null){
        $dbConfig = $this->getDBConfig();
        $db_host = $dbConfig['db_host'];
        $db_user = $dbConfig['db_user'];
        $db_pass = $dbConfig['db_pass'];
        $db_port = $dbConfig['db_port'];

        $mysqlConnection = null;

        if($db_name !== null)
            $mysqlConnection = new mysqli($db_host,$db_user, $db_pass, $db_name, $db_port);
        else
            $mysqlConnection = new mysqli($db_host,$db_user, $db_pass, null, $db_port);
        
        if ($mysqlConnection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqlConnection->connect_errno . ") " . $mysqlConnection->connect_error;
            return NULL;
        }
        return $mysqlConnection;
    }

}