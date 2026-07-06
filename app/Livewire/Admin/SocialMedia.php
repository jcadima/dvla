<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Social;

class SocialMedia extends Component
{
    public $facode;
    public $link;
    public $socialMediaLinks = [];

    public function mount()
    {
        $this->socialMediaLinks = Social::all()->toArray();
    }

    public function updateSocialMediaItem($id)
    {
        // Search for the index value in the array and return its key
        $index = array_search($id, array_column($this->socialMediaLinks, 'id'));

        if ($index !== false) {
            $social_item = Social::findOrFail($id);

            // Update the database record with data from the Livewire property
            $social_item->update([
                'link'   => $this->socialMediaLinks[$index]['link'],
                'facode' => $this->socialMediaLinks[$index]['facode'],
            ]);

            $this->dispatch('notification', [
                'type' => 'success',
                'message' => "Social Media Link Updated",
            ]);
        }
    }

    public function store_media()
    {
        if ($this->link && $this->facode) {
            $newLink = Social::create([
                'link' => $this->link,
                'facode' => $this->facode
            ]);

            // Append the newly created link to the socialMediaLinks array
            $this->socialMediaLinks[] = $newLink->toArray();

            $this->dispatch('notification', [
                'type' => 'success',
                'message' => "Social Media Link Created Successfully",
            ]);
        } else {
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Link and fontawesome code are required',
            ]);
        }

        $this->link = '';
        $this->facode = '';
    }

    public function removeSocialMediaItem($index)
    {
        $socialMediaLink = Social::find($index);

        if ($socialMediaLink) {
            $socialMediaLink->delete();
        }

        $this->socialMediaLinks = array_filter($this->socialMediaLinks, function ($link) use ($index) {
            return $link['id'] != $index;
        });

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Social Media Link Deleted",
        ]);
    }

    public function render()
    {
        return view('livewire.admin.social-media.index')->layout('layouts.admin');
    }
} 