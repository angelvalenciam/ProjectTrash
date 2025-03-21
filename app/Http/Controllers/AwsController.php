<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\Credentials;

class AwsController extends Controller
{
    public function index()
    {
        // Cargar credenciales desde el archivo .env
        $credentials = new Credentials(
            env('AWS_ACCESS_KEY_ID'), 
            env('AWS_SECRET_ACCESS_KEY')
        );

        try {
            $client = new S3Client([
                'version' => 'latest',
                'region' => env('AWS_REGION', 'us-east-2'),
                'credentials' => $credentials
            ]);

            $buckets = $client->listBuckets();

            $bucketNames = [];
            foreach ($buckets['Buckets'] as $bucket) {
                $bucketNames[] = $bucket['Name'];
            }

            return response()->json([
                'success' => true,
                'buckets' => $bucketNames
            ]);

        } catch (S3Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
