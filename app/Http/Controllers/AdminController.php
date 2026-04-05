<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists and has admin role
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && $user->role === 'admin' && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you do not have admin access.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        // Fetch real data
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $pendingProducts = Product::where('verification_status', 'pending')->count();
        $approvedProducts = Product::where('verification_status', 'approved')->count();
        
        // Calculate total revenue (sum of prices of approved products)
        $totalRevenue = Product::where('verification_status', 'approved')->sum('price');
        
        // Format revenue as currency
        $formattedRevenue = '₹' . number_format($totalRevenue, 0);
        
        // Count sellers and buyers
        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        
        // Count verified users
        $verifiedUsers = User::where('is_verified', true)->count();
        
        // Count pending verifications
        // Pending sellers: have uploaded documents but not verified by admin
        $pendingSellers = User::where('role', 'seller')
            ->whereHas('profile', function ($query) {
                $query->whereNotNull('verification_doc')
                      ->where('verified_by_admin', false);
            })
            ->count();
            
        // Pending buyers: not yet approved
        $pendingBuyers = User::where('role', 'buyer')
            ->where('is_verified', false)
            ->count();
            
        // Total pending users
        $pendingUsers = $pendingSellers + $pendingBuyers;
        
        // Fetch recent activity
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recentProducts = Product::orderBy('created_at', 'desc')->limit(5)->get();
        
        // System status indicators (in a real application, you would check actual system status)
        $systemStatus = [
            'database' => 'operational',
            'web_server' => 'operational',
            'api' => 'operational',
            'email_service' => 'degraded',
            'payment_gateway' => 'operational'
        ];
        
        // Calculate percentages for the dashboard
        $userGrowth = $totalUsers > 0 ? round(($recentUsers->count() / $totalUsers) * 100, 1) : 0;
        $productGrowth = $totalProducts > 0 ? round(($recentProducts->count() / $totalProducts) * 100, 1) : 0;

        $data = [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'pendingProducts' => $pendingProducts,
            'approvedProducts' => $approvedProducts,
            'totalRevenue' => $formattedRevenue,
            'totalSellers' => $totalSellers,
            'totalBuyers' => $totalBuyers,
            'verifiedUsers' => $verifiedUsers,
            'pendingUsers' => $pendingUsers,
            'recentUsers' => $recentUsers,
            'recentProducts' => $recentProducts,
            'systemStatus' => $systemStatus,
            'userGrowth' => $userGrowth,
            'productGrowth' => $productGrowth
        ];

        return view('admin.dashboard', $data);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}