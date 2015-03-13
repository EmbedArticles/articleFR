<?
class URLShortener {

    public $invalid = "you did not provide a valid url";    
    public $error = "an error has occurred, please give it another try";    
    public $url;
    public $notfound = "/404.php"; // path to 404 page
    
    
    public function __construct() {        
        $this->url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL); // validate url
    }
    
            
    public function shorten() {        
        if ( $this->url ) {
            return $this->create();
        } else {            
            return $this->invalid;
        }
    }
    
        
    private function create() {
        global $dbh;
        $stmt = $dbh->prepare("INSERT INTO shorturls VALUES (?, ?, NOW());");
        $stmt->execute(array($this->short(), $this->url));   
        if ($stmt->rowCount()) {
            $stmt = $dbh->query("SELECT shorturl FROM shorturls ORDER by date DESC LIMIT 0, 1");
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $response['shorturl'];
        } else {
            return $this->retry(); // 4x
        }
    }
    
        
    private function retry() {
        static $count = 0;
        $count++;
        if ($count < 3 ) {
            return $this->create();
        }
        return $this->error; // give up, time for cron table cleanup
    }
    
            
    private function short() {
        $short = "";
        $charset = "abcdefghijkmnpqrstuvwxyz0123456789";
        for ($i = 0; $i < 4; $i += 1) {  // generate short string length 4
            $short .= $charset[mt_rand(0, strlen($charset) - 1)];
        }
        return $short;
    }
    
            
    public function retrieve() {
        global $dbh;        
        $shorturl = str_replace('/', '', $_SERVER['REQUEST_URI']); // make sure to remove forward slahes if any        
        $stmt = $dbh->prepare("SELECT url from shorturls WHERE shorturl = ?");
        $stmt->execute(array($shorturl));
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($response) {
            header('Location:' . $response['url']); // good bye
        } else {
            header('Location:' . $this->notfound); // not found
        }
    }
    
}
?>