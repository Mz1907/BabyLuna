<?php

namespace RestaurantBundle\Controller\FacebookController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * Cette classe de controlleur est responsable de la gestion des erreurs en cas
 * d'erreurs renvoyés par l'api facebook
 */

class EventErrorController extends Controller
{
    /*
     * Gestion des erreurs lors de l'appel à l'api facebook
     * Si facebook api renvoie une erreur alors print_r le tableau d'erreur dans facebook.log
     * Si erreure lors de l'insertion d'un nouveal event en bdd alors echo message dans facebook.log
     * return void
     * @param $lastEvents null | array  la valeur de la variable $lastEvents dans FacebookEventController
     * 
     */
    public function errorInsertingFacebookAction($lastEvents)
    {
        $facebookEventService = $this->get('facebook.getEvents');

        if (is_null($lastEvents))
        {
            $errorMessage = "Erreure lors d'insertion d'un event facebook ";
            $errorMessage .= " Voir " . __FILE__;
            $facebookEventService->getLogger()->info($errorMessage);

        } elseif (isset($lastEvents['error']))
        {
            $errorMessage = "Erreure lors de l'appel de l'api: ";
            $errorMessage .= " Voir " . __FILE__;
            //j'imprime le contenu de la variable $lastEvents dans mon fichier log
            $errorMessage .= var_export($lastEvents, true);
            $facebookEventService->getLogger()->error($errorMessage);
        }
        
        return $this->render('RestaurantBundle:Front/Event:lastEvents.html.twig', [
                        //'existingEvents' => $existingEventsId,
                        //'lastEvents' => $lastEvents
        ]);
    }

}
