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
        return file_get_contents($url);
    }

    function request($suffix, $query, $language='en-US') {
        $url = self::$prefix . $suffix;
        $query['api_key'] = $this->apiKey;
        $query['language'] = $language;
        $get = http_build_query($query);
        $json = $this->get($url . '?' . $get);
        $obj = json_decode($json);
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
}