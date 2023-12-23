<?php

namespace Database\Seeders;

use App\Enums\RequestStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Request;
use App\Models\RequestableItem;
use App\Models\RequestItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $request = Request::create([
            'user_id' => User::whereNotIn('id_number', [RoleEnum::ADMIN, RoleEnum::REGISTRAR])->inRandomOrder()->pluck('id')->first(),
            'approved_by' => User::whereIn('id_number', [RoleEnum::ADMIN, RoleEnum::REGISTRAR])->inRandomOrder()->pluck('id')->first(),
            'status' => RequestStatusEnum::PENDING_REVIEW,
        ]);


        $items = [
            ['name' => 'TOR'],
            ['name' => 'Good Moral']
        ];

        RequestableItem::insert($items);

        $item1 = RequestableItem::inRandomOrder()->first();        
        RequestItem::create([
            'request_id' => $request->id,
            'item_id' => $item1->id,
            'item_name' => $item1->name,
            'quantity' => rand(1, 5),
            'price' => rand(50, 350),
            'status' => rand(1, 10)
        ]);

        $item2 = RequestableItem::inRandomOrder()->first();        
        RequestItem::create([
            'request_id' => $request->id,
            'item_id' => $item2->id,
            'item_name' => $item2->name,
            'quantity' => rand(1, 5),
            'price' => rand(50, 350),
            'status' => rand(1, 10)
        ]);

    }
}
