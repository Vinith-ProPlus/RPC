<?php

namespace App\Http\Controllers\web\Settings;

use App\enums\activeMenuNames;
use App\Http\Controllers\Controller;
use App\Http\Controllers\web\masters\general\Exception;
use App\enums\cruds;
use Illuminate\Support\Facades\DB;
use App\Models\DocNum;
use App\enums\docTypes;
use App\Models\general;
use App\helper\helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use logs;
use SSP;
use App\Rules\ValidUnique;

class MetaDataController extends Controller
{
    private $general;
    private $UserID;
    private $ActiveMenuName;
    private $PageTitle;
    private $CRUD;
    private $Settings;
    private $Menus;
    private $generalDB;

    public function __construct()
    {
        $this->ActiveMenuName = activeMenuNames::MetaData->value;
        $this->PageTitle = "Meta Data";
        $this->middleware('auth');
        $this->generalDB = Helper::getGeneralDB();
        $this->middleware(function ($request, $next) {
            $this->UserID = auth()->user()->UserID;
            $this->general = new general($this->UserID, $this->ActiveMenuName);
            $this->Menus = $this->general->loadMenu();
            $this->CRUD = $this->general->getCrudOperations($this->ActiveMenuName);
            $this->Settings = $this->general->getSettings();
            return $next($request);
        });
    }

