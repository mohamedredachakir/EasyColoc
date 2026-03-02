<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\ColocationUser;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users(){
        $users = User::all();
        return view('admin.users', compact('users'));
    
    }
    public function colocations(){
        $colocations = Colocation::all();
        return view('admin.colocations', compact('colocations'));
    }
    public function expenses(){
        $expenses = Expense::with(['colocation', 'user', 'category'])->get();
        return view('admin.expenses', compact('expenses'));
    }
    public function payments(){
        $payments = Payment::with(['colocation', 'user'])->get();
        return view('admin.payments', compact('payments'));
    }
    public function categories(){
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }
    public function invitations(){
        $invitations = Invitation::with(['sender', 'receiver', 'colocation'])->get();
        return view('admin.invitations', compact('invitations'));
    }
    public function ban($id){
        $user = User::findOrFail($id);
        $user->is_ban = true;
        $user->save();
        
        ColocationUser::where('user_id', $id)->delete();
        
        return redirect()->route('admin.users')->with('success', 'User banned successfully!');
    }
    public function unban($id){
        $user = User::findOrFail($id);
        $user->is_ban = false;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'User unbanned successfully!');
    }
}
