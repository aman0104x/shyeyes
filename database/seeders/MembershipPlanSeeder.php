<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter Love Plan',
                'price' => 999.00,
                'monthly_price' => 1999.00,
                'features' => [
                    'View member profiles',
                    'Send 10 messages daily',
                    'Access public chat rooms',
                    'Video calling feature',
                    'Priority matchmaking'
                ],
                'status' => 'active',
            ],
            [
                'name' => 'Romantic Silver Plan',
                'price' => 2999.00,
                'monthly_price' => 3999.00,
                'features' => [
                    'View member profiles',
                    'Unlimited messaging',
                    'Access public & private chat rooms',
                    'Video calling feature',
                    'Priority matchmaking',
                    'Access exclusive events'
                ],
                'status' => 'active',
            ],
            [
                'name' => 'Premium Gold Love Plan',
                'price' => 4999.00,
                'monthly_price' => 5999.00,
                'features' => [
                    'View member profiles',
                    'Unlimited messaging & media sharing',
                    'Access all chat rooms',
                    'Video calling feature',
                    'Priority matchmaking with AI',
                    'Access SHY-EYES exclusive events'
                ],
                'status' => 'active',
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::create($plan);
        }
    }
}
