<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Traits\Utils\Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{

    use Responser;

    private $request;
    private $storage;

    public function __construct(Request $request, Storage $storage)
    {
        $this->request = $request;
        $this->storage = $storage;
    }

    public function uploadFile()
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($this->request->all(), [
                'name' => 'required|string',
                'file' => 'required|mimes:png,jpg,jpeg|max:4194304',
            ], [
                'name.required' => 'نام الزامی میباشد',
                'name.string' => 'نام باید رشته باشد',
                'file.required' => 'فایل الزامی میباشد',
                'file.mimes' => 'نوع فایل معتبر نمی‌باشد',
                'file.max' => 'حجم فایل بالا میباشد',
            ]);

            if ($validation->fails()) throw new \Exception(serialize($validation->getMessageBag()), 400);

            $fileName = time() . '-' . $this->request->file->getClientOriginalName();
            $fileMimeExtension = explode('/', $this->request->file->getMimeType());
            $filePath = date('Y/m/d') . '/' . $fileMimeExtension[1];
            $physicalFilePath = $this->request->file('file')->storeAs('public', $filePath . $fileName);

            $file = File::create([
                'name' => $fileName,
                'size' => $this->request->file->getSize(),
                'mime' => $fileMimeExtension[0],
                'extension' => $fileMimeExtension[1],
                'file_path' => $physicalFilePath
            ]);

            DB::commit();

            return $this->successful($file, 'File Created', 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 400) return  $this->clientError($exception->getMessage());
            return $this->serverError($exception->getMessage());
        }
    }

    public function getOneFile(File $file)
    {
        try {
            return $this->successful($file);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function getAllFiles()
    {
        try {
            if ($this->request->has('full'))
                return $this->successful(File::withTrashed()->get());
            return $this->successful(File::get());
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }


    public function deleteFile(File $file)
    {
        try {
            $file->delete();
            return $this->successful($file, 'File Deleted', 204);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }
}
