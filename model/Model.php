<?php

    require_once('dbConfig.php');

    class Model
    {
        protected $_DB;
        
        public function __construct()
        {
            $this->_DB = new PDO($GLOBALS['dbDatas'], $GLOBALS['user'], $GLOBALS['password'], $GLOBALS['errorsManager']);
        }
        
        public function getDb()
        {
            return $this->_DB;
        }
    }