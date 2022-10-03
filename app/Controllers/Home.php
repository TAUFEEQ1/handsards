<?php

namespace App\Controllers;

use SplFileObject;
class Home extends BaseController
{
    private $table="directory_access";
    private $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    private function getMentions(string $content){
        $lines = explode("\n",$content);

        $has_title=function(string $words){
            if (count(explode(" ",$words))<2)return false;
            $begin = explode(" ",$words)[0];
            return in_array($begin,['MR','MS']);
        };
        $find_speakers= function (string $line){
            if (str_contains($line,":"))return explode(":",$line)[0];
            return "";
        };
        $clean=function(string $title){
            if(str_contains($title,"("))return trim(explode("(",$title)[0]);
            return trim($title);
        };
        $speakers = array_map($find_speakers,$lines);
        $speakers = array_filter($speakers,$has_title);
        $speakers = array_map($clean,$speakers);
        $fullnames = array_unique(array_filter($speakers,function($speaker){
            return count(explode(" ",$speaker)) > 2;
        }));
        $find = function($short) use ($fullnames){
            if((count(explode(" ",$short)))>2)return $short;
            foreach($fullnames as $i){
                if(str_contains($i,explode(" ",$short)[1])){
                    return $i;
                }
            }
            return $short;
        };
        $speakers = array_map($find,$speakers);

        $result = array_count_values($speakers);

        $tmp = [];
        foreach($result as $key=>$value){
            array_push($tmp,["name"=>$key,"mentions"=>$value]);
        }
        usort($tmp,function($a,$b){
            return $a['mentions'] < $b['mentions'];
        });
        $mps = array_column($tmp,'name');
        $mentions = array_column($tmp,'mentions');
        return ["mps"=>$mps,"mentions"=>$mentions];
    }
    private function getTopics(string $content){
        $tokenizer = new \TextAnalysis\Tokenizers\GeneralTokenizer();
        
        $path = APPPATH."/Controllers/stopwords.txt";
        $file = new SplFileObject($path,'r');
        $contents = $file->fread($file->getSize());
    
        $stopwords = explode("\n",$contents);

        $content = preg_replace('/\p{P}/', ' ', $content);
        
        foreach($stopwords as $word){
            $content = str_replace(" ".trim($word)." "," ",$content);
        }

        $tokens = $tokenizer->tokenize($content);
        $bigrams = ngrams($tokens);
        $freqDist = new \TextAnalysis\Analysis\FreqDist($bigrams);
        $top10 = array_splice($freqDist->getKeyValuesByFrequency(), 0, 90);
        $result = [];
        foreach($top10 as $key=>$value){
            array_push($result,[$key,$value]);
        }
        return $result;
    }
    public function index()
    {

        // get the latest post
        $hansard =  $this->db->table($this->table)->select('id, title, content,publish_date')->orderBy('publish_date','desc')->get()->getFirstRow();
        $data = $this->getMentions($hansard->content);
        $topics = $this->getTopics(strtolower($hansard->content));
        return view('home_page',[
            'mps'=>array_slice($data["mps"],0,15),
            'mentions'=>array_slice($data["mentions"],0,15),
            'publish_date'=>$hansard->publish_date,
            'topics'=>$topics,
        ]);
    }
    public function hansards(string $dt){
        $hansard =  $this->db->table($this->table)->select('id, title, content,publish_date')->where('publish_date',$dt)->get()->getFirstRow();
        if($hansard==NULL){
            return view('missing_page',[
                'publish_date'=>$dt
            ]);
        }
        $data = $this->getMentions($hansard->content);
        $topics = $this->getTopics(strtolower($hansard->content));
        return view('home_page',[
            'mps'=>array_slice($data["mps"],0,15),
            'mentions'=>array_slice($data["mentions"],0,15),
            'publish_date'=>$hansard->publish_date,
            'topics'=>$topics
        ]);
    }
    public function hansardsInMonth(){
        $start_date = $this->request->getVar("start_date");
        $end_date = $this->request->getVar("end_date");
        $dates = $this->db->table($this->table)->select('publish_date')
        ->where('publish_date >=',$start_date)->where("publish_date <=",$end_date)->get()->getResultObject();   
        $days = [];
        foreach($dates as $date){
            $day = (int) explode("-",$date->publish_date)[2];
            array_push($days,$day);
        }
        return $this->response->setJSON($days);
    }
}
