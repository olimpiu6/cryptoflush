<?php
namespace App\Service;

use App\Service\RssFeedReader;
use App\Entity\Post;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class StoreRssData{

    private $rss_url;
    private $em;

    public function __construct($url, EntityManagerInterface $em){
        $this->setRssUrl($url);
        $this->em = $em;
    }

    /**
     * setters, getters
     */
    public function setRssUrl(string $url){
        $this->rss_url = $url;

        return $this;
    }

    public function getRssUrl(){
        return $this->rss_url;
    }

    /**
     * traveses the xml document looking for nodes
     */
    public function xmlReader(){
        //new rss reader, gets rss data from url
        $rssreader = new RssFeedReader($this->getRssUrl());
        $xml = $rssreader->getRssXmlData();

        //array storing the important fields form rss: title, description, link(news link)
        $rss_data = array();

        //dom crawler, filter xml data, gets each field from rss data
        $crawler = \simplexml_load_string($xml);
        
        //check if xml object is set
        if($crawler){
            //loop xml elements
            foreach($crawler as $val){
                //search and loop trought item elements
                if($val->item && \is_iterable($val->item)){
                    //rss data arrayelements index variable
                    $ct = 0;
                    foreach($val->item as $v){
                        //check all fields and store in rss data array if correct
                        if($this->validateField($v->title) && 
                           $this->validateField($v->link) &&
                           $this->validateField($v->description)){
                                //create array with data
                                $rss_data[$ct]['title'] = $v->title;
                                $rss_data[$ct]['link'] = $v->link;
                                $rss_data[$ct]['description'] = $v->description;
                        }
                        $ct++;
                    }
                }
            }  
        }
       
        return $rss_data;
    }

    /**
     * checks if field is ok, not empty and exists
     */
    public function validateField($field){
        $data = isset($field) ? $field : false;

        if($data && !empty($data)){
            return $data; 
        }

        return $data;
    }

    /**
     * create internal url from title, works with english alphabet
     * and for my other language speaking brothers an sisters: learn english beeb beeeb
     */
    public function makeInnerUrl($txt){
        $txt = !empty($txt) ? \strtolower($txt) : false;

        if($txt){
            $txt = str_replace(' ', '-', $txt);
            $txt = preg_replace('/[^a-zA-Z0-9-.]/', '', $txt);
            return $txt;
        }

        return $txt;
    }

    /**
     * decide to wich category post belongs, looks for specific string in title
     */
    public function catMaker($txt, $title){
        $txt = !empty($txt) ? \strtolower($txt) : false;
        $title = !empty($title) ? \strtolower($title) : false;
        
        if($txt && $title){
            if(\strpos($title, $txt)){
                return true;
            }
        }
        
        return false;
    }

    /**
     * check for duplicate post
     */
    public function checkDuplicates($url, $post_repo){
        $post = new Post();
        $duplicate = $post_repo->findBy(array('utl'=>$url));

        return $duplicate;
    }

    /**
     * stores rss info to data base
     */
    public function rssToDatabase(){
        //array with rss data
        $data = $this->xmlReader();

        //doctrine entity manager
        $post_repo = $this->em->getRepository(Post::class);
        $cat_repo = $this->em->getRepository(Category::class);
        
        //check if data has ... data ;) 
        if(\count($data) > 0){
            foreach($data as $k => $v){
                if( $this->validateField($v['title']) && 
                    $this->validateField($v['link']) &&
                    $this->validateField($v['description']) ){
                        //new post object
                        $post = new Post();

                        //make inner url
                        $url = $this->makeInnerUrl($v['title']);
                        $url = $url !== false ? $url : 'crypto-news-' . \time();

                        //check for duplicates
                        if($this->checkDuplicates($url, $post_repo)){
                            continue;
                        }

                        //asign category with id 1 by default, news
                        $cat = $cat_repo->find(1);

                        //set post data
                        $post->setTitle($v['title']);
                        $post->setUtl($url);
                        $post->setPublishDate(\time());
                        $post->setActive(1);
                        $post->setLang('en');
                        $post->setContent($v['description']);
                        $post->setFeedLink($v['link']);
                        $post->addCategory($cat);

                        //persist post data
                        $this->em->persist($post);
                        $this->em->flush();
                        unset($post);
                }
            }
        }
    }
}