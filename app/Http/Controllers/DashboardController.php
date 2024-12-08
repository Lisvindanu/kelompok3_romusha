<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthentikasiController;

class DashboardController extends Controller
{
    protected $authController;

    public function __construct(AuthentikasiController $authController)
    {
        $this->authController = $authController;
    }

    public function index(Request $request)
    {
        if (!session('user')) {
            return redirect()->route('login');
        }


        $token = session('user');

        $userData = $this->authController->getUserData($token);


        return view('dashboard.index', ['users' => $userData]);
    }
}
