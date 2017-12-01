<?php


class MovieService implements MovieServiceInterface
{
    private static $prefix = 'https://api.themoviedb.org/3/';
    private $apiKey;

    protected static $self;

    # Removing protected for testing purposes
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public static function getInstance()
    {
        if (empty(static::$self)) {
            static::$self = new MovieService(getenv('API_KEY'));
        }
        return static::$self;
    }

    /**
     * @codeCoverageIgnore
     */
    function get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        return array('response'=>$body, 'status'=>$status);
    }

    function request($suffix, $query, $language='en-US') {
        $url = self::$prefix . $suffix;
        $query['api_key'] = $this->apiKey;
        $query['language'] = $language;
        $get = http_build_query($query);
        $response = $this->get($url . '?' . $get);
        if ($response['status'] >= 400) {
            throw new Exception("Something went wrong :( ");
        }
        $obj = json_decode($response['response']);
        return $obj;
    }

    function retrieve($id): stdClass {
        return $this->request("movie/{$id}", array());
    }

    function search($title, $page=1): array
    {
        $query = array('query'=> $title, 'page'=> $page);
        return $this->request('search/movie', $query)->results;
    }

    function upcomings($page=1): array
    {
        return $this->request('movie/upcoming', array('page'=>$page))->results;
    }

    function genreList(): array
    {
        return $this->request('genre/movie/list', array())->genres;
    }
}