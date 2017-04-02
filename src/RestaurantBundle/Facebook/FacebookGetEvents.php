<?php

namespace RestaurantBundle\Facebook;

use Psr\Log\LoggerInterface;

/*
 * Récupére les events de la page Facebook.
 */

class FacebookGetEvents
{

    const URL_API = "https://graph.facebook.com/v2.8/me?fields=id%2Cname%2Cevents.limit(5)%7Bname%2Cdescription%2Cstart_time%2Cend_time%2Ccover%7D&access_token=";
    const ACCESS_TOKEN = 'EAARcMJ0YY6MBAA05gI2NyZCaWpgmuCM3USHN1trkbqHO9DM3J9TBhyYA0hKoefY87WxHdKi2AHPrU9gxqVZCKQjvH04IgwNRcQ4n3rXJdmnx4ApoFOmURiIZBZAoAmHovRDnZC05ZB5QtUgdrpP9Vh2UyzTSLeT8MZD';
    const PATH_COVER = __DIR__ . '/../../../web/ImagesFacebookEventCovers/';

    private $logger;

    /**
     * Je définis un constructur afin d'avoir accès à l'interface logger comme argument de mon service
     * voir %kernel.logs_dir%/facebook.log
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Fais un appel à l'api facebook pour obtenir la liste des derniers events, s'il y en a.
     * Retourne le tableau des derniers evenement ou un message d'erreur de la part de Facebook
     * 
     * @return array
     */
    public function callEvents()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
        curl_setopt($ch, CURLOPT_URL, self::URL_API . self::ACCESS_TOKEN);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // pour requete post curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $jsonResult = curl_exec($ch);
        $result = json_decode($jsonResult, TRUE);
        if (isset($result['events']['data']))
        {
            /* l'appel c'est bien passé */
            return $result['events']['data'];
        } else if (isset($result['error']))
        {
            return $result;
        }
    }

    /**
     * 
     * @param type $urlImage: url de l'image sur le serveur de facebook
     * @param type $pathDestination: chemin de destination d'enregistrement
     * @param type $imageName: nom sos lequel sera enregistré l'image
     */
    public function downloadCovers($urlImage, $imageName)
    {

        $coverName = self::PATH_COVER . $imageName . '.png';

        if (!is_null($urlImage) && $urlImage != "")
        {
            $ch = curl_init($urlImage);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            $rawdata = curl_exec($ch);
            curl_close($ch);

            $fp = fopen($coverName, 'w');
            fwrite($fp, $rawdata);
            fclose($fp);
            return $coverName;
        } else
            return false;
    }

    /**
     * @return LoggerInterface
     * 
     */
    public function getLogger()
    {
        return $this->logger;
    }

}
