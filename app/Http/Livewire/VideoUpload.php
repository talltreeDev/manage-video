<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class VideoUpload extends Component
{
    use WithFileUploads;

    public $video;
    public $videoPath;
    public $convertedPath;
    public $convertTo = 'mp4';

    public function getMaxFileSize()
    {
        return Auth::user()->role === 'premium' ? 200 * 1024 : 50 * 1024; // in KB
    }

    public function getAllowedFormats()
    {
        return Auth::user()->role === 'premium'
            ? ['mp4', 'avi', 'webm', 'mov']
            : ['mp4'];
    }

    public function updatedVideo()
    {
        $this->upload();
    }

    public function upload()
    {
        $this->validate([
            'video' => 'required|file|mimes:mp4|max:' . $this->getMaxFileSize(),
        ]);

        $filename = time() . '.' . $this->video->getClientOriginalExtension();
        $this->videoPath = $this->video->storeAs('videos', $filename, 'public');

        session()->flash('message', 'Video uploaded successfully.');
    }

    public function convert()
    {
        if (!$this->videoPath || !in_array($this->convertTo, $this->getAllowedFormats())) {
            session()->flash('error', 'Not allowed to convert to this format.');
            return;
        }

        $input = storage_path("app/public/{$this->videoPath}");
        $output = storage_path("app/public/videos/converted_" . time() . ".{$this->convertTo}");

        $command = "ffmpeg -i \"$input\" \"$output\"";
        exec($command, $log, $status);

        if ($status === 0) {
            $this->convertedPath = str_replace(storage_path('app/public/'), '', $output);
            session()->flash('message', 'Conversion successful.');
        } else {
            session()->flash('error', 'Conversion failed.');
        }
    }

    public function render()
    {
        if (!Auth::check()) {
            abort(403, 'You must be logged in to use this feature.');
        }

        return view('livewire.video-upload', [
            'allowedFormats' => $this->getAllowedFormats(),
        ]);
    }
}
