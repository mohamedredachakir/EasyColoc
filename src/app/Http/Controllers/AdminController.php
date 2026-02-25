<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Don't list other admins in the regular user table
        $users = User::where('role', '!=', RoleEnum::ADMIN->value)->get();
        
        $stats = [
            'total_users' => User::count(),
            'total_colocations' => Colocation::count(),
            'total_expenses' => Expense::sum('amount'),
        ];
        
        return view('admin.index', compact('users', 'stats'));
    }

    public function ban(User $user)
    {
        $user->update([
            'is_banned' => true,
        ]);
        return redirect()->route('admin.index')->with('success', 'User banned successfully.');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
        ]);
        return redirect()->route('admin.index')->with('success', 'User unbanned successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === RoleEnum::ADMIN->value) {
            return redirect()->back()->with('error', 'Cannot delete an admin.');
        }
        
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
