<?php

namespace App\Http\Controllers\Webpanel;

use App\Models\User;
use App\Models\Salearea;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use App\Exports\CustomerCompletedExport;
use App\Exports\CustomerWaitingExport;
use App\Exports\CustomerActionExport;
use App\Exports\CustomerAllExport;
use App\Exports\CustomerInactiveExport;
use App\Exports\UpdateLatestExport;
use App\Exports\CustomerAreaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WebpanelCustomerController
{
    public function index(Request $request): View
    {

        @$page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
                }

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomer($page);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        //Dashborad;
        $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        ////////////////////////////////////////////////////////

        $keyword_search = $request->keyword;
        // dd($keyword);

        if($keyword_search != '') {

            $count_page = Customer::where('customer_id', 'Like', "%{$keyword_search}%")->count();
            // dd($count_page);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $customer = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->get();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if(!$check_keyword  == null) {
                return view('webpanel/customer', compact('check_keyword', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));
        
            }

                // return back();

        }

        return view('webpanel/customer', compact('admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));
        
    }

    public function indexAdminArea(Request $request, $admin_id)
    {

        // dd($request->status);
        // dd($status);
        $admin_area = User::where('admin_area', $admin_id)->first();

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

          //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomerAdminArea($page, $admin_id);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        // name;
        $admin_name = User::select('admin_area', 'name')->where('admin_area', $admin_id)->first();

        //Dashborad;
        $total_customer_adminarea = Customer::whereNotIn('customer_code', ['0000','4494'])->where('admin_area', $admin_id)->count();
        $total_status_waiting = Customer::where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();

            //dropdown admin_area;
            $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
            ////////////////////////////////////////////////////////
    
            $keyword_search = $request->keyword;
            // dd($keyword);

            // dd($request->status);
        switch ($request->status)
        {
            case 'status-waiting':

            $row_customer = Customer::viewCustomerAdminAreaWaiting($page, $admin_id);
            $customer = $row_customer[0];
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            if($keyword_search != '') {
        
                    $count_page = Customer::where('status','รอดำเนินการ')
                                            ->where('admin_area', $admin_id)
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                    // dd(($count_page));
        
                    $perpage = 10;
                    $total_page = ceil($count_page / $perpage);
                    $start = ($perpage * $page) - $perpage;

                    $customer = Customer::where('status','รอดำเนินการ')
                                            ->where('admin_area', $admin_id)
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();
        
                    $check_keyword = Customer::where('status','รอดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->get();
        
                    // dd($check_customer_code);
        
                    // dd($check_search->admin_area);
                    if(!$check_keyword  == null) {
                        return view('webpanel/adminarea-waiting',compact('check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                
                    }
        
                        return back();
        
            }
            $count_page = 1;
            return view('webpanel/adminarea-waiting' ,compact('admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
            break;

            case 'status-action':

                $row_customer = Customer::viewCustomerAdminAreaAction($page, $admin_id);
                $customer = $row_customer[0];
                $start = $row_customer[1];
                $total_page = $row_customer[2];
                $page = $row_customer[3];
                $count_page_master = $row_customer[4];

                // dd($count_page_master);
                if($keyword_search != '') {
            
                        $count_page = Customer::where('status','ต้องดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                        // dd(gettype($count_page));
            
                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;
    
                        $customer = Customer::where('status','ต้องดำเนินการ')
                                                ->where('admin_area', $admin_id)
                                                ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->offset($start)
                                                ->limit($perpage)
                                                ->get();
            
                        $check_keyword = Customer::where('status','ต้องดำเนินการ')
                                                    ->where('admin_area', $admin_id)
                                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->get();
            
                        // dd($check_customer_code);
            
                        // dd($check_search->admin_area);
                        if(!$check_keyword  == null) {
                            return view('webpanel/adminarea-action',compact('check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                    
                        }
            
                            return back();
            
                }
                $count_page = 1;
                return view('webpanel/adminarea-action' ,compact('count_page_master','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                break;

                case 'status-completed':

                    $row_customer = Customer::viewCustomerAdminAreaCompleted($page, $admin_id);
                    $customer = $row_customer[0];
                    $start = $row_customer[1];
                    $total_page = $row_customer[2];
                    $page = $row_customer[3];
    
                    if($keyword_search != '') {
                
                            $count_page = Customer::where('status','ดำเนินการแล้ว')
                                                    ->where('admin_area', $admin_id)
                                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                            // dd(gettype($count_page));
                
                            $perpage = 10;
                            $total_page = ceil($count_page / $perpage);
                            $start = ($perpage * $page) - $perpage;
        
                            $customer = Customer::where('status','ดำเนินการแล้ว')
                                                    ->where('admin_area', $admin_id)
                                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                
                            $check_keyword = Customer::where('status','ดำเนินการแล้ว')
                                                        ->where('admin_area', $admin_id)
                                                        ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                        // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                        ->get();
                
                            // dd($check_customer_code);
                
                            // dd($check_search->admin_area);
                            if(!$check_keyword  == null) {
                                return view('webpanel/adminarea-completed',compact('check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                        
                            }
                
                                return back();
                
                    }
                    $count_page = 1;
                    return view('webpanel/adminarea-completed' ,compact('admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                    break;
                    

            //customer/adminarea;
            default:

                if($keyword_search != '') {
            
                        $count_page = Customer::where('admin_area', $admin_id)->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                        // dd(gettype($count_page));
            
                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;
    
                        $customer = Customer::where('admin_area', $admin_id)
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();
            
                        $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->get();
            
                        // dd($check_customer_code);
            
                        // dd($check_search->admin_area);
                        if(!$check_keyword  == null) {
                            return view('webpanel/adminarea-detail',compact('check_keyword','count_page', 'admin_name', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
                    
                        }
            
                            return back();
            
                }
                $count_page = 1;
                return view('webpanel/adminarea-detail',compact('admin_name','count_page', 'customer', 'start', 'total_page', 'page', 'total_customer_adminarea', 'total_status_waiting', 'total_status_action', 'total_status_completed' ,'status_waiting', 'status_updated', 'status_alert'));
        }
        
    }

    public function indexStatusAdminArea(Request $request)
    {

    }

    public function indexStatus(Request $request, $status_check): View
    {

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //menu alert;
        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //แสดงข้อมูลลูกค้า;

        if($status_check == 'waiting') {

            $row_customer = Customer::customerWaiting($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-waiting', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'action') {

            $row_customer = Customer::customerAction($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-action', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_action', 'status_waiting', 'status_updated', 'status_alert'));
       
        } else if ($status_check == 'completed') {

            $row_customer = Customer::customerCompleted($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-completed', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_completed', 'status_waiting', 'status_updated', 'status_alert'));
        } else if ($status_check == 'latest_update') {

            $row_customer = Customer::latestUpdate($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/update-latest', compact('customer', 'start', 'total_page', 'page', 'total_customer','total_status_updated', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'inactive') {

            $row_customer = Customer::customerInactive($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-inactive', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_inactive', 'status_waiting', 'status_updated', 'status_alert'));

        } else if ($status_check == 'following') {

            $row_customer = Customer::customerFollowing($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_following = Customer::where('status_user', 'กำลังติดตาม')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-following', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_following', 'status_waiting', 'status_updated', 'status_alert'));

        } 
        
        else {
            return abort(403, 'Error requesting');
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function customerCreate() {

        $provinces = Province::province();
        $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('webpanel/customer-create', compact('provinces', 'admin_area_list', 'sale_area', 'status_alert', 'status_waiting', 'status_updated'));
    }
    public function create(Request $request)
    {
        // dd($request->customer_code);
        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_form') == true)
        {

            $request->validate([
                'customer_code' => 'required|max: 4',
        
            ]);

            $customer_id = $request->customer_code;
            $customer_code = $request->customer_code;
            $customer_name = $request->customer_name;
            $price_level = $request->price_level;
            $email = $request->email;
            if($email == null) {
                $email = '';
            }
            $phone = $request->phone;
            if($phone == null) {
                $phone = '';
            }

            $telephone = $request->telephone;
            if($telephone == null) {
                $telephone = '';
            }

            $address = $request->address;
            $province = $request->province;
            $amphur = $request->amphur;
            $district = $request->district;
            $zip_code = $request->zip_code;

            $sale_area = $request->sale_area;
            if($sale_area == null) {
                $sale_area = '';
            }

            $admin_area = $request->admin_area;
            if($admin_area == null) {
                $admin_area = '';
            }

            $text_area = $request->text_add;
            if($text_area == null) {
                $text_area = '';
            }

            $cert_number = $request->cert_number;
            if($cert_number == null) {
                $cert_number = '';
            }

            $register_by = $request->register_by;
            if($register_by == null) {
                $register_by = '';
            }
            

            /* $cert_store = $request->file('cert_store')->dimensions(
                Rule::dimensions()
                    ->maxWidth(100)
                    ->maxHeight(100)
            ); */
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');
       
            $cert_expire = $request->cert_expire;
            $status = 'รอดำเนินการ';

        }   

            if($cert_store != '' && $customer_id != '')
            {
                $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $customer_id.'_certstore.jpg');
            } else {
                $image_cert_store = '';
            }

            if($cert_medical != '' && $customer_id != '')
            {
                $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $customer_id.'_certmedical.jpg');
            } else {
                $image_cert_medical = '';
            }

            if($cert_commerce != '' && $customer_id != '')
            {
                $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $customer_id.'_certcommerce.jpg');
            } else {
                $image_cert_commerce = '';
            }

            if($cert_vat != '' && $customer_id != '')
            {
                $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $customer_id.'_certvat.jpg');
            } else {
                $image_cert_vat = '';
            }

            if($cert_id != '' && $customer_id != '')
            {
                $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $customer_id.'_certid.jpg');
            } else {
                $image_cert_id = '';
            }

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }

            $delivery_by = $request->delivery_by;

       /*  $customer = new Customer;
        $customer->customer_code = $request->customer_code;
        $customer->save(); */

       Customer::create([

                    'customer_id' => $customer_id,
                    'customer_code' => $customer_code,
                    'customer_name' => $customer_name,
                    'price_level' => $price_level,
                    'email' => $email,
                    'phone' => $phone,
                    'telephone' => $telephone,
                    'address' => $address,
                    'province' =>  $province_row,
                    'amphur' => $amphur,
                    'district' => $district,
                    'zip_code' => $zip_code,
                    'geography' => '',
                    'admin_area' => $admin_area,
                    'sale_area' => $sale_area,
                    'text_area' => $text_area,
                    'text_admin' => '',
                    'cert_store' => $image_cert_store,
                    'cert_medical' =>  $image_cert_medical,
                    'cert_commerce' => $image_cert_commerce,
                    'cert_vat' => $image_cert_vat,
                    'cert_id' => $image_cert_id,
                    'cert_number' => $cert_number,
                    'cert_expire' => $cert_expire,
                    'status' => $status,
                    'password' => '',
                    'status_code' => '',
                    'status_update' => '',
                    'type' => '',
                    'register_by' => $register_by,
                    'customer_status' => 'inactive',
                    'status_user' => '',
                    'delivery_by' => $delivery_by,
                    // 'maintenance_status' => '',
                    // 'allowed_maintenance' => '',

                ]);

                return redirect('/webpanel/customer');

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        $admin_area_list  = User::select('admin_area', 'name', 'rights_area')->get();

        $admin_area_check = Customer::select('admin_area', 'customer_id')->where('id', $id)->first();
        // dd($admin_area_check->customer_id);

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('webpanel/customer-detail', compact('customer_view', 'province', 'amphur', 'district', 'admin_area_list', 'admin_area_check', 'sale_area', 'status_waiting', 'status_alert', 'status_updated'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        date_default_timezone_set("Asia/Bangkok");
/* 
        if($request->has('submit_update'))
        { */
                $customer_id = $request->customer_code;
                $customer_name = $request->customer_name;
                $price_level = $request->price_level;
                $phone = $request->phone;
                if($phone == null) {
                    $phone = '';
                }
                $telephone = $request->telephone;
                if($telephone == null) {
                    $telephone = '';
                }
                $address = $request->address;
                $province = $request->province;
                $amphur = $request->amphur;
                $district = $request->district;
                $zip_code = $request->zip_code;
                $admin_area = $request->admin_area;
                $email = $request->email;
                if($email == null) {
                    $email = '';
                }
                $text_area = $request->text_add;
                if($text_area == null) {
                    $text_area = '';
                }
                $text_admin = $request->text_admin;
                if($text_admin == null) {
                    $text_admin = '';
                }
                $sale_area = $request->sale_area;
                if($sale_area == null) {
                    $sale_area = '';
                }
                $cert_number = $request->cert_number;
                if($cert_number == null) {
                    $cert_number = '';
                }
                $password = $request->password;
                if($password == null) {
                    $password = '';
                }
                $cert_expire = $request->cert_expire;
                $status = $request->status;

                $status_update = $request->status_update;
                if($status_update == null) {
                    $status_update = '';
                }

                $status_user = $request->status_user;
                if($status_user == null) {
                    $status_user = '';
                }

                $province_master = DB::table('provinces')->select('id', 'name_th', 'geography_id')->where('id', $province)->first();
                $province_row = $province_master->name_th;

                if(!empty($province_row)) {
                    $geography_id = $province_master->geography_id;
                    $geography = DB::table('geographies')->select('name')->where('id', $geography_id)->first();
                    $geography_name = $geography->name;

                } else {
                    $geography_name = $request->geography;
                }

                $type = $request->type;
                if($type == null) {
                    $type = '';
                }

                $delivery_by = $request->delivery_by;

     /*    } */
            Customer::where('id', $id)
                    ->update ([

                        'customer_id' => $customer_id,
                        'customer_code' => $customer_id,
                        'customer_name' => $customer_name,
                        'price_level' => $price_level,
                        'customer_name' => $customer_name,
                        'email' => $email,
                        'phone' => $phone,
                        'telephone' => $telephone,
                        'address' => $address,
                        'province' =>  $province_row,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zip_code' => $zip_code,
                        'geography' => $geography_name,
                        'admin_area' => $admin_area,
                        'sale_area' => $sale_area,
                        'text_area' => $text_area,
                        'text_admin' => $text_admin,
                        'cert_number' => $cert_number,
                        'cert_expire' => $cert_expire,
                        'status' => $status,
                        'password' => $password,
                        'status_update' => $status_update,
                        'type' => $type,
                        'status_user' => $status_user,
                        'delivery_by' => $delivery_by,
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',
                    
                    ]);

                // check user id;
                $check_customer_id = Customer::select('id')->where('id', $id)->first();
                $customer_id =  $check_customer_id->id;

                if ($customer_id == $id)
                {
                    echo 'success';
                //    return redirect('/webpanel/customer/'.$id)->with('success', 'check_success');
                }
                else {
                    echo 'fail';
                }
            
    }

    public function certStore(Request $request, $id)
    {

            if($request->has('submit_store'))
            {

                $check_cert_store = $request->file('cert_store');
                $cert_store = $check_cert_store;
    
                if($cert_store != '' && $id != '') {
                    $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $id.'_certstore.jpg');

                } else if ($cert_store == '') {
                    $cert_store_old = Customer::select('cert_store')->where('customer_id', $id)->first();
                    $image_cert_store = $cert_store_old->cert_store;

                } else {
                    $image_cert_store = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([

                            // 'cert_store' => $image_cert_store,
                            'cert_store' => "storage/".$image_cert_store,

                        ]);

            }
            return back();
    }

    public function certMedical(Request $request, $id)
    {

            if($request->has('submit_medical'))
            {

                $check_cert_medical = $request->file('cert_medical');
                $cert_medical =  $check_cert_medical ;

                if($cert_medical != '' && $id != '') {
                    $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $id.'_certmedical.jpg');

                } else if ($cert_medical == '') {
                    $cert_medical_old = Customer::select('cert_medical')->where('customer_id',$id)->first();
                    $image_cert_medical = $cert_medical_old->cert_medical;

                } else {
                    $image_cert_medical = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([
                            
                            'cert_medical' =>  "storage/".$image_cert_medical,

                        ]);

            }
            return back();
    }

    public function certCommerce(Request $request, $id)
    {

            if($request->has('cert_commerce'))
            {
                $check_cert_commerce = $request->file('cert_commerce');
                $cert_commerce = $check_cert_commerce;

                if($cert_commerce != '' && $id != '')
                {
                    $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $id.'_certcommerce.jpg');

                } elseif($cert_commerce == '') {
                    $cert_commerce_old = Customer::select('cert_commerce')->where('customer_id', $id)->first();
                    $image_cert_commerce = $cert_commerce_old->cert_commerce;

                } else {
                    $image_cert_commerce = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_commerce' =>  "storage/".$image_cert_commerce,

                        ]);

            }
            return back();
    }

    public function certVat(Request $request, $id)
    {

            if($request->has('submit_vat'))
            {
                $check_cert_vat = $request->file('cert_vat');
                $cert_vat = $check_cert_vat;

                if($cert_vat != '' && $id != '') {
                    $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $id.'_certvat.jpg');

                } else if($cert_vat == '') {
                    $cert_vat_old = Customer::select('cert_vat')->where('customer_id', $id)->first();
                    $image_cert_vat = $cert_vat_old->cert_vat;

                } else {
                    $image_cert_vat = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_vat' =>  "storage/".$image_cert_vat,

                        ]);

            }
            return back();
    }

    public function certId(Request $request, $id)
    {

            if($request->has('submit_id'))
            {
                $check_cert_id = $request->file('cert_id');
                $cert_id = $check_cert_id;

                if($cert_id != '' && $id != '') {
                    $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $id.'_certid.jpg');

                } elseif ($cert_id == '') {
                    $cert_id_old = Customer::select('cert_id')->where('customer_id', $id)->first();
                    $image_cert_id = $cert_id_old->cert_id;

                } else {
                    $image_cert_id = '';
                } 
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_id' =>  "storage/".$image_cert_id,

                        ]);

            }
            return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function statusAct(Request $request)
    {
        if($request->id_act == 2 && $request->status == 'active') {
            Customer::where('id', $request->code_id)
                    ->update ([ 'customer_status' => 'active' ]);

        }
    }

    public function statusiAct(Request $request)
    {
        if($request->id_inact == 1 && $request->status_in == 'inactive') {
            Customer::where('id', $request->code_id)
                    ->update ([ 'customer_status' => 'inactive' ]);

        }
    }

    //เก็บไว้ดู Import_csv;
  /*   public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) {

            $path = $request->file('import_csv');
            if($path == null) {
                $path == '';
                // dd($path);
            } else {
                $rename = 'Customer_all'.'_'.'.csv';
                Excel::import(new CustomerImport, $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'), 'importfiles', \Maatwebsite\Excel\Excel::CSV);
                // dd($path);
            }

        }

    } */

    public function import()
    {
         //menu alert;
         $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('/webpanel/importcustomer', compact('status_alert', 'status_waiting', 'status_updated'));
    }
    //เก็บไว้ดู Import_csv;
    public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            
                $path = $request->file('import_csv');
                if($path == null) {
                    $path == '';
    
                } else {

                    $rename = 'Customer_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');

                        while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                if($row[0] ??= '') {
                                
                                    $customer_name_new = str_replace("'", "''", $row[2]);
                                    $address = str_replace("'", "''", $row[4]);
                                    $cert_number = str_replace("'", "''", $row[5]);
                                    $cert_expire_new = date('31/12/2024'); 
                                    $cert_store = str_replace("'", "''", $row[8]); 
                                    $cert_number = str_replace("'", "''", $row[5]);
                
                                    $province = explode(" ", $row[4]);
                                    $province_new = $province[count($province) - 5];
                                    // dd($province);
            
                                    if($province_new == '' || $province_new == 1) {
                                        $province = explode(" ", $row[4]);
                                        $province_new = $province[count($province) - 2];
                                        
                                    }

                                
                                    $province_check = DB::table('provinces')->select('name_th', 'geography_id')->where('name_th',$province_new)->first();
                                    // dd($province_check->geography_id);
                                    $geography_name = DB::table('geographies')->select('id', 'name')->where('id', $province_check->geography_id)->first();
                                    $name_geography = ($geography_name->name);
                                    // dd($name_geography);

                                    $amphur = explode(" ", $row[4]);
                                    $amphur_new = $amphur[count($amphur) - 6];
                                    // dd($amphur_new);
            
                                    if($amphur_new == '' || $amphur_new == 1) {
                                        $amphur = explode(" ", $row[4]);
                                        $amphur_new = $amphur[count($amphur) - 9];
                                        // dd($amphur_new);
                                    }

                                    //check saraburi;
                                    $check_arr = explode(" ", $row[4]);
                                    $check_saraburi = $check_arr[count($check_arr) - 2];
                                   
                                   /*  $check_arr_saraburi = array_filter($check_arr, function($value) {
                                        return $value == 'กรุงเทพมหานคร';
                                    }); */

                                    // dd($check_arr_saraburi);
                                 
                                
                                    $district = explode(" ", $row[4]);
                                    $count_arr = count($district);


                                    if($count_arr > 13) {

                                        //check saraburi;
                                        if($check_saraburi === 'สระบุรี') {
                                            $district_new = $district[count($district) - 10];

                                        } else {
                                            $district_new = $district[count($district) - 13];
                                        }
    
                                    } elseif ($count_arr == 13) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    } elseif ($count_arr == 12) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    } elseif ($count_arr == 11) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    }
                                    
                

                                    $zip_code = explode(" ", $row[4]);
                                    $zip_code_new = $zip_code[count($zip_code) - 1];
        
                                    $address = explode(" ", $row[4]);
                                    $address_new = $zip_code[0];

                                    $sale_area_new = $row[1];
                                    if ($sale_area_new == '') {
                                        $sale_area_new = 'ไม่ระบุ';
                                    }

                                    $status_user = str_replace("'", "''", $row[10]); 

                                    //delivery;
                                    $delivery_row = $row[18];
                                    if($delivery_row == 1) {
                                        $delivery_by ='owner';
                                    } else {
                                        $delivery_by ='standard';
                                    }

                                    $customer_id = $row[0];
                                    $customer_code  = $row[0];
                                    $customer_name = $customer_name_new;
                                    $price_level = $row[7];
                                    $email = '';
                                    $phone = '';
                                    $telephone = '';
                                    $address = $address_new;
                                    $province = $province_new;
                                    $amphur = $amphur_new;
                                    $district = $district_new;
                                    $zip_code = $zip_code_new;
                                    $geography = $geography_name;
                                    $admin_area = '';
                                    $sale_area = $sale_area_new;
                                    $text_area = '';
                                    $text_admin = '';
                                    $cert_store = '';
                                    $cert_medical = '';
                                    $cert_commerce = '';
                                    $cert_vat = '';
                                    $cert_id = '';
                                    $cert_number = $row[5];
                                    $cert_expire = $cert_expire_new;
                                    $status = 'รอดำเนินการ';
                                    $password = '';
                                    $status_update = '';
                                    $type = $row[8];
                                    $register_by = 'import_naster';
                                    $customer_status = 'active';
                                    // $delivery_by = 'standard';

                            
                            Customer::create([

                                    'customer_id' => $customer_id,
                                    'customer_code' => $customer_code,
                                    'customer_name' => $customer_name,
                                    'price_level' => $price_level,
                                    'email' => $email,
                                    'phone' => $phone,
                                    'telephone' => $telephone,
                                    'address' => $address,
                                    'province' =>  $province,
                                    'amphur' => $amphur,
                                    'district' => $district,
                                    'zip_code' => $zip_code,
                                    'geography' => $name_geography,
                                    'admin_area' => $admin_area,
                                    'sale_area' => $sale_area,
                                    'text_area' => $text_area,
                                    'text_admin' => $text_admin,
                                    'cert_store' => $cert_store,
                                    'cert_medical' =>  $cert_medical,
                                    'cert_commerce' => $cert_commerce,
                                    'cert_vat' => $cert_vat,
                                    'cert_id' => $cert_id,
                                    'cert_number' => $cert_number,
                                    'cert_expire' => $cert_expire,
                                    'status' => $status,
                                    'password' => $password,
                                    'status_update' => $status_update,
                                    'type' => $type,
                                    'register_by' => $register_by,
                                    'customer_status' => $customer_status,
                                    'status_user' => $status_user,
                                    'delivery_by' => $delivery_by,
        
                                ]);
                            }

                        }

                        fclose($fileStream);

                }

        }
        $count = Customer::all()->count();
        
        return redirect('/webpanel/customer/importcustomer')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
            
   }

   ///groups customer;
   public function groupsCustomer() 
   {
    $row_salearea = Salearea::select('sale_area', 'sale_name', 'admin_area', 'updated_at')->where('sale_area', '!=', '')
                        ->orderBy('sale_area', 'asc')
                        ->get();

    $customer_area_list = Customer::select('admin_area', 'sale_area')->first();
    $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->get();

    $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->count();

    $status_updated = Customer::where('status_update', 'updated')
                                ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->count();

    $status_alert = $status_waiting + $status_updated;

    return view('/webpanel/groups-customer', compact('row_salearea', 'customer_area_list', 'admin_area_list', 'status_waiting','status_updated', 'status_alert'));
   }
   public function updateAdminarea(Request $request, $sale_area)
   {

        date_default_timezone_set("Asia/Bangkok");
        $admin_area = $request->admin_area;
        if($request->admin_area == null) {
            $admin_area = '';
        }

        Customer::where('sale_area', $sale_area)->update(['admin_area' => $admin_area]);
        Salearea::where('sale_area', $sale_area)->update(['admin_area' => $admin_area]);

    // }
       return back()->with('success','อัปเดตข้อมูลเรียบร้อย');

    

   }

   //getcsv customer by customer_id;
   public function getCustomerCsv($customer_id)
   {

            $date = date('Y-m-d');
            $filename = 'Customer__'.$customer_id.'_'.$date. '.csv';
            // Start the output buffer.
            ob_start();

            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query = Customer::select('customer_code', 'customer_name', 'price_level', 'type', 'telephone','email', 'address', 'sale_area')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('customer_id', $customer_id)
                                ->get();

            $data = $query->toArray();

            // Create a file pointer with PHP.
            $output = fopen( 'php://output', 'w' );

            // Write headers to CSV file.
            // fputcsv( $output, $header_args );

            // Loop through the prepared data to output it to CSV file.
            foreach( $data as $data_item ){
                fputcsv($output, $data_item, "|" );
            }

            // Close the file pointer with PHP with the updated output.
            fclose( $output );
            exit;
   }

   //delete customer;
   public function deleteCustomer(Request $request,  $id)
   {

        if(!empty($request->id)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $customer = Customer::where('id', $id)->first();
            // dd($customer->cert_store);

            //delete image storage;
            Storage::delete($customer->cert_store);
            Storage::delete($customer->cert_medical);
            Storage::delete($customer->cert_commerce);
            Storage::delete($customer->cert_vat);
            Storage::delete($customer->cert_id);

            $customer->delete();

            echo json_encode(array('checkcode'=> $request->id));

        }
    
   }

   /// search customer;
   public function customerSearch(Request $request)
   {
       $keyword = $request->keyword;

       $id = $request->user()->admin_area;

       $check_search_code = Customer::where('customer_id', 'like', '%'.$keyword.'%')
                                       ->orWhere('customer_name', 'like', '%'.$keyword.'%')
                                       ->where('admin_area', $id)->first();
       
       // echo json_encode(array('code' => $check_search_code->admin_area, 'id'=>$id));

       $arr_keyword = ['0000', '4494', '7787', '9000'];
       
       if(in_array($keyword, $arr_keyword) || $check_search_code->admin_area != $id)
       {
         
           echo 'ไม่พบข้อมูล';
           return;
           

       } else {

           $customers = Customer::where('customer_id', 'like', "%{$keyword}%")
                                   ->where('admin_area', $id)
                                   ->orWhere('customer_name', 'like', "%{$keyword}%")
                                   ->whereIn('admin_area', [$id])
                                   ->where('admin_area', $id)->paginate(2);

/* 
           $check_search = Customer::where('customer_id', 'like', '%'.$keyword)
                                   ->orWhere('customer_name', 'like', '%'.$keyword.'%')
                                   ->whereNotIn('admin_area',[$id])->first();

                                   echo $check_search->admin_area; */
       /*     if($customers== null) {
               echo 'ไม่พบข้อมูล';
               return;
           } */

          
               foreach($customers as $row_customer)
               {


                   // if($row_customer->customer_id !=  '0000' AND $check_search->admin_area == $id AND $check_search->admin_area != '') {
                   if($row_customer->customer_id !=  '0000') {

                       echo
                       '

                               
                      <div style="background-color: #17192A; absolute: potision; position: static;">
                           <div class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75  hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                               
                               <a  href="/webpanel/customer/'.$row_customer->customer_id .'" style="text-decoration: none;"> '.$row_customer->customer_id .' ' .':'.' ' .$row_customer->customer_name.' </a>
                           
                           </div>
                       </div> 
                       
                       ';
                   }
                   
               }
               
           
       }
       
   }

}