    public function view(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view")) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            return view('app.settings.meta-data.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add")) {
            return Redirect::to('/admin/settings/meta-data/create');
        } else {
            return view('errors.403');
        }
    }

    public function TrashView(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "restore")) {
            $FormData = $this->general->UserInfo;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            return view('app.settings.chat-suggestions.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view")) {
            return Redirect::to('/admin/settings/chat-suggestions/');
        } else {
            return view('errors.403');
        }
    }

    public function create(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "add")) {
            $FormData = $this->general->UserInfo;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = false;
            return view('app.settings.chat-suggestions.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view")) {
            return Redirect::to('/admin/settings/chat-suggestions/');
        } else {
            return view('errors.403');
        }
    }

    public function edit(Request $req, $CSID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit")) {
            $FormData = $this->general->UserInfo;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['CSID'] = $CSID;
            $FormData['EditData'] = DB::Table('tbl_chat_suggestions')->where('DFlag', 0)->Where('CSID', $CSID)->get();
            if (count($FormData['EditData']) > 0) {
                return view('app.settings.chat-suggestions.create', $FormData);
            } else {
                return view('errors.403');
            }
        } elseif ($this->general->isCrudAllow($this->CRUD, "view")) {
            return Redirect::to('/admin/settings/chat-suggestions/');
        } else {
            return view('errors.403');
        }
    }

    public function save(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "add")) {
            $OldData = [];
            $NewData = [];
            $CSID = "";
            $rules = [
                'Question' => ['required', 'min:3', 'max:100', new ValidUnique(["TABLE" => 'tbl_chat_suggestions', "WHERE" => " Question='" . $req->Question . "' "], "This Question is already taken.")],
                'Answer' => ['required', 'min:3'],
            ];
            $message = [];
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return ['status' => false, 'message' => "Chat suggestion Create Failed", 'errors' => $validator->errors()];
            }
            DB::beginTransaction();
            $status = false;
            try {
                $CSID = DocNum::getDocNum(docTypes::ChatSuggestions->value);
                $data = [
                    "CSID" => $CSID,
                    "Question" => $req->Question,
                    "Answer" => $req->Answer,
                    "ActiveStatus" => $req->ActiveStatus,
                    "CreatedBy" => $this->UserID,
                    "CreatedOn" => date("Y-m-d H:i:s")
                ];
                $status = DB::Table('tbl_chat_suggestions')->insert($data);
            } catch (Exception $e) {
                logger("Error in ChatSuggestionsController@save: " . $e->getMessage());
                $status = false;
            }

            if ($status == true) {
                DocNum::updateDocNum(docTypes::ChatSuggestions->value);
                $NewData = DB::table('tbl_chat_suggestions')->where('CSID', $CSID)->get();
                $logData = ["Description" => "New Chat Suggestion Created", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD->value, "ReferID" => $CSID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip()];
                logs::Store($logData);
                DB::commit();
                return ['status' => true, 'message' => "Chat Suggestion Created Successfully"];
            } else {
                DB::rollback();
                return ['status' => false, 'message' => "Chat Suggestion Create Failed"];
            }
        } else {
            return ['status' => false, 'message' => 'Access denied'];
        }
    }


    public function update(Request $req, $Id = null)
    {
        if (!$this->general->isCrudAllow($this->CRUD, "edit")) {
            return ['status' => false, 'message' => 'Access denied'];
        }

        $rules = [
            'page_id' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => "Meta data Update Failed",
                'errors' => $validator->errors()
            ];
        }

        DB::beginTransaction();

        try {
            // Check if record exists
            $exists = DB::table('tbl_metadata')->where('Id', $Id)->exists();

            // Generate new ID only if inserting
            if (!$exists) {
                $Id = DocNum::getDocNum(docTypes::MetaData->value);
            }

            $oldData = $exists
                ? DB::table('tbl_metadata')->where('Id', $Id)->get()
                : [];

            $data = [
                "Id" => $Id,
                "PageId" => $req->page_id,
                "MetaTitle" => $req->meta_title,
                "MetaDescription" => $req->meta_description,
                "IsHomeContent" => 1,
                "UpdatedBy" => $this->UserID,
                "UpdatedOn" => now()
            ];

            DB::table('tbl_metadata')->updateOrInsert(
                ['Id' => $Id],
                $data
            );

            if (!$exists) {
                DocNum::updateDocNum(docTypes::MetaData->value);
            }

            $newData = DB::table('tbl_metadata')->where('Id', $Id)->get();

            logs::Store([
                "Description" => $exists ? "Meta Data Updated" : "Meta Data Created",
                "ModuleName" => $this->ActiveMenuName,
                "Action" => $exists ? cruds::UPDATE->value : cruds::CREATE->value,
                "ReferID" => $Id,
                "OldData" => $oldData,
                "NewData" => $newData,
                "UserID" => $this->UserID,
                "IP" => $req->ip()
            ]);

            DB::commit();

            return [
                'status' => true,
                'message' => $exists
                    ? "Meta Data Updated Successfully"
                    : "Meta Data Created Successfully"
            ];

        } catch (\Exception $e) {
            DB::rollback();
            logger("Error in MetaDataController@update: " . $e->getMessage());

            return [
                'status' => false,
                'message' => "Meta Data Operation Failed"
            ];
        }
    }

    public function TableView(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view")) {
            $columns = [
                ['db' => 'C.PCID', 'dt' => '0'],
                ['db' => 'C.PCName', 'dt' => '1'],
                ['db' => 'M.MetaTitle', 'dt' => '2'],
                ['db' => 'M.MetaDescription', 'dt' => '3'],
                ['db' => 'M.Id', 'dt' => '4'],
                ['db' => 'M.IsHomeContent', 'dt' => '5'],
            ];
            $columns1 = [
                ['db' => 'PCID', 'dt' => '0'],
                ['db' => 'PCName', 'dt' => '1'],
                [
                    'db' => 'MetaTitle',
                    'dt' => '2',
                    'formatter' => function ($d, $row) {
                        $html = '<input class="form-control meta-title" type="text" value="' . $d . '">';
                        return $html;
                    }
                ],
                [
                    'db' => 'MetaDescription',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '<textarea class="form-control meta-description">' . $d . '</textarea>';
                        return $html;
                    }
                ],
                [
                    'db' => 'Id',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "edit")) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn btn-edit btn-outline-success ' . $this->general->UserInfo['Theme']['button-size'] . ' m-5 mr-10 btnEdit" data-original-title="Edit">Save</button>';
                        }
                        return $html;
                    }
                ]
            ];
            $Where = " DFlag=0 ";
            $data = [];
            $data['POSTDATA'] = $req;
            $data['TABLE'] = 'tbl_product_category AS C LEFT JOIN tbl_metadata AS M ON C.PCID = M.PageId';
            $data['PRIMARYKEY'] = 'C.PCID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = $Where;
            return SSP::SSP($data);
        } else {
            return response(['status' => false, 'message' => "Access Denied"], 403);
        }
    }

}
