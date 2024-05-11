<?php

namespace App\Services\Tools;

use Faker\Provider\Uuid;
use Illuminate\Http\UploadedFile as UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /** @var  UploadedFile */
    protected $media;
    protected $url;
    protected $uuid;
    protected $type = [''];
    private $quality = 100;

    public function dispatch(UploadedFile $file): static
    {
        $this->setMediaFile($file);
        return $this;
    }

    public function dispatchFromUrl(string $fileUrl): static
    {
        $info = pathinfo($fileUrl);
        $contents = file_get_contents($fileUrl);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);
        $uploadedFile = new UploadedFile($file, $info['basename']);
        $this->setMediaFile($uploadedFile);
        return $this;
    }

    public function dispatchFromBase64(string $fileBase64): static
    {
        $uploadedFile = $this->base64ToUploadedFile($fileBase64);
        $this->setMediaFile($uploadedFile);
        return $this;
    }

    public function setMediaFile(UploadedFile $file): void
    {
        $this->media = $file;
    }

    public function getName(): string
    {
        return $this->media->getClientOriginalName();
    }

    public function getSize(): bool|int
    {
        return $this->media->getSize();
    }

    public function uniqueName(): string
    {
        return str_replace(' ','-',$this->getName());
    }

    public function mediaUuid(): string
    {
        return $this->uuid = Uuid::uuid();
    }

    public function getUploader(): UploadedFile
    {
        return $this->media;
    }

    public function getExtension(): string
    {
        return $this->media->extension();
    }

    public function getMimeType(): string
    {
        return $this->media->getClientMimeType();
    }

    public function getUrl(): string
    {
        return $this->url . '/' . $this->uniqueName();
    }

    public function getType()
    {
        return $this->type[0];
    }

    public function getWebp($filePath)
    {
        $base = str_ends_with(config('app.url'), '/') ? config('app.url') : config('app.url') . '/';
//        If the image link is external
        if (str_contains($filePath, 'http') && !str_contains($filePath, config('app.url'))) {
            return $filePath;
        }
        $localPath = str_replace(config('app.url'),'',$filePath);
        $path = public_path($localPath);
        if (File::exists($path) && $filePath) {
//            if ($this->supportsWebp()) {
                $file = new UploadedFile($path,'name.extension');
                $webpPath = str_replace($file->extension(), 'webp', $filePath);
                $localPathWebp = str_replace(config('app.url'),'',$filePath);
                if (File::exists(public_path($localPathWebp))) {
                    return !str_contains($webpPath, config('app.url')) ? $base.$webpPath : $webpPath;
                }
//            }
            return !str_contains($filePath, config('app.url')) ? $base.$filePath : $filePath;
        }
        return $base . 'images/no-image.png';
    }

    public function upload(string $prefix = '_', $folder = 'public'): static
    {
        $dirName = $prefix . implode(' ', $this->type);
        $this->url = '/storage/' . $dirName;
        $file_name = $this->uniqueName();
        $this->getUploader()->storeAs($dirName, $file_name, $folder);
//        if (str_starts_with($this->getMimeType(), 'image')) {
            $webpName = str_replace($this->getExtension(), 'webp', $file_name);
            $this->createWebp(public_path('storage/'.$dirName.'/'.$webpName), 80);
//        }
        return $this;
    }

    public function deleteFile($file = null): bool
    {
        return Storage::delete(!is_null($file) ? $file : $this->getUrl());
    }

    public function createWebp(string $outputPath, int $quality = null): bool
    {
        $quality = $quality ?? $this->quality;
        $path = $this->getUploader()->path();
        $info = getimagesize($path);
        $isAlpha = false;

        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'image/gif':
                $isAlpha = true;
                $image = imagecreatefromgif($path);
                break;
            case 'image/png':
                $isAlpha = true;
                $image = imagecreatefrompng($path);
                break;
            case 'image/webp':
                $isAlpha = true;
                $image = imagecreatefromwebp($path);
                break;
            default:
                Log::info('Image mime type' . $info['mime'] . 'is not supported.');
        }

        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        imagewebp($image, $outputPath, $quality);

        return File::exists($outputPath);
    }

    private function supportsWebp(): bool
    {
        return str_contains(request()->header('Accept'), 'image/webp');
    }

    public function base64ToUploadedFile($base64Data, $destinationPath = 'uploads', $fileName = null, $desiredExtension = null): UploadedFile
    {
        // Extract the mime type and base64 data from the input
        list($type, $data) = explode(';', $base64Data);
        list(, $data) = explode(',', $data);

        // Determine the extension based on mime type or use the desired extension
        $extension = $desiredExtension ?? explode('/', $type)[1];

        // Generate a unique filename if not provided
        $fileName = $fileName ?? uniqid('image_') . '.' . $extension;

        // Decode the base64 data
        $decodedData = base64_decode($data);

        // Specify the disk where you want to store the file
        $disk = 'public';

        // Store the file to the specified disk
        Storage::disk($disk)->put("$destinationPath/$fileName", $decodedData);

        // Get the full path to the stored file
        $filePath = Storage::disk($disk)->path("$destinationPath/$fileName");

        // Create an UploadedFile instance
        $uploadedFile = new UploadedFile($filePath, $fileName, $type, null, true);

        // Add the original extension as a property
        $uploadedFile->originalExtension = $extension;

        return $uploadedFile;
    }
}
