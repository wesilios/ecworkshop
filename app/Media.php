<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class Media extends Model
{
    //
    protected $table = 'media';

    protected $location = 'images/';

    protected $fillable = [

    	'file_name',
    	'url',
    	'caption',
    	'description',
    	'admin_id',
        'folder_id',
    	'title',
    	'alt_text',
        'type',

    ];

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function articles()
    {
        return $this->morphedByMany('App\Article', 'mediaable');
    }

    public function boxes()
    {
        return $this->morphedByMany('App\Box', 'mediaable');
    }

    public function items()
    {
        return $this->morphedByMany('App\Item', 'mediaable');
    }

    public static function ajaxUploadImage($file, $folder_id)
    {
        $admin_id = Auth()->user()->id;
        $file->getClientMimeType();
        $path = '';
        if(substr($file->getMimeType(), 0, 5) == 'image') {
            $name = time() . '_media_' . $file->getClientOriginalName();
            $type = $file->getMimeType();
            if ($folder_id == 1) {
                $path = public_path('images/' . $name);
                $url = 'images/' . $name;
            } else {
                $folder_temp_id = $folder_id;
                while ($folder_temp_id != 1) {
                    $folder_temp = Folder::findOrFail($folder_temp_id);
                    $folder_temp_id = $folder_temp->folder->id;
                    $path_arr[] = $folder_temp->slug;
                }
                $path .= 'images/';
                for ($i = count($path_arr) - 1; $i >= 0; $i--) {
                    if ($i == 0) {
                        $path .= $path_arr[$i];
                    } else {
                        $path .= $path_arr[$i] . '/';
                    }
                }
                $url = $path . '/' . $name;
                $path = public_path($url);
            }
            Image::make($file)->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);
            $admin_id = Auth::user()->id;
            $media = Media::create([
                'file_name' => $name,
                'url'       => $url,
                'type'      => $type,
                'admin_id'  => $admin_id,
                'folder_id' => $folder_id,
            ]);
        } else {
            $media = [];
        }
        return $media;
    }
}
