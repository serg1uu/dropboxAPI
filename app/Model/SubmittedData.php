<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubmittedData extends Model
{
    const DROPBOX_CV_FOLDER = 'webservice';

    /**
     * @var string
     */
    protected $table = 'requests';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'file'];
}
