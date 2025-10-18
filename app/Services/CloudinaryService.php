<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        // For Windows development - configure SSL handling
        if (app()->environment('local') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Try using CA certificate first
            $caCertPath = storage_path('cacert.pem');
            if (file_exists($caCertPath)) {
                ini_set('curl.cainfo', $caCertPath);
                ini_set('openssl.cafile', $caCertPath);
            }
            
            // Set global cURL options for SSL bypass as fallback
            $defaultOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_CONNECTTIMEOUT => 60,
            ];

            // Set environment variables
            putenv('CURLOPT_SSL_VERIFYPEER=0');
            putenv('CURLOPT_SSL_VERIFYHOST=0');
        }

        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    /**
     * Upload poster image to Cloudinary
     */
    public function uploadPoster(UploadedFile $file): array
    {
        try {
            // For Windows - create custom stream context with SSL disabled
            if (app()->environment('local') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Set stream context options (but don't set as default due to type issues)
                $context = stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                    'http' => [
                        'timeout' => 120,
                        'user_agent' => 'CloudinaryPHP/1.0 (Windows Development)'
                    ]
                ]);
                
                // Also configure libcurl
                if (function_exists('curl_setopt_array')) {
                    $defaultCurlOptions = [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                        CURLOPT_TIMEOUT => 120,
                        CURLOPT_CONNECTTIMEOUT => 60,
                        CURLOPT_USERAGENT => 'CloudinaryPHP/1.0 (Windows Development)',
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_MAXREDIRS => 5,
                    ];
                    
                    // Apply globally
                    $ch = curl_init();
                    curl_setopt_array($ch, $defaultCurlOptions);
                    curl_close($ch);
                }
            }

            // Configure upload with retry mechanism
            $uploadOptions = [
                'folder' => 'movie-posters',
                'transformation' => [
                    'width' => 500,
                    'height' => 750,
                    'crop' => 'fit',
                    'quality' => 'auto'
                ],
                'allowed_formats' => ['jpg', 'jpeg', 'png', 'webp'],
                'resource_type' => 'image',
                'timeout' => 120
            ];

            $result = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            return [
                'success' => true,
                'url' => $result['secure_url'],
                'public_id' => $result['public_id']
            ];
        } catch (\Exception $e) {
            // Log detailed error for debugging
            Log::error('Cloudinary upload error: ' . $e->getMessage(), [
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'file_name' => $file->getClientOriginalName()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete poster from Cloudinary
     */
    public function deletePoster(string $publicId): bool
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            return $result['result'] === 'ok';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Extract public_id from Cloudinary URL
     */
    public function getPublicIdFromUrl(string $url): ?string
    {
        if (strpos($url, 'cloudinary.com') === false) {
            return null;
        }

        // Extract public_id from URL
        preg_match('/\/v\d+\/(.+)\.[a-zA-Z]{3,4}$/', $url, $matches);
        return $matches[1] ?? null;
    }
}