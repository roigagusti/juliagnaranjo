<?php
# crear clase Main(title,basedin,experience,projects,contact,experience_titles,up)
class Main{
    public $title;
    public $basedin;
    public $experience;
    public $projects;
    public $contact;
    public $experience_title_1;
    public $experience_title_2;
    public $experience_title_3;
    public $experience_title_4;
    public $up;

    public function __construct($title,$basedin,$experience,$projects,$contact,$experience_title_1,$experience_title_2,$experience_title_3,$experience_title_4,$up){
        $this->title = $title;
        $this->basedin = $basedin;
        $this->experience = $experience;
        $this->projects = $projects;
        $this->contact = $contact;
        $this->experience_title_1 = $experience_title_1;
        $this->experience_title_2 = $experience_title_2;
        $this->experience_title_3 = $experience_title_3;
        $this->experience_title_4 = $experience_title_4;
        $this->up = $up;
    }
}
# crear clase Experiencie(title,type,where,start,end,description,url,urlbeauty,tasks)
class Experiencie{
    public $title;
    public $type;
    public $where;
    public $start;
    public $end;
    public $description;
    public $url;
    public $urlbeauty;
    public $tasks;
    public $order;

    public function __construct($title,$type,$where,$start,$end,$description,$url,$urlbeauty,$tasks){
        $this->title = $title;
        $this->type = $type;
        $this->where = $where;
        $this->start = $start;
        $this->end = $end;
        $this->description = $description;
        $this->url = $url;
        $this->urlbeauty = $urlbeauty;
        $this->tasks = $tasks;
        $this->order = $start.$end;
    }
}
# crear clase Projecte(title,brand,description,position,contentType,url)
class Projecte{
    public $title;
    public $brand;
    public $description;
    public $column;
    public $contentType;
    public $url;
    public $confidencialidad;

    public function __construct($title,$brand,$description,$column,$contentType,$url,$confidencialidad){
        $this->title = $title;
        $this->brand = $brand;
        $this->description = $description;
        $this->column = $column;
        $this->contentType = $contentType;
        $this->url = $url;
        $this->confidencialidad = $confidencialidad;
    }
}

function api($url,$type,$auth,$json=''){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $notionVersion = "Notion-Version: 2022-06-28";
    $auth2 = "Authorization: Bearer ".$auth;

    # send a JSON POST request with curl with headers
    if($type == "POST"){
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        if($json != ''){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        }
        $accept = "Content-Type: application/json";
    }else{
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        $accept = "Accept: application/json";
    }

    $headers = array(
        $accept,
        $auth2,
        $notionVersion
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    $content = json_decode($resp, true);

    return $content;
}
function filter($property,$type,$filter,$content){
    $array = array(
        "filter" => array(
            "property" => $property,
            $type => array(
                $filter => $content
            )
        ),
        "sorts" => [
            array(
                "property" => "Order",
                "direction" => "ascending"
            )
        ]
    );
    return $array;
}
function createData($status,$name,$text,$find,$title){
    if($status == 'Active' && $name == $find){
        $title = $text;
    }else{
        $title = $title;
    }
    return $title;
}
function analisiMain($reponse){
    #comprovar que l'array $reponse[results] no està buida
    if(!empty($reponse['results'])){
        $title = '';
        $basedin = '';
        $experience = '';
        $projects = '';
        $contact = '';
        $experience_title_1 = '';
        $up = '';
        foreach($reponse['results'] as $key => $value){
            $name = $value['properties']['Name']['title'][0]['text']['content'];
            $type = $value['properties']['select']['name'];
            $text = $value['properties']['Text']['rich_text'][0]['text']['content'];
            $status = $value['properties']['Status']['select']['name'];
            
            $title = createData($status,$name,$text,'Title',$title);
            $basedin = createData($status,$name,$text,'Based in',$basedin);
            $experience = createData($status,$name,$text,'Experience',$experience);
            $projects = createData($status,$name,$text,'Projects',$projects);
            $contact = createData($status,$name,$text,'Contact',$contact);
            $experience_title_1 = createData($status,$name,$text,'Experience title 1',$experience_title_1);
            $experience_title_2 = createData($status,$name,$text,'Experience title 2',$experience_title_2);
            $experience_title_3 = createData($status,$name,$text,'Experience title 3',$experience_title_3);
            $experience_title_4 = createData($status,$name,$text,'Experience title 4',$experience_title_4);
            $up = createData($status,$name,$text,'Start again',$up);
        }
        $main = new Main($title,$basedin,$experience,$projects,$contact,$experience_title_1,$experience_title_2,$experience_title_3,$experience_title_4,$up);
    }else{
        $main = '';
    }
    return $main;
}
#function usort elements in list by Object.start descendent
function usortByStartDESC($a, $b) {
    return strcmp($b->start, $a->start);
}
function usortByEndDESC($a, $b) {
    return strcmp($a->start, $b->start);
}
function usortByOrderDESC($a, $b) {
    return strcmp($b->order, $a->order);
}
function analisiExperience($reponse){
    #comprovar que l'array $reponse[results] no està buida
    if(!empty($reponse['results'])){
        $rows = [];
        foreach($reponse['results'] as $key => $value){
            #crear una instancia de la classe Experiencie i afegir l'objecte a l'array $rows
            $title = $value['properties']['Title']['title'][0]['text']['content'];
            $type = $value['properties']['Type']['select']['name'];
            $where = $value['properties']['Where']['rich_text'][0]['text']['content'];
            $start = $value['properties']['startYear']['formula']['number'];
            $end = $value['properties']['endYear']['formula']['number'];
            $description = $value['properties']['Description']['rich_text'][0]['text']['content'];
            $url = $value['properties']['Url']['rich_text'][0]['text']['content'];
            $urlbeauty = $value['properties']['Url-text']['rich_text'][0]['text']['content'];
            $tasks = $value['properties']['Tasks']['rich_text'][0]['text']['content'];
            $rows[] = new Experiencie($title,$type,$where,$start,$end,$description,$url,$urlbeauty,$tasks);
        }
    }
    #sort rows by start 9->1 and then by end 9->1
    usort($rows, 'usortByEndDESC');
    usort($rows, 'usortByStartDESC');
    usort($rows, 'usortByOrderDESC');
    return $rows;
}
function analisiProjecte($reponse){
    #comprovar que l'array $reponse[results] no està buida
    if(!empty($reponse['results'])){
        $rows = [];
        foreach($reponse['results'] as $key => $value){
            #crear una instancia de la classe Projecte i afegir l'objecte a l'array $rows
            $title = $value['properties']['Title']['title'][0]['text']['content'];
            $brand = $value['properties']['Brand']['rich_text'][0]['text']['content'];
            $description = $value['properties']['Description']['rich_text'][0]['text']['content'];
            $column = $value['properties']['Column']['select']['name'];
            $contentType = $value['properties']['Content type']['select']['name'];
            $url = $value['properties']['URL']['url'];
            #if $value['properties']['Confidencialidad']['select']['name'] exists ... else ...
            if(isset($value['properties']['Confidencialidad']['select']['name'])){
                $confidencialidad = $value['properties']['Confidencialidad']['select']['name'];
            }else{
                $confidencialidad = 'Show';
            }
            $rows[] = new Projecte($title,$brand,$description,$column,$contentType,$url,$confidencialidad);
        }
    }
    return $rows;
}
?>