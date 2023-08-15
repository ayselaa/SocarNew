<?php
class sqlinj{
    private $gerideger;
    private $islet;
    public $liste=array('declare','char','set','cast','convert','drop','exec','script','select','truncate','insert','delete','union','update','create','where','join','show_table','mysql_list_tables','mysql_list_fields','information_schema','table_schema','into');
    private $specialfind=array('\'','"','*','=');
    private $specialreplace=array('&#39;','&#34;','&#42;','&#61;');
    public function clean($find){
        return str_replace($this->specialfind,$this->specialreplace,$find);
    }
    public function basla($veri,$tur='normal'){
        if($tur=='normal'){
            return self::normal(self::clean($veri));
        }elseif($tur=='all'){
            return self::butunsorgular($veri);
        }else{
            return self::req($tur,$veri);
        }
    }
    private function normal($deger){
        foreach($this->liste as $axtar){
            $deger=str_replace($axtar,'\\'.$axtar.'\\',$deger);

        }
        return $deger;
    }
    private function butunsorgular($olunacaq){
        switch ($olunacaq){
            case 'post':
                $this->islet=array('POST');
                break;
            case 'get':
                $this->islet=array('GET');
                break;
            case 'request':
                $this->islet=array('REQUEST');
                break;
            case 'aio':
                $this->islet=array('POST','GET','REQUEST');
                break;
        }	
        foreach($this->islet as $emeliyyat){
            eval('foreach($_'.$emeliyyat.' as $ad=>$deger){
                $_'.$emeliyyat.'[$ad]=self::clean($deger);
                foreach($this->liste as $axtar){
                $_'.$emeliyyat.'[$ad]=str_replace($axtar,"\\\".$axtar."\\\",$_'.$emeliyyat.'[$ad]);
                }
                }


                return $_'.$emeliyyat.';
            ');
        }
    }
    private function req($deger,$method){
        switch ($method){
            case 'post':
                $this->islet=self::clean($_POST[$deger]);
                break;
            case 'get':
                $this->islet=self::clean($_GET[$deger]);
                break;
            case 'request':
                $this->islet=self::clean($_REQUEST[$deger]);
                break;
        }	
        foreach($this->liste as $axtar){
            $this->islet=str_replace($axtar,'\\'.$axtar.'\\',$this->islet);

        }
        return $this->islet;	
    }
    public function elaveet($elaveolunan){
        $this->liste[]=$elaveolunan;
    }
}

?>
