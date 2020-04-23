<?php
use App\Product;
use Illuminate\Support\Facades\Cache;

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function removeFileExt($topic)
{
    $topic = str_replace(".html", "", $topic);
    $topic = str_replace(".htm", "", $topic);
    return $topic;
}

function getRecentlyViewed(){

    if (!Cache::has('recent')) {
        $recent = array(Request::url());
        Cache::put('recent', $recent, 360);
    }
    else{

        $recent = Cache::get('recent');

        if (in_array(Request::url(), $recent)){
            $result = array_diff($recent, array(Request::url()));
            array_push($result, Request::url());
            Cache::put('recent', $result, 360);
        }

        elseif(count($recent) >= 5){
            array_shift($recent);
            array_push($recent, Request::url());
            Cache::put('recent', $recent, 360);
        }
        else{
            array_push($recent, Request::url());
            Cache::put('recent', $recent, 360);
        }

    }

    $recent = Cache::get('recent');
    return $recent;
}

   function getVoteData($product, $version) {
        $prodId = Product::getId($product);
        if($prodId->isEmpty()){
            return;
        }
        else{
        $prodId = $prodId->first()->prod_id;
        }
        
        $versionVotes = DB::table('votes')
            ->join('features', 'votes.feat_id', '=', 'features.feat_id')
            ->where('feat_prod_ver', $version)
            ->where('votes.prod_id', $prodId)
            ->get(['features.feat_id', 'feat_name', 'vote_state']);


        $featureScores = array();

        foreach($versionVotes as $versionVote) {
            if(!array_key_exists($versionVote->feat_name, $featureScores)){
               $featureScores[$versionVote->feat_name] = 0;
            }
            //if upvote of cleared downvote
            if($versionVote->vote_state == "1" || $versionVote->vote_state == "4"){
                $featureScores[$versionVote->feat_name]++;
            }
            //if downvote or cleared upvote
            elseif($versionVote->vote_state == "2" || $versionVote->vote_state == "3"){
                 $featureScores[$versionVote->feat_name]--;
            } 
        }
        $jsonScores = json_encode($featureScores);

        return $featureScores;
    }

?>