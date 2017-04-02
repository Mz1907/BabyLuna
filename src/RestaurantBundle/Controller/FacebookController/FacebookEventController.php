<?php

namespace RestaurantBundle\Controller\FacebookController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RestaurantBundle\Entity\FacebookEvent;

class FacebookEventController extends Controller
{

    public function lastEventsAction()
    {           
        $facebookEventService = $this->get('facebook.getEvents');
        $lastEvents = $facebookEventService->callEvents();
        
        
        if (!$lastEvents || isset($lastEvents['error']))
        {
            return $this->forward('RestaurantBundle:FacebookController\EventError:errorInsertingFacebook', 
                    [
                        'lastEvents' => $lastEvents
                    ]);
        }

        $this->getExistingsAndSaveAction($lastEvents, $facebookEventService);

        return $this->render('RestaurantBundle:Front/Event:lastEvents.html.twig', [
                        //'existingEvents' => $existingEventsId,
                        //'lastEvents' => $lastEvents
        ]);
    }

    public function getExistingsAndSaveAction(array $lastEvents, $facebookService)
    {
        $repoEvent = $this->getDoctrine()->getManager()->getRepository('RestaurantBundle:FacebookEvent');
        $existingEventsId = $repoEvent->eventsExists($lastEvents);

        //count($existingEventsId) == count($lastEvents) signifie que tout les events sont déjà présents dans la bdd.
        if (!(count($existingEventsId) == count($lastEvents)))
        {
            if (count($existingEventsId) != 0)
            {
                //s'il y a malgré tout des events déjà present en bdd on les supprimes de $lastEvents
                $lastEvents = $this->removeMatchedEventAction($lastEvents, $existingEventsId);
            }

            $this->persistAndSaveAction($lastEvents, $facebookService);
        }
    }

    /**
     * @param array $lastEvents
     * @param type $facebookService: instance du service FacebookEventController
     *  ces id doivent matcher avec les id des lastEvents
     */
    public function persistAndSaveAction(array $lastEvents, $facebookService)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($lastEvents as $event)
        {
            /* téléchargement de la cover de l'event s'il y en a une */
            $coverNameTemp = preg_replace('/\s+/', '-', $event['name']);
            $coverName = $facebookService->downloadCovers($event['cover']['source'], $coverNameTemp);

            $fe = new FacebookEvent();
            $fe->setName($event['name']);
            $fe->setDescription($event['description']);
            $fe->setDateStart(new \DateTime($event['start_time']));
            $fe->setDateEnd(new \DateTime($event['end_time']));
            $fe->setFacebookId($event['id']);
            if ($coverName)
            {
                $fe->setCover($coverName);
            }
            $em->persist($fe);
        }
        $em->flush();
        if (null == $fe->getId())
        {
            /*
             * TODO
             * la propriété id n'existe qu'après le flush de doctrine
             * si id n'existe pas, c'est que le flush c'est mal passé
             * on écris cela dans le fichier de log
             */
        }
    }

    /*
     * supprime les events presents dans le tableau dont l'id est donné
     * par $eventsId
     * 
     * @return array
     */

    public function removeMatchedEventAction(array $lastEvents, array $presentsId)
    {

        for ($i = 0; $i < count($lastEvents); $i++)
        {
            if (in_array($lastEvents[$i]['id'], $presentsId))
            {
                array_splice($lastEvents, $i, 1);
            }
        }

        return $lastEvents;
    }

}
