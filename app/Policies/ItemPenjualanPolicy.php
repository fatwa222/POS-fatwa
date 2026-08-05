<?php

namespace App\Policies;

use app\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user, ItemPenjualan $itemPenjualan): bool
    {
       return $user->role->name === 'admin';
    }
}
