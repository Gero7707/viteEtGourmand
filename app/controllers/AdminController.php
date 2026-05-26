<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class AdminController{


    private UserModel $users;

    public function __construct(){
        $this->users = new UserModel();
    }
    public function showDashboard(){
        Auth::checkAdmin();
        $users = $this->users->getAllUsers();
        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }


}