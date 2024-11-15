<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/git')]

class GitController extends AbstractController
{
    #[Route("/check-head", name: "check_head", methods: ["GET"])]


    public function checkHead(): Response{
            $arr = [];
            $returnStatus = 0;
            
            // Call the upgrade.sh script and capture the output in $arr and the return status in $returnStatus
            exec('echo "dupa"; file=$(find $HOME -name upgrade.sh); echo "dupa; echo $file; out=$(file); echo $out', $arr, $returnStatus);
            var_dump(shell_exec('echo "dupa"; file=$(find $HOME -name upgrade.sh); echo $file; out=$(file) && echo $out && echo "dupa"' ));
            if ($returnStatus !== 0) {
                // Return a 500 response indicating the script was not executed successfully
                return new Response('STH went wrong. ' . json_encode($arr), 500);
            }
    
            // Return a 200 response indicating the script was executed
            return new Response('Upgrade script executed and SHA updated. ' . json_encode($arr), 200);
        }
    
}
