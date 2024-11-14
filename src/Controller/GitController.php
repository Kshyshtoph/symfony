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
        // Get the GitHub repository owner and name from environment variables
        $owner = getenv('GITHUB_OWNER');
        $repo = getenv('GITHUB_REPO');
    
        // GitHub API URL to get the last commit SHA of the master branch
        $url = "https://api.github.com/repos/$owner/$repo/commits/master";
    
        // Set up the context for the API request
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP'
                ]
            ]
        ]);
    
        // Get the JSON response from the GitHub API
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
    
        // Get the current HEAD SHA from the API response
        $currentHead = $data['sha'];
    
        // Check if sha.txt exists
        if (file_exists('sha.txt')) {
            // Read the stored SHA from sha.txt file
            $storedSha = trim(file_get_contents('sha.txt'));
        } else {
            // If sha.txt does not exist, set storedSha to an empty string
            $storedSha = '';
        }
    
        if ($currentHead === $storedSha) {
            // Return 304 if they are the same
            return new Response('', 304);
        } else {
            // Call the upgrade.sh script
            exec('#bash upgrade.sh');
    
            // Write the new SHA to sha.txt
            file_put_contents('sha.txt', $currentHead);
    
            // Return a 200 response indicating the script was executed
            return new Response('Upgrade script executed and SHA updated.', 200);
        }
    }
}
