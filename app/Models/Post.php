<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;

    public $slug;

    public function __construct($title,$excerpt,$date , $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    
    public static function find($slug){

        return static::all()->firstWhere('slug', $slug);
    }

    public static function all(){

        // cache'll be remembered forever, til some operation brake it... we need to set a cache()->forget('posts.all') when new post is posted
        return cache()->rememberForever('posts.all', function(){
            return collect(File::files(resource_path("posts")))
            ->map(fn($file)=> YamlFrontMatter::parseFile($file))
            ->map(fn($document)=>new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $document->slug
            ))
            ->sortByDesc("date");
        });
    }
}

?>