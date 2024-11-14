<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/git')]

class GitController extends AbstractController
{
    #[Route("/check-head", name: "check_head", methods: ["GET"])]


    public function checkHead(): Response
     {
            // Call the upgrade.sh script
            exec(__DIR__ . 'upgrade.sh');
    
            // Return a 200 response indicating the script was executed
            return new Response('Upgrade script executed and SHA updated.', 200);
    }
}
