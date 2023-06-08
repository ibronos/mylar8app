<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $table = 'supplier';
    protected $fillable = [
	    'name', 'email', 'id_item', 'address', 'contact_name', 'telephone', 'bank_name', 'bank_account_name', 'bank_number'
    ];
}
