<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('user')
            ->latest()
            ->paginate(15);
            
        $totalAddresses = Address::count();
        $usersWithAddress = User::has('address')->count();
        $usersWithoutAddress = User::doesntHave('address')->count();
        
        // City statistics
        $cityStats = Address::select('city', \DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.addresses.index', compact(
            'addresses', 
            'totalAddresses', 
            'usersWithAddress', 
            'usersWithoutAddress',
            'cityStats'
        ));
    }
    
    public function show($id)
    {
        $address = Address::with(['user', 'user.orders'])
            ->findOrFail($id);
            
        $userOrders = $address->user->orders()->count();
        $userTotalSpent = $address->user->orders()->where('status', 'completed')->sum('total_amount');
        
        return view('admin.addresses.show', compact('address', 'userOrders', 'userTotalSpent'));
    }
    
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        
        return redirect()->route('admin.addresses.index')
            ->with('success', 'Address deleted successfully.');
    }
}