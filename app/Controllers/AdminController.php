<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController {
    public function getIndex()
    {   
        $userName = $_SESSION['userName'] ?? null;
        return $this->renderHTML('admin.twig', [
            'userName' => $userName,
        ]);
    }
};
