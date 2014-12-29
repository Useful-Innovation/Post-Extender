# Magic Fields 2 Post Extender

Extends posts, pages and any custom post type with all it's meta data in one extra db-query. 

## Versions

Current stable version is v1.1

## Setup

Add the following to your composer.json file and run `composer update`

    "require": {
      "gobrave/magic-fields-2-post-extender" : "~1.1"
    },
    "repositories" : [
      {
        "type" : "composer",
        "url"  : "http://satis.goingbrave.se"
      }
    ]

The basic setup needs some paths

    GoBrave\PostExtender\PostExtender::setConfig(new GoBrave\PostExtender\Config([
      'files_url'  => MF_FILES_URL,              // URL to Magic Fields images
      'files_dir'  => MF_FILES_DIR,              // Path to Magic Fields images
      'struct_dir' => __DIR__ . '/post_types',   // Path to post-type json-files,
      'namespace'  => 'App\\PostTypes'           // The namespace for post type classes
    ]));

## Public interface

All models will inherit from the `GoBrave\PostExtender\PostExtender` class. It will provide them with a struct for all the settings and a magic-method to access all the `WP_Post` data.

    $post = Post::extend($post);
    $post->post_title;
    $post->post_content;
    
    // For Magic Fields meta data
    $post->info_title;
    $post->info_content;
    
    $post->url() / $post->permalink();
    $post->getStruct();
    
    // Finders
    Post::find(1);                       // The post with ID == 5
    Post::all($options = []);            // All posts
    Post::single();                      // Takes the first object from an all-call
    Post::findAllByIds([1, 2, 3]);       // Posts with ID 1, 2, 3
    
## DataTypes

In order to simplify the access to more complex data some datatypes have been added, depending on the Magic Fields field type.

### Image

    $post->info_image->url(image_size = 'thumbnail');

### Related type

    $post->info_rel->get();     // Returns the related object of the correct type

### File

Magic Fields prepends a timestamp, time of upload to all files. It is cleaned for human output in the File class. 

    // Filename 1122334455SomeFile.pdf

    $post->info_file->url();        // URL to file
    $post->info_file->basename();   // 'SomeFile.pdf'
    $post->info_file->filename();   // 'SomeFile'
    $post->info_file->extension();  // 'pdf'
    $post->info_file->raw();        // '1122334455SomeFile.pdf'
    
