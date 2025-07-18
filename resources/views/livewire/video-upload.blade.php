<div class="p-4">
    @if (session()->has('message'))
        <div class="bg-green-200 p-2 rounded mb-2">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-200 p-2 rounded mb-2">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="upload" class="space-y-4">
        <input type="file" wire:model="video" accept="video/mp4">
        @error('video') <span class="text-red-500">{{ $message }}</span> @enderror

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>

    @if ($videoPath)
        <div class="mt-6">
            <h3 class="text-lg font-bold mb-2">Video Preview</h3>
            <video width="320" height="240" controls class="mb-4">
                <source src="{{ asset('storage/' . $videoPath) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <div class="flex items-center space-x-2">
                <select wire:model="convertTo" class="border rounded px-2 py-1">
                    @foreach ($allowedFormats as $format)
                        <option value="{{ $format }}">{{ strtoupper($format) }}</option>
                    @endforeach
                </select>
                <button wire:click="convert" class="bg-green-500 text-white px-4 py-2 rounded">Convert</button>
            </div>
        </div>
    @endif

    @if ($convertedPath)
        <div class="mt-6">
            <h3 class="text-lg font-bold mb-2">Converted Video</h3>
            <video width="320" height="240" controls>
                <source src="{{ asset('storage/' . $convertedPath) }}" type="video/{{ $convertTo }}">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif
</div>
