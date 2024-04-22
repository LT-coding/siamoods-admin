<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(Request $request): Application|Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        // Get the path to the sitemap.xml file
        $filePath = public_path('sitemap.xml');

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the content of the file
            $content = file_get_contents($filePath);

            // Set response headers
            $headers = [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="sitemap.xml"',
            ];

            // Return the content as a response
            return response($content, 200, $headers);
        } else {
            // If file doesn't exist, return a 404 response
            return response()->json(['error' => 'Sitemap not found'], 404);
        }
    }
}
