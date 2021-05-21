<?php


namespace App\Http\Controllers\Admin\Cargo;


use App\Http\Controllers\Controller;
use App\Models\Cargo\Shipper;
use App\Models\Cargo\ShippingRate;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class ShippingRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
        $datas = ShippingRate::all();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('shipper', function(ShippingRate $data) {
                //$shipper = Shipper::select('shipper')->where(['id' => $data->shipper_id])
                $name = $data->shipper;
                return $name;
            })
            ->addColumn('action', function(ShippingRate $data) {
                return '<div class="action-list"><a data-href="' . route('admin-shipping-rates-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>'.__('Edit'). '</a><a href="javascript:;" data-href="' . route('admin-shipping-rates-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.cargo.shippingrate.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.cargo.shippingrate.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        /*$rules = ['shipper' => 'unique:shipping_rates'];
        $customs = ['shipper.unique' => 'This title has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }*/
        //--- Validation Section Ends

        //--- Logic Section
        $data = new ShippingRate();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Desi Oranı başarıyla eklendi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = ShippingRate::findOrFail($id);
        return view('admin.cargo.shippingrate.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section

        $data = ShippingRate::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Veriler Başarıyla Güncellendi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = ShippingRate::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Başarıyla silindi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
