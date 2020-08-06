<?php
/**
 * DB operations functions
 */

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($User) {
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        // Insert user into database
        $result = mysqli_query($con,"INSERT INTO user(Name) VALUES('$User')");

        if ($result) {
            return true;
        } else {
            // For other errors
            return false;
        }
    }
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $result = mysqli_query($con,"select * FROM intervention");
        return $result;
    }
    /**
     * Get Yet to Sync row Count
     */
    public function getUnSyncRowCount() {
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $result = mysqli_query($con,"SELECT * FROM intervention WHERE syncsts = FALSE");
        return $result;
    }
    /**
     * Update Sync status of rows
     */
    public function updateSyncSts($id, $sts){
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        $result = mysqli_query($con,"UPDATE user SET syncsts = $sts WHERE Id = $id");
        return $result;
    }
}

?>