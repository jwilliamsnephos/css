<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Score
 *
 * @package App
 * @property string $event
 * @property string $team
 * @property string $participant
 * @property integer $score
*/
class Score extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['score', 'event_id', 'team_id', 'participant_id', 'xcount'];
    

    public static function storeValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required|uniqueScore',
            'team_id' => 'integer|exists:teams,id|max:4294967295|required|participantMatchesTeam',
            'participant_id' => 'integer|exists:participants,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required',
            'xcount' => 'integer|max:2147483647|nullable',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required|uniqueScore',
            'team_id' => 'integer|exists:teams,id|max:4294967295|required|participantMatchesTeam',
            'participant_id' => 'integer|exists:participants,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required',
            'xcount' => 'integer|max:2147483647|nullable',
        ];
    }

    

    
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
    


    public function scopeByEventId($query, $val) {
        if (empty($val)) {
            return $query;
        }
        return $query->where('event_id', $val);
    }

    public function scopeByTeamId($query, $val) {
        if (empty($val)) {
            return $query;
        }
        return $query->where('team_id', $val);
    }

    public function scopeByParticipantId($query, $val) {
        if (empty($val)) {
            return $query;
        }
        return $query->where('participant_id', $val);
    }
    
}
