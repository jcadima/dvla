<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait WithStoreFiles
{
    use WithFileUploads;

    public function storeToDisk($file, $object, $diskLocation, $updateField)
    {
        try {
            $filename = time().'_'.$file->getClientOriginalName();
            $fileContents = File::get($file->getRealPath());

            Storage::disk($diskLocation)->put($filename, $fileContents);

            $object->update([
                $updateField => $filename,
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading file: '.$e->getMessage());
            throw $e;
        }
    }
}
