<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ManagesPageContent
{
    protected function setPageData($component, $page_id, $page_field)
    {

        $page_field = ($page_field) ? 'home_id' : 'page_id';
        return [
            $page_field         => $page_id,
            'title'             => $component->title,
            'slug'              => $component->slug,
            'meta_description'  => $component->meta_description,
            'page_content'      => $component->page_content,
            //'domain_id'         => $component->domain_id,
            'newFileUpload'     => $component->newFileUpload
        ];
    }

    public function addNewFile()
    {
        $this->newFileUpload[] = ['fileDescription' => null];
    }

    public function removeNewFile($index)
    {
        unset($this->newFileUpload[$index]);
        // re-index array numerically
        $this->newFileUpload = array_values($this->newFileUpload);
    }

    public function updateMetaDescription($value)
    {
        $this->meta_description = $value;
    }

    public function generateSlug()
    {
        // $this->slug = url(Str::slug($this->title) ) ;
        $this->slug = Str::slug($this->title);
    }
}
