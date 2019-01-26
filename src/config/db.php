<?php
    class db {
        private $db_host = 'localhost';
        private $db_user = 'root';
        private $db_pass = '';
        private $db_name = 'm07-practicaslim';

        //connection
        public function connectDB() {
            $mysql_conn = "mysql:host=$this->db_host;dbname=$this->db_name";
            $db_conn = new PDO($mysql_conn, $this->db_user, $this->db_pass);
            $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db_conn;
        }
    }