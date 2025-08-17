<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['reporter_id', 'reported_id', 'reason', 'details'];

    // Report.php (Model ke andar)
    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_id')
            ->select('id', 'f_name', 'l_name', 'email');
    }

    public function reporterUser()
    {
        return $this->belongsTo(User::class, 'reporter_id')
            ->select('id', 'f_name', 'l_name', 'email');
    }

    // Add the missing relationships that the view is expecting
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id')
            ->select('id', 'f_name', 'l_name', 'email', 'img');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id')
            ->select('id', 'f_name', 'l_name', 'email', 'img');
    }
}
