<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 0. Wipe existing data — PostgreSQL style
        //    TRUNCATE … RESTART IDENTITY CASCADE
        //    handles FK constraints automatically
        // ─────────────────────────────────────────
        DB::statement('TRUNCATE TABLE payments, expenses, categories, colocation_users, invitations, colocations, users RESTART IDENTITY CASCADE;');

        // ─────────────────────────────────────────
        // 1. ADMIN
        // ─────────────────────────────────────────
        $admin = User::create([
            'name'       => 'Admin Plateform',
            'email'      => 'admin@easycoloc.ma',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'reputation' => 100,
            'is_banned'  => false,
        ]);

        // ─────────────────────────────────────────
        // 2. OWNERS (space creators)
        // ─────────────────────────────────────────
        $owners = collect([
            ['Youssef Benali',     'youssef@easycoloc.ma'],
            ['Fatima Zahra Idrissi','fatima@easycoloc.ma'],
            ['Amine Tazi',         'amine@easycoloc.ma'],
            ['Sara El Mansouri',   'sara@easycoloc.ma'],
            ['Mehdi Chakir',       'mehdi@easycoloc.ma'],
        ])->map(fn($u) => User::create([
            'name'       => $u[0],
            'email'      => $u[1],
            'password'   => Hash::make('password'),
            'role'       => 'owner',
            'reputation' => rand(40, 90),
            'is_banned'  => false,
        ]));

        // ─────────────────────────────────────────
        // 3. REGULAR MEMBERS
        // ─────────────────────────────────────────
        $members = collect([
            ['Karim Ouazzani',   'karim@easycoloc.ma'],
            ['Nadia Berrada',    'nadia@easycoloc.ma'],
            ['Hamza Alaoui',     'hamza@easycoloc.ma'],
            ['Rim Cherkaoui',    'rim@easycoloc.ma'],
            ['Omar Saidi',       'omar@easycoloc.ma'],
            ['Layla Bensouda',   'layla@easycoloc.ma'],
            ['Tariq Filali',     'tariq@easycoloc.ma'],
            ['Houda Meknassi',   'houda@easycoloc.ma'],
            ['Rachid Benjelloun','rachid@easycoloc.ma'],
            ['Aicha Lamrani',    'aicha@easycoloc.ma'],
        ])->map(fn($u) => User::create([
            'name'       => $u[0],
            'email'      => $u[1],
            'password'   => Hash::make('password'),
            'role'       => 'member',
            'reputation' => rand(20, 80),
            'is_banned'  => false,
        ]));

        // ─────────────────────────────────────────
        // 4. COLOCATIONS (owned by owners)
        // ─────────────────────────────────────────
        $colocData = [
            [$owners[0], 'Appart Maarif — Casablanca',  'active'],
            [$owners[1], 'Villa Hay Riad — Rabat',      'active'],
            [$owners[2], 'Studio Guéliz — Marrakech',   'active'],
            [$owners[3], 'Appart Agdal — Rabat',        'active'],
            [$owners[4], 'Lotissement Anfa — Casablanca','cancelled'],
        ];

        $colocations = collect($colocData)->map(fn($d) => Colocation::create([
            'name'     => $d[1],
            'owner_id' => $d[0]->id,
            'status'   => $d[2],
        ]));

        // ─────────────────────────────────────────
        // 5. PIVOT — attach owner + members to each colocation
        // Owner always joins their own space; add 3-4 members per colocation
        // ─────────────────────────────────────────
        $memberChunks = $members->chunk(2); // groups of 2 out of 10

        foreach ($colocations as $i => $coloc) {
            $owner = $colocData[$i][0];

            // Owner joins their own space
            $coloc->users()->attach($owner->id, [
                'joined_at' => Carbon::now()->subDays(rand(60, 120)),
                'left_at'   => null,
            ]);

            // Attach 2-3 random members (different per coloc)
            $chunk = $memberChunks->get($i % $memberChunks->count(), collect());
            foreach ($chunk as $member) {
                $coloc->users()->attach($member->id, [
                    'joined_at' => Carbon::now()->subDays(rand(20, 59)),
                    'left_at'   => null,
                ]);
            }

            // Always add one extra member from the global pool to fatten up
            $extra = $members->get(($i * 2 + 1) % $members->count());
            if (!$coloc->users->pluck('id')->contains($extra->id)) {
                $coloc->users()->attach($extra->id, [
                    'joined_at' => Carbon::now()->subDays(rand(5, 20)),
                    'left_at'   => null,
                ]);
            }
        }

        // ─────────────────────────────────────────
        // 6. CATEGORIES — 5-7 categories per colocation
        // ─────────────────────────────────────────
        $categoryNames = [
            'Loyer', 'Électricité', 'Eau', 'Internet', 'Courses',
            'Ménage', 'Transport', 'Cuisine', 'Loisirs', 'Divers',
        ];

        $catMap = []; // $catMap[coloc_id] = [category, ...]

        foreach ($colocations as $coloc) {
            $picks = collect($categoryNames)->shuffle()->take(6);
            $cats  = [];
            foreach ($picks as $catName) {
                $cats[] = Category::create([
                    'colocation_id' => $coloc->id,
                    'name'          => $catName,
                ]);
            }
            $catMap[$coloc->id] = $cats;
        }

        // ─────────────────────────────────────────
        // 7. EXPENSES — 8-15 expenses per colocation
        // ─────────────────────────────────────────
        $expenseTitles = [
            'Loyer Février',
            'Facture Maroc Telecom',
            'Courses Carrefour',
            'Gaz & Électricité',
            'Eau RADEEMA',
            'Produits ménagers',
            'Pizza soirée',
            'Réparation plomberie',
            'Wi-Fi mensuel',
            'Matelas chambre 2',
            'Abonnement Netflix commun',
            'Taxi aéroport',
            'Courses Marjane',
            'Café & petit-déjeuner',
            'Bouteille de gaz',
        ];

        foreach ($colocations as $coloc) {
            $colMembers = $coloc->users()->pluck('users.id')->toArray();
            $cats       = $catMap[$coloc->id];
            $count      = rand(8, 15);

            for ($e = 0; $e < $count; $e++) {
                Expense::create([
                    'colocation_id' => $coloc->id,
                    'category_id'   => $cats[array_rand($cats)]->id,
                    'payer_id'      => $colMembers[array_rand($colMembers)],
                    'title'         => $expenseTitles[array_rand($expenseTitles)],
                    'amount'        => rand(50, 2500) + (rand(0, 99) / 100),
                    'expense_date'  => Carbon::now()->subDays(rand(0, 90)),
                ]);
            }
        }

        // ─────────────────────────────────────────
        // 8. PAYMENTS — 3-6 settlements per colocation
        // ─────────────────────────────────────────
        foreach ($colocations as $coloc) {
            $colMembers = $coloc->users()->pluck('users.id')->toArray();
            if (count($colMembers) < 2) continue;

            $count = rand(3, 6);
            for ($p = 0; $p < $count; $p++) {
                // Pick two different members
                $from = $colMembers[array_rand($colMembers)];
                do {
                    $to = $colMembers[array_rand($colMembers)];
                } while ($to === $from);

                Payment::create([
                    'colocation_id' => $coloc->id,
                    'from_user_id'  => $from,
                    'to_user_id'    => $to,
                    'amount'        => rand(100, 1200) + (rand(0, 99) / 100),
                    'paid_at'       => Carbon::now()->subDays(rand(0, 60)),
                ]);
            }
        }

        // ─────────────────────────────────────────
        // Done
        // ─────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅  EasyColoc seeded successfully!');
        $this->command->info('');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',  'admin@easycoloc.ma',   'password'],
                ['Owner',  'youssef@easycoloc.ma', 'password'],
                ['Owner',  'fatima@easycoloc.ma',  'password'],
                ['Owner',  'amine@easycoloc.ma',   'password'],
                ['Owner',  'sara@easycoloc.ma',    'password'],
                ['Owner',  'mehdi@easycoloc.ma',   'password'],
                ['Member', 'karim@easycoloc.ma',   'password'],
                ['Member', 'nadia@easycoloc.ma',   'password'],
                ['Member', 'hamza@easycoloc.ma',   'password'],
                ['Member', 'rim@easycoloc.ma',     'password'],
                ['Member', 'omar@easycoloc.ma',    'password'],
            ]
        );
    }
}
