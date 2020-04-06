<?php

class Filter
{

    public $hardFile = __DIR__.'/hard.txt';
    public $softFile = __DIR__.'/soft.txt';
    public $hardRegex = '(%s)';
    public $dictionary = array();
    public $text;
    public $delimiter = "****";

    public function __construct()
    {
        $this->initDictionary();
    }

    public function initDictionary()
    {
        $hard = $this->hardFile;
        $soft = $this->softFile;

        if (!file_exists($hard) || !file_exists($soft)) {
            return $this;
        }
            $this->dictionary["hard"] = $this->getResourceData($hard);
            $this->dictionary["soft"] = $this->getResourceData($soft);
        return $this;
    }

    private function getResourceData($file)
    {
        return explode("\n", file_get_contents($file));
    }

    public function setText($text){
        $this->text = $text;
        return $this;
    }

    public function replaceSoft()
    {
        $dictionary = $this->dictionary;
        $text_array = explode(" ", $this->text);
        $new_text = array();

        foreach ($text_array as $word){
            $word_leng = strlen($word);
            foreach ($dictionary["soft"] as $tabu){
                if(strtolower($word) == $tabu){
                    $word = $this->delimiter;
                    /*$word = "";
                    for($i = 0; $i < $word_leng; $i++){
                            $word .= $this->delimiter;
                    }*/
                }
            }
            array_push($new_text, $word);
        }

        $this->text = implode(" ",$new_text);

        return $this->text;
    }
    public function replaceHard()
    {
        $dictionary = $this->dictionary;

        $tabus = array_merge($dictionary["hard"],$dictionary["hard"]);

        foreach ($tabus as $tabu){
            $regex = sprintf($this->hardRegex, $tabu);
            $this->text = preg_replace($regex, $this->delimiter, $this->text);
        }

        return $this->text;
    }

    public function replace()
    {
        $this->replaceSoft();
        $this->replaceHard();

        return $this->text;
    }
}