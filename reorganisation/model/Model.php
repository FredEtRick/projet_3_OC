<?php
    class Model
    {
        protected $_DB;
        
        public function __construct()
        {
            $this->_DB = new PDO('mysql:host=localhost:8889;dbname=ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        
        public function getDb()
        {
            return $this->_DB;
        }
    }