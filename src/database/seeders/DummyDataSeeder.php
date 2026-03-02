<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Colocation;
use App\Models\ColocationUser;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Category;
use App\enum\RoleEnum;
use App\enum\ColocationStatus;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@coloc.com',
            'password' => Hash::make('password'),
            'role' => RoleEnum::ADMIN,
            'reputation' => 100,
        ]);

        // 2. Create 3 Owners
        $owners = [];
        for ($i = 1; $i <= 3; $i++) {
            $owners[] = User::create([
                'name' => "Owner $i",
                'email' => "owner$i@coloc.com",
                'password' => Hash::make('password'),
                'role' => RoleEnum::OWNER,
                'reputation' => 10,
            ]);
        }

        // 3. Create 9 Members
        $members = [];
        for ($i = 1; $i <= 9; $i++) {
            $members[] = User::create([
                'name' => "Member $i",
                'email' => "member$i@coloc.com",
                'password' => Hash::make('password'),
                'role' => RoleEnum::MEMBER,
                'reputation' => 5,
            ]);
        }

        // 4. Create 3 Plain Users
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@coloc.com",
                'password' => Hash::make('password'),
                'role' => RoleEnum::USER,
                'reputation' => 0,
            ]);
        }

        // 5. Create 3 Colocations (one for each owner)
        $colocations = [];
        foreach ($owners as $index => $owner) {
            $colocations[] = Colocation::create([
                'name' => "Colocation " . ($index + 1),
                'owner_id' => $owner->id,
                'status' => ColocationStatus::ACTIVE,
            ]);

            // Add owner as a member (often implied, let's be explicit)
            ColocationUser::create([
                'colocation_id' => $colocations[$index]->id,
                'user_id' => $owner->id,
                'amount' => 0,
                'entry_date' => now(),
            ]);
        }

        // 6. Create categories for each colocation
        $categoryNames = ['Rent', 'Groceries', 'Utilities', 'Internet', 'Maintenance'];
        $categoriesByColoc = [];
        foreach ($colocations as $coloc) {
            foreach ($categoryNames as $name) {
                $categoriesByColoc[$coloc->id][] = Category::create([
                    'name' => $name,
                    'colocation_id' => $coloc->id
                ]);
            }
        }

        // 7. Assign 9 Members to 3 Colocations (3 members each)
        for ($i = 0; $i < 9; $i++) {
            $colocationIndex = floor($i / 3);
            ColocationUser::create([
                'colocation_id' => $colocations[$colocationIndex]->id,
                'user_id' => $members[$i]->id,
                'amount' => 0,
                'entry_date' => now(),
            ]);
        }

        // 8. Create 3 Expenses
        $expenseData = [
            [
                'name' => 'Monthly Rent', 
                'amount' => 3000, 
                'coloc_idx' => 0, 
                'user' => $owners[0]
            ],
            [
                'name' => 'Weekly Groceries', 
                'amount' => 500, 
                'coloc_idx' => 1, 
                'user' => $members[3] // member 4
            ],
            [
                'name' => 'Electricity Bill', 
                'amount' => 200, 
                'coloc_idx' => 2, 
                'user' => $members[6] // member 7
            ],
        ];

        foreach ($expenseData as $data) {
            $coloc = $colocations[$data['coloc_idx']];
            $user = $data['user'];
            $colocCategories = $categoriesByColoc[$coloc->id];
            
            Expense::create([
                'name' => $data['name'],
                'amount' => $data['amount'],
                'colocation_id' => $coloc->id,
                'user_id' => $user->id,
                'category_id' => $colocCategories[array_rand($colocCategories)]->id,
                'expense_date' => now(),
            ]);

            // Split the expense
            $membersInColoc = ColocationUser::where('colocation_id', $coloc->id)->get();
            $splitAmount = $data['amount'] / $membersInColoc->count();
            
            foreach ($membersInColoc as $pivot) {
                $credit = ($pivot->user_id == $user->id) ? $data['amount'] : 0;
                $pivot->update(['amount' => $pivot->amount - $splitAmount + $credit]);
            }
        }

        // 9. Create 2 Payments
        Payment::create([
            'name' => 'Rent Settlement',
            'amount' => 750,
            'colocation_id' => $colocations[0]->id,
            'user_id' => $members[0]->id, // Member 1 pays back
            'payment_date' => now(),
        ]);
        ColocationUser::where('colocation_id', $colocations[0]->id)->where('user_id', $members[0]->id)->increment('amount', 750);

        Payment::create([
            'name' => 'Grocery Share',
            'amount' => 125,
            'colocation_id' => $colocations[1]->id,
            'user_id' => $members[4]->id, // Member 5 pays back
            'payment_date' => now(),
        ]);
        ColocationUser::where('colocation_id', $colocations[1]->id)->where('user_id', $members[4]->id)->increment('amount', 125);
    }
}
