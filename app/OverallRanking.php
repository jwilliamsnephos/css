<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeamRanking
 *
 * @package App
 * @property string $event
 * @property string $contact
 * @property integer $TeamRanking
*/
class OverallRanking extends Model
{
    protected $table = 'v_overall_ranking';
    protected $primaryKey = 'contact_id';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function scopeOrderByWinner($query) {
        return $query->orderBy('score', 'desc')
                     ->orderBy('tie_breaker_1', 'desc')
                     ->orderBy('tie_breaker_2', 'desc')
                     ->orderBy('tie_breaker_3', 'desc')
                     ->orderBy('tie_breaker_4', 'desc');
    }
}
