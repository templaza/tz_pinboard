<?php
/**
 * Google Shorner URL
 *
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @license         MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author          Sophy Prak, sophy.prak@gmail.com
 * @link            http://kooms.info
 */

defined("_JEXEC") or die;
/**
 * Define google url shortener api
 */
define("API_URL", "https://www.googleapis.com/urlshortener/v1/url?key=");

/**
 * GoogleURL to generate shorten and expend url
 *
 *
 */
class GoogleURL
{

    /**
     *
     * @var string
     */
    private $_apiUrl;

    /**
     * Short url
     *
     * @var string
     */
    private $_shortUrl;

    /**
     *
     * @param string $apiKey
     */
    public function  __construct($apiKey) {
        //Google URL Shortener 
        $this->_apiUrl = API_URL.$apiKey;
    }

    /**
     * Make shorten url
     *
     * @access public
     * @param string $longUrl long url
     * @return string shorten url
     */
    public function shorten($longUrl)
    {
        $data = $this->getContent($longUrl);
        $this->_shortUrl = $data->id;
        return $data->id;
    }

    /**
     * Expand short url
     *
     * @access public
     * @param string $shortUrl
     * @return string
     */
    public function expand($shortUrl)
    {
        $data = $this->getContent($shortUrl, "expand");
        $this->_shortUrl = $data->id;
        return $data->longUrl;
    }

    /**
     * Get number of long url click
     *
     * @access public
     * @return int
     */
    public function getLongUrlCliks(){
        $data = $this->getContent($this->_shortUrl, 'info');
        return $data->analytics->allTime->longUrlClicks;
    }
    /**
     * Get number of short url click
     *
     * @access public
     * @return int
     */
    public function getShortUrlClicks(){
        $data = $this->getContent($this->_shortUrl, 'info');
        return $data->analytics->allTime->shortUrlClicks;
    }

    /**
     * Get data from google api
     *
     * @param string $url
     * @param string $requestType
     * @return string json format
     */
    private function getContent( $url, $requestType = "shorten" ){

        $curl = curl_init();

        if( $requestType === "expand" ){
            curl_setopt($curl, CURLOPT_URL, $this->_apiUrl.'&shortUrl='.$url);
        }else if( $requestType === "info" ){
            curl_setopt($curl, CURLOPT_URL, $this->_apiUrl.'&shortUrl='.$url.'&projection=FULL');
        }else{
            curl_setopt($curl, CURLOPT_URL, $this->_apiUrl);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('longUrl' => $url)));
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        //change the response json string to object
        return json_decode($response);
    }
}

?>