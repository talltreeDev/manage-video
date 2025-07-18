<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use FFMpeg;

class VideoUpload extends Component
{
    use WithFileUploads;

    public $video;
    public $convertedPath;
    public $convertTo = 'mp4';
    public $videoPath;

    protected $rules = [
        'video' => 'required|file|mimes:mp4|max:102400', // max 100MB
    ];

    public function upload()
    {
        $this->validate();

        $filename = time() . '.' . $this->video->getClientOriginalExtension();
        $this->videoPath = $this->video->storeAs('videos', $filename, 'public');

        session()->flash('message', 'Video uploaded successfully.');
    }

    public function convert()
    {
        if (!$this->videoPath || !in_array($this->convertTo, ['mp4', 'avi', 'webm', 'mov'])) {
            session()->flash('error', 'Invalid conversion format or no video found.');
            return;
        }

        $input = storage_path("app/public/{$this->videoPath}");
        $output = storage_path("app/public/videos/converted_" . time() . '.' . $this->convertTo);

        $command = "ffmpeg -i \"$input\" \"$output\"";
        exec($command, $outputLog, $status);

        if ($status === 0) {
            $this->convertedPath = str_replace(storage_path('app/public/'), '', $output);
            session()->flash('message', 'Conversion successful.');
        } else {
            session()->flash('error', 'Conversion failed.');
        }
    }

    public function render()
    {
        return view('livewire.video-upload');
    }
}
