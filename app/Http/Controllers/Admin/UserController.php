<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['orders', 'addresses'])
            ->with('address')
            ->latest()
            ->paginate(15);
            
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $customerUsers = User::where('is_admin', false)->count();
        
        return view('admin.users.index', compact('users', 'totalUsers', 'adminUsers', 'customerUsers'));
    }
    
    public function show($id)
    {
        $user = User::with([
            'address',
            'orders' => function($query) {
                $query->latest()->take(10);
            },
            'orders.items.product'
        ])->findOrFail($id);
        
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->where('status', 'completed')->sum('total_amount');
        $pendingOrders = $user->orders()->where('status', 'pending')->count();
        
        return view('admin.users.show', compact('user', 'totalOrders', 'totalSpent', 'pendingOrders'));
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow deleting admin users
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete admin user.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    
    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow removing last admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot remove the last admin user.');
        }
        
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        return back()->with('success', 'User role updated successfully.');
    }
}