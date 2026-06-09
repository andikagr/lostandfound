<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    protected string $projectUrl;
    protected string $serviceKey;
    protected string $bucket;

    public function __construct()
    {
        $this->projectUrl = 'https://vguradhjcpkuijqhfllg.supabase.co';
        $this->serviceKey = env('SUPABASE_SERVICE_KEY', '');
        $this->bucket = 'item-images';
    }

    /**
     * Upload a file to Supabase Storage and return the public URL.
     */
    public function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $folder . '/' . uniqid() . '_' . time() . '.' . $extension;
        $mimeType = $file->getMimeType();
        $fileContent = file_get_contents($file->getRealPath());

        $url = "{$this->projectUrl}/storage/v1/object/{$this->bucket}/{$filename}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $fileContent,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer {$this->serviceKey}",
                "Content-Type: {$mimeType}",
                "x-upsert: true",
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 || $httpCode === 200) {
            return "{$this->projectUrl}/storage/v1/object/public/{$this->bucket}/{$filename}";
        }

        // Fallback: return null if upload failed
        return null;
    }

    /**
     * Delete a file from Supabase Storage by its public URL.
     */
    public function delete(string $publicUrl): void
    {
        $prefix = "{$this->projectUrl}/storage/v1/object/public/{$this->bucket}/";
        if (!str_starts_with($publicUrl, $prefix)) {
            return;
        }

        $path = str_replace($prefix, '', $publicUrl);
        $url = "{$this->projectUrl}/storage/v1/object/{$this->bucket}/{$path}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer {$this->serviceKey}",
            ],
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}
