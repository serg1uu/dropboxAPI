<?php

namespace App\Http\Controllers\Frontend;

use Config;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\SubmittedData;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxFile;
use Kunnu\Dropbox\Exceptions\DropboxClientException;


class RequestController extends Controller
{
    private $dropbox;
	private $dropboxApp;
	private $dropboxFile;

	public function __construct() {
		$this->dropboxApp = new DropboxApp(Config::get('app.dropbox_client_id'), Config::get('app.dropbox_client_secret'), Config::get('app.dropbox_auth_token'));
	    $this->dropbox = new Dropbox($this->dropboxApp);
	}

    /**
     * Form request processing
     * @param $request
     * @return string
     */
    public function submitRequest(Request $request)
    {
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'customFile' => 'required|mimes:doc,pdf,docx,txt|max:10240'
        );

        $messages = array(
            'customFile.required' => 'The file input is required'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        if($validator->fails()) {
            $arrErrors = array();
            $arrFailedFields = array_keys($validator->failed());
            foreach ($arrFailedFields as $key => $value) {
                foreach ($validator->messages()->get($value) as $arrError) {
                    $arrErrors[] = $arrError;
                }
            }

            return redirect('/')->withErrors($arrErrors);
        }

        $tempFile = Input::File('customFile');
        $newFileName =  rand(1, 99999) . '_' . time() . '.' . $tempFile->getClientOriginalExtension();

        $dropboxFile = $this->getDropboxFileObj($tempFile);
        $file = $this->dropbox->upload($dropboxFile, '/' . SubmittedData::DROPBOX_CV_FOLDER . '/' . $newFileName);
        $data = $this->saveData($file);

        return redirect('/')->with('message', 'Your request has been submitted!');
    }

    /**
     * Insert new record by creating a new model instance
     * @param $file
     * @return int
     */
    private function saveData($file) {
        $dataModel = new SubmittedData();

        $dataModel->name = Input::get('name');
        $dataModel->email = Input::get('email');
        $dataModel->file = $file->getName();
        $dataModel->save();
    }

    /**
     * @param $pathName
     * @return object
     */
    private function getDropboxFileObj($pathName) {
		return new DropboxFile($pathName->getPathName());
	}

}
