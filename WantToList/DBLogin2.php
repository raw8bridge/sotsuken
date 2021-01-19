<?php
    Class DBLogin{
    //プロパティを設定
        public $host = 'localhost';
        public $user = 'yuta';
        public $pass = 'dbpass';
        public $dbname = 'test_db';
        public $dsn = 'mysql:host=localhost;dbname=OnlineTest;charset=utf8';
    //メソッドを設定
        public function printDB(){
            print $this->host;
            print $this->user;
            print $this->pass;
            print $this->dbname;
        }
    }
?>


