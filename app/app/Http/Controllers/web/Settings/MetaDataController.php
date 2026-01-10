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

    public function update(Request $req)
    {
        if (!$this->general->isCrudAllow($this->CRUD, "edit")) {
            return ['status' => false, 'message' => 'Access denied'];
        }

        $validator = Validator::make($req->all(), [
            'page_id' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        DB::beginTransaction();

        try {
            // CHECK BY PageId (THIS IS THE KEY FIX)
            $existing = DB::table('tbl_metadata')
                ->where('PageId', $req->page_id)
                ->first();

            // If exists, reuse Id. Else create new one
            $Id = $existing
                ? $existing->Id
                : DocNum::getDocNum(docTypes::MetaData->value);

            $oldData = $existing ? [$existing] : [];

            $data = [
                'Id' => $Id,
                'PageId' => $req->page_id,
                'MetaKeyword' => $req->meta_keyword,
                'MetaTitle' => $req->meta_title,
                'MetaDescription' => $req->meta_description,
                'IsHomeContent' => $req->is_home_content ?? 0,
                'UpdatedBy' => $this->UserID,
                'UpdatedOn' => now()
            ];

            DB::table('tbl_metadata')->updateOrInsert(
                ['PageId' => $req->page_id],
                $data
            );

            if (!$existing) {
                DocNum::updateDocNum(docTypes::MetaData->value);
            }

            $newData = DB::table('tbl_metadata')
                ->where('PageId', $req->page_id)
                ->get();

            DB::commit();

            $updated_content = $req->updated_content;

            return [
                'status' => true,
                'message' => $existing
                    ? 'Meta Data for '.$updated_content.' Updated Successfully'
                    : 'Meta Data for '.$updated_content.' Created Successfully'
            ];

        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage());

            return [
                'status' => false,
                'message' => 'Operation failed'
            ];
        }
    }

    public function TableView(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view")) {
            $contentType = $req->input('ActiveStatus', 'home-content');
            
            // Define columns and table based on content type
            if ($contentType === 'category') {
                $columns = [
                    ['db' => 'C.PCID', 'dt' => '0'],
                    ['db' => 'C.PCName', 'dt' => '1'],
                    ['db' => 'M.MetaKeyword', 'dt' => '2'],
                    ['db' => 'M.MetaTitle', 'dt' => '3'],
                    ['db' => 'M.MetaDescription', 'dt' => '4'],
                    ['db' => 'M.Id', 'dt' => '5'],
                ];
                $table = 'tbl_product_category AS C LEFT JOIN tbl_metadata AS M ON C.PCID = M.PageId';
                $primaryKey = 'C.PCID';
                $where = " C.DFlag=0 ";
                $idField = 'PCID';
            } elseif ($contentType === 'sub-category') {
                $columns = [
                    ['db' => 'SC.PSCID', 'dt' => '0'],
                    ['db' => 'SC.PSCName', 'dt' => '1'],
                    ['db' => 'M.MetaKeyword', 'dt' => '2'],
                    ['db' => 'M.MetaTitle', 'dt' => '3'],
                    ['db' => 'M.MetaDescription', 'dt' => '4'],
                    ['db' => 'M.Id', 'dt' => '5'],
                ];
                $table = 'tbl_product_subcategory AS SC LEFT JOIN tbl_metadata AS M ON SC.PSCID = M.PageId';
                $primaryKey = 'SC.PSCID';
                $where = " SC.DFlag=0 ";
                $idField = 'PSCID';
            } elseif ($contentType === 'products') {
                $columns = [
                    ['db' => 'P.ProductID', 'dt' => '0'],
                    ['db' => 'P.Slug', 'dt' => '1'],
                    ['db' => 'M.MetaKeyword', 'dt' => '2'],
                    ['db' => 'M.MetaTitle', 'dt' => '3'],
                    ['db' => 'M.MetaDescription', 'dt' => '4'],
                    ['db' => 'M.Id', 'dt' => '5'],
                ];
                $table = 'tbl_products AS P LEFT JOIN tbl_metadata AS M ON P.ProductID = M.PageId';
                $primaryKey = 'P.ProductID';
                $where = " P.DFlag=0 ";
                $idField = 'ProductID';
            } else { // home-content
                // Handle home content specially
                return $this->getHomeContentData($req);
            }

            $columns1 = [
                ['db' => $idField, 'dt' => '0'],
                ['db' => $idField === 'PCID' ? 'PCName' : ($idField === 'PSCID' ? 'PSCName' : 'Slug'), 'dt' => '1'],
                [
                    'db' => 'MetaKeyword',
                    'dt' => '2',
                    'formatter' => function ($d, $row) {
                        $html = '<input class="form-control meta-keyword" type="text" value="' . $d . '" style="border: 1px solid #ced4da;">';
                        return $html;
                    }
                ],
                [
                    'db' => 'MetaTitle',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '<input class="form-control meta-title" type="text" value="' . $d . '" style="border: 1px solid #ced4da;">';
                        return $html;
                    }
                ],
                [
                    'db' => 'MetaDescription',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '<textarea class="form-control meta-description" rows="1">' . $d . '</textarea>';
                        return $html;
                    }
                ],
                [
                    'db' => 'Id',
                    'dt' => '5',
                    'formatter' => function ($d, $row) use ($idField) {
                        $html = '<div class="d-flex justify-content-center">';
                        if ($this->general->isCrudAllow($this->CRUD, "edit")) {
                            $pageId = $row[$idField];
                            $html .= '<button type="button" data-id="' . $d . '" data-page-id="' . $pageId . '" class="btn btn-edit btn-outline-success ' . $this->general->UserInfo['Theme']['button-size'] . ' m-5 mr-10 btnEdit" title="Save" data-original-title="Save"><i class="fa fa-save" aria-hidden="true"></i></button>';
                        }
                        $html .= "</div>";
                        return $html;
                    }
                ]
            ];

            $data = [];
            $data['POSTDATA'] = $req;
            $data['TABLE'] = $table;
            $data['PRIMARYKEY'] = $primaryKey;
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = $where;
            return SSP::SSP($data);
        } else {
            return response(['status' => false, 'message' => "Access Denied"], 403);
        }
    }

    private function getHomeContentData(Request $req)
    {
        $homePages = [
            ['PageId' => 'home', 'Title' => 'Home'],
            ['PageId' => 'about-us', 'Title' => 'About Us'],
            ['PageId' => 'terms-conditions', 'Title' => 'Terms-Conditions'],
            ['PageId' => 'privacy-policy', 'Title' => 'Privacy Policy'],
            ['PageId' => 'contact-us', 'Title' => 'Contact Us'],
            ['PageId' => 'return-policy', 'Title' => 'Return Policy'],
            ['PageId' => 'products', 'Title' => 'Products'],
            ['PageId' => 'category-list', 'Title' => 'Categories'],
        ];

        $data = [];
        foreach ($homePages as $page) {
            $metadata = DB::table('tbl_metadata')->where('PageId', $page['PageId'])->first();
            
            // Format input field for MetaKeyword
            $keywordInput = '<input class="form-control meta-keyword" type="text" value="' . ($metadata->MetaKeyword ?? '') . '" style="border: 1px solid #ced4da;">';
            
            // Format input field for MetaTitle
            $titleInput = '<input class="form-control meta-title" type="text" value="' . ($metadata->MetaTitle ?? '') . '" style="border: 1px solid #ced4da;">';
            
            // Format textarea for MetaDescription
            $descriptionInput = '<textarea class="form-control meta-description" rows="1">' . ($metadata->MetaDescription ?? '') . '</textarea>';
            
            // Format action button
            $actionButton = '<div class="d-flex justify-content-center">';
            if ($this->general->isCrudAllow($this->CRUD, "edit")) {
                $actionButton .= '<button type="button" data-id="' . ($metadata->Id ?? '') . '" data-page-id="' . $page['PageId'] . '" class="btn btn-edit btn-outline-success ' . $this->general->UserInfo['Theme']['button-size'] . ' m-5 mr-10 btnEdit" title="Save" data-original-title="Save"><i class="fa fa-save" aria-hidden="true"></i></button>';
            }
            $actionButton .= '</div>';
            
            // Data array must be indexed by column position (dt value)
            $data[] = [
                $page['PageId'],        // dt: 0 - PageId
                $page['Title'],         // dt: 1 - Title
                $keywordInput,          // dt: 2 - MetaKeyword (formatted as input)
                $titleInput,            // dt: 3 - MetaTitle (formatted as input)
                $descriptionInput,      // dt: 4 - MetaDescription (formatted as textarea)
                $actionButton,          // dt: 5 - Action buttons
            ];
        }

        return response()->json([
            'draw' => intval($req->input('draw', 0)),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'data' => $data
        ]);
    }
}
