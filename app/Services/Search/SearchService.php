<?php

namespace App\Services\Search;

use App\Models\User;
use App\Models\FollowupEmail;
use App\Models\State;
use App\Models\Rank;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Exception;
use Helper;
use DB;
use Auth;

class SearchService 
{
    /**
     * @var
     */
    private $keyword;

    /**
     * @var
     */
    private $result;

    /**
     * The constructor
     * 
     * @param $keyword The user-input search keyword
     * 
     * @return void
     */
    public function __construct($keyword)
    {
        $this->keyword = $keyword;
        $this->results = [];
        $this->performSearching();
    }

    /**
     * Perform the actual search querying
     * 
     * @return void
     */
    public function performSearching()
    {
        if (strlen($this->keyword) >= 3) {
            $dateFrom = Carbon::now()->addDays(-5);
            $dateTo = Carbon::now();
            $followupEmails = FollowupEmail::search($this->keyword)->raw()['results'];
            $followupEmails = $followupEmails->where('updated_at', '>=', $dateFrom)->where('updated_at', '<', $dateTo);

            foreach ($followupEmails as $followupEmail) {
                $formattedTitleAndBody = $this->formatTitleAndBody($followupEmail->body, $followupEmail->subject);
                $this->results[] = [
                    'id' => $followupEmail->id,
                    'title' => $formattedTitleAndBody['title'],
                    'body' => $formattedTitleAndBody['body'],
                    'datetime' => $followupEmail->updated_at,
                    'state' => State::find($followupEmail->state_id)->state,
                    'rank' => Rank::find($followupEmail->rank_id)->rank,
                    'body_truncated' => $formattedTitleAndBody['body_truncated'],
                ];
            }
            $this->results = collect($this->results);
        } else {
            $this->results = collect([]);
        }
    }
    
    /**
     * Truncates the body, determine if truncated or not, highlight the matched keyword to the item 
     * 
     * @param string $body The lead's body
     * @param string $title The lead's title (subject)
     * 
     * @return array
     */

    public function formatTitleAndBody($body, $title)
    {
        $body = trim(strip_tags(preg_replace('/\s+/', ' ', $body)));
        $body = substr($body, 0, 700);
        $bodyTruncated = strlen($body) > 700 ?  true : false;
        $keywords = explode(' ', $this->keyword);

        foreach ($keywords as $keyword) {
            $body = str_ireplace($keyword, "<span class='hl'>" . strtolower($keyword) . "</span>", $body);
            $title = str_ireplace($keyword, "<span class='hl'>" . strtolower($keyword) . "</span>", $title);
        }

        return ['body' => $body, 'body_truncated' => $bodyTruncated, 'title' => $title];
    }

    /**
     * Counts the results (not the paginated one)
     * 
     * @return integer
     */
    public function countResults()
    {
        return $this->results->count();
    }
     
    /**
    * paginate a collection.
    *
    * @param int   $perPage
    * @param int  $page
    * @param array $options
    *
    * @return LengthAwarePaginator
    */
    public function paginate($perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $this->results = $this->results instanceof Collection ? $this->results : Collection::make($this->results);
        return new LengthAwarePaginator($this->results->forPage($page, $perPage), $this->results->count(), $perPage, $page, $options);
    }
}