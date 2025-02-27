<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    // If your settings table does not have a primary key column
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'domain', 'name', 'tag', 'meta_author', 'meta_description', 'meta_keywords',
        'action_button_text', 'no_whatsapp', 'wa_message', 'icon', 'logo'
    ];

    // Disable the timestamps if your table doesn't have them
    public $timestamps = false;
}