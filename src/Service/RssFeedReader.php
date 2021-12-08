<?php
namespace App\Service;

class RssFeedReader
{
    private $rss_xml_data;

    /**
     * construct, param xml feed data url
     */
    public function __construct(string $url){
        $this->setRssXmlData($url);
    }

    /**
     * setter and getter
     */

    public function setRssXmlData(?string $url): self{
        $this->rss_xml_data = $this->readFeddData($url);

        return $this;
    }

    public function getRssXmlData(): ?string{
        return $this->rss_xml_data;
    }

    /**
     * retrieves xml data from some long lost feed on the deepest darkest corner on the web
     */
    public function readFeddData(string $url): ?string{
        //var $xml, stores the xml data from the feed
        $xml = '';

        //try to open the url
        $feed_file = @\fopen($url, "r");

        if($feed_file){
            //read one line at the time and stores it in the $xml var
            while (!\feof($feed_file)) {
                $line = \fgets($feed_file);
                $xml .= $line !== false ? $line : '';
            }
            \fclose($feed_file);
        }

        return $xml;
    }

}