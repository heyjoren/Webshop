<?php
class Errorlog{
    const ERROR_FILE = "error/errors_log.log";
    const ERROR_FILE_sub = "../error/errors_log.log";
    private $errornr;
    private $errornericht;
    private $errorfile;
    private $errorline;

    public function __construct($errornr=0, $errornericht="", $errorfile="", $errorline="")
    {
        $this->errornr = $errornr;
        $this->errornericht = $errornericht;
        $this->errorfile = $errorfile;
        $this->errorline = $errorline;
    }

    public function Writeerror(){
        $error = "Error logged: op " . date("Y-m-d H-i-s - ");
        $error .= "[ " .$this->errornr. " ]: ";
        $error .= $this->errornericht. " in file " .$this->errorfile . " op lijn " . $this->errorline."\n";
        error_log($error, 3, self::ERROR_FILE);
    }
}

function handelUncaughtExeption($e){
    $log = new Errorlog($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    $log->Writeerror();
    exit("Er is een probleem. Contacteer de beheerder alstublieft.");
}

set_exception_handler('handelUncaughtExeption');

class MyException extends Exception {
    public function HandleException() {
        $log = new Errorlog($this->getCode(), $this->getMessage(), $this->getFile(), $this->getLine());
        $log->WriteError();
        echo("<div class='error' id='error'>");
            echo("<input class='kruis' type='button' value='x' onclick='kruis()'>");
            echo("<h3 id='errormsg'>" .$this->getMessage() . "</h3>");
        echo("</div>");
    }
}

?>