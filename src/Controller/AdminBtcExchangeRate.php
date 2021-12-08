<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\Type\BtcRatesUrlType;
use App\Service\StoreBtcRatesData;
use App\Entity\BtcRatesUrl;
use App\Entity\BtcExchangeRates;

class AdminBtcExchangeRate extends AbstractController{

    /**
     * attributes
     */
    private $sessionData;

    /**
     * constructor, retrieves session information, session id for the token
     */
    public function __construct(){
        $session = new Session();   
        $this->sessionData = $session->getId();
    }

    /**
     * @Route("/admin/btc_exchange_rates", name="btc_exchange_rates")
     */
    public function index(Request $request): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN');

        //BtcRatesUrl object
        $btcRates = new BtcRatesUrl();

        //form object
        $form = $this->createForm(BtcRatesUrlType::class, $btcRates);

        //validate form data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$rss` variable has also been updated
            $btcRates = $form->getData();

            // perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($btcRates);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('btc_exchange_rates');
        }

        //list all rss feeds stored in the db
        $repository = $this->getDoctrine()->getRepository(BtcRatesUrl::class);
        $ratesUrl = $repository->findAll();

        //list rates data 
        $repository = $this->getDoctrine()->getRepository(BtcExchangeRates::class);
        $rate = $repository->findAll();

        return $this->render('private/admin/_btc_exchange_rates.html.twig', [
            'user_token' => $this->sessionData,
            'form' => $form->createView(),
            'rates_url' => $ratesUrl,
            'rate' => $rate
        ]);
    }

    /**
     * @Route("/btcrates-manual-check", name="btcrates-manual-check")
     */
    public function BtcRatesManualCheck(Request $request): Response{
        if ($request->isXMLHttpRequest()) {      
            //store btc rates object
            $rt = new StoreBtcRatesData($this->getDoctrine()->getManager());

            //try to save rates
            if($rt->saveRatesData()){
                return new Response('{"done":"done"}', 200);
            }

            return new Response('{"error":"error"}', 200);
        }
    
        return new Response('{"error":"error"}', 200);
    }
}
