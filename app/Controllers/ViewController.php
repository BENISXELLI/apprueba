<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ViewController extends Controller
{
    public function tasks()
    {
        return view('tasks_view');
    }
}