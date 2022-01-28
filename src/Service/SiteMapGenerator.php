<?php
namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class SiteMapGenerator{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * google sitemap generator
     */
    public function GoogleSiteMap(){
        //google xml syntax, header and las xml tag
        $xml_head = '<?xml version="1.0" encoding="UTF-8"?>
                        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml_foot = '</urlset>';

        //get post repository
        $post_repo = $this->em->getRepository(Post::class);
        $url_list = $post_repo->getAllPostsUrl();

        
    }

}