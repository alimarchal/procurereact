<?php
use Tests\TestCase;
use App\Models\User;

test('user can have direct referrals', function () {
    $parent = User::factory()->create([
        'ibr_no' => 'IBR001'
    ]);

    $child1 = User::factory()->create([
        'referred_by' => $parent->id,
        'ibr_no' => 'IBR002'
    ]);

    $child2 = User::factory()->create([
        'referred_by' => $parent->id,
        'ibr_no' => 'IBR003'
    ]);

    expect($parent->ibr)->toHaveCount(2);
});

test('user can have nested referral network', function () {
    $grandparent = User::factory()->create(['ibr_no' => 'IBR001']);

    $parent = User::factory()->create([
        'referred_by' => $grandparent->id,
        'ibr_no' => 'IBR002'
    ]);

    $child = User::factory()->create([
        'referred_by' => $parent->id,
        'ibr_no' => 'IBR003'
    ]);

    expect($grandparent->referralNetwork)->toHaveCount(1)
        ->and($grandparent->referralNetwork->first()->referralNetwork)->toHaveCount(1);
});

test('user can traverse referral network upwards', function () {
    $parent = User::factory()->create(['ibr_no' => 'IBR001']);

    $child = User::factory()->create([
        'referred_by' => $parent->id,
        'ibr_no' => 'IBR002'
    ]);

    expect($child->parentIbrReference)->not->toBeEmpty()
        ->and($child->parentIbrReference->pluck('ibr_no'))->toContain($parent->ibr_no);
});


test('user can have four-level referral network', function () {
    $level1 = User::factory()->create(['ibr_no' => 'IBR001']);

    $level2a = User::factory()->create([
        'referred_by' => $level1->id,
        'ibr_no' => 'IBR002'
    ]);

    $level2b = User::factory()->create([
        'referred_by' => $level1->id,
        'ibr_no' => 'IBR003'
    ]);

    $level3 = User::factory()->create([
        'referred_by' => $level2a->id,
        'ibr_no' => 'IBR004'
    ]);

    $level4 = User::factory()->create([
        'referred_by' => $level3->id,
        'ibr_no' => 'IBR007'
    ]);

    expect($level1->referralNetwork)->toHaveCount(2)
        ->and($level2a->referralNetwork)->toHaveCount(1)
        ->and($level3->referralNetwork)->toHaveCount(1);
});


test('user can have n-level referral network', function () {
    // Create root IBR
    $root = User::factory()->create(['ibr_no' => 'IBR001']);
    $currentParent = $root;
    $levels = 5; // Test 5 levels deep
    $created = collect([$root]);

    // Create N levels
    for ($level = 2; $level <= $levels; $level++) {
        $child = User::factory()->create([
            'referred_by' => $currentParent->id,
            'ibr_no' => 'IBR' . str_pad($level, 3, '0', STR_PAD_LEFT)
        ]);
        $created->push($child);
        $currentParent = $child;
    }

    // Verify each level's network depth
    $created->each(function ($user, $index) use ($levels, $created) {
        $expectedCount = $levels - ($index + 1);
        if ($expectedCount > 0) {
            expect($user->referralNetwork)->toHaveCount(1)
                ->and($user->referralNetwork->first()->ibr_no)
                ->toBe($created[$index + 1]->ibr_no);
        }
    });
});
