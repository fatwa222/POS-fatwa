<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    
    public function view(User $user, Penjualan $penjualan): bool
    {
        
        return $user->role->name === 'admin';
    }

   
    public function update(User $user, Penjualan $penjualan): bool
    {
       
        return $user->role->name === 'admin';
    }

   
    public function delete(User $user, Penjualan $penjualan): bool
    {
      
        return $user->role->name === 'admin' 
            && $penjualan->status === 'OPEN';
    }
}