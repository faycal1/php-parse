<?php 

namespace Faycal ;

use PHPHtmlParser\Dom;

/**
 * 
 */
class linkLoader 
{
	/**
	 * [$url description]
	 * @var [type]
	 */
	protected $url ;
	/**
	 * [$attribute description]
	 * @var [type]
	 */
	protected $attribute ;
	/**
	 * [$contents description]
	 * @var [type]
	 */
	protected $contents ;
	/**
	 * [$collection description]
	 * @var array
	 */
	protected $collection = array() ;

	/**
	 * [$dom description]
	 * @var [type]
	 */
	protected $dom ;

	/**
	 * [$tag description]
	 * @var [type]
	 */
	protected $tag ;

	/**
	 * [$page description]
	 * @var array
	 */
	static $pages = array(
		'page-2',
		'page-3',
		'page-4',
		'page-5',
		'page-6',
		'page-7',
		'page-8',
		'page-9',
		'page-10',
		'page-11',
		'page-12',
		'page-13',
		'page-14',
		'page-15',
		'page-16',
		'page-17',
		'page-18',
		'page-19',
		'page-20',
		);
    
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		
	}

	/**
	 * [connexion create a connexion and return the html tp parse]
	 * @param  [type] $url       [the url of the service]
	 * @param  [type] $attribute [class or tag attribute ]
	 * @return [html]            [return the html for parsing]
	 */
	public function connexion($url , $attribute , $tag , $categorie = true)
	{		
		$D = $this->setDom(new Dom)->dom;		
		$D->load($this->setUrl($url)->url);
		$contents = $D->find($this->setAttribute($attribute)->attribute);

		return $this->parser($this->setContents($contents)->contents , $this->setTag($tag)->tag , $categorie) ;
	}

	/**
	 * [parser the html ]
	 * @param  [type] $contents [the html to parse]
	 * @return [array]           [a collection of link and their respectives texts]
	 */
	private function parser($contents , $tag , $categorie)
	{	

		$categorie ? $categorie = 'categorie' :  $categorie = 'adresse' ;	
		foreach ($this->setContents($contents)->contents as $key => $value) {
			if(!empty($value))
			{
				$outerHtml = $value->outerHtml ;

				$d = new \DOMDocument();
				$d->loadHTML(preg_replace('/&/', ' et ' , $outerHtml));

				foreach ($d->getElementsByTagName($this->getTag()) as $node) {
						array_push(
							$this->setCollection($this->collection)->collection,
							array(
									'href'=>$node->getAttribute( 'href' ) ,
									$categorie =>utf8_decode( $node->nodeValue ),
									'title'=>utf8_decode($node->getAttribute( 'title' )) ,
								)
							);
				}
			}
		}
		
		// $value = $this->setContents($contents)->contents[0] ;

		

		// if(!empty($value))
		// 	{
		// 		$innerHtml = $value->outerHtml ;

		// 		$d = new \DOMDocument();

		// 		$d->loadHTML(preg_replace('/&/', ' et ' , $innerHtml));

		// 		foreach ($d->getElementsByTagName($this->getTag()) as $node) {
		// 				array_push(
		// 					$this->setCollection($this->collection)->collection,
		// 					array(
		// 							'href'=>$node->getAttribute( 'href' ) ,
		// 							$categorie =>utf8_decode( $node->nodeValue ),
		// 							'title'=>utf8_decode($node->getAttribute( 'title' )) ,
		// 						)
		// 					);
		// 		}
		// 	}


		return $this->getCollection() ;
	}

    /**
     * Gets the [$url description].
     *
     * @return [type]
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the [$url description].
     *
     * @param [type] $url the url
     *
     * @return self
     */
    protected function setUrl( $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets the [$attribute description].
     *
     * @return [type]
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Sets the [$attribute description].
     *
     * @param [type] $attribute the attribute
     *
     * @return self
     */
    protected function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Gets the [$contents description].
     *
     * @return [type]
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Sets the [$contents description].
     *
     * @param [type] $contents the contents
     *
     * @return self
     */
    protected function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Gets the [$collection description].
     *
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Sets the [$collection description].
     *
     * @param array $collection the collection
     *
     * @return self
     */
    protected function setCollection(array $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Gets the [$dom description].
     *
     * @return [type]
     */
    public function getDom()
    {
        return $this->dom;
    }

    /**
     * Sets the [$dom description].
     *
     * @param [type] $dom the dom
     *
     * @return self
     */
    protected function setDom(Dom $dom)
    {
        $this->dom = $dom;

        return $this;
    }

    /**
     * Gets the [$tag description].
     *
     * @return [type]
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets the [$tag description].
     *
     * @param [type] $tag the tag
     *
     * @return self
     */
    protected function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }
}