<?php


namespace App\Http\Controllers\Admin\Cargo;


use App\Http\Controllers\Controller;
use App\Models\Cargo\Shipper;
use App\Models\Cargo\ShipperRate;
use App\Models\Cargo\ShippingRate;
use App\Models\User;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ShipperRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
        $datas = ShipperRate::all()->unique('shipper');
        //dd($datas);
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('shipper', function (ShipperRate $data) {
                $name = $data->shipper->shipper;
                return $name;
            })
            ->addColumn('action', function (ShipperRate $data) {
                return '<div class="action-list"><a data-href="' . route('admin-shipper-rates-edit', $data->shipper->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-shipper-rates-delete', $data->shipper->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {

        return view('admin.cargo.shipperrate.index');
    }

    //*** GET Request
    public function create()
    {

        $shippers = Shipper::where('status', 1)->get();
        $rates = ShippingRate::all();
        return view('admin.cargo.shipperrate.create', compact('shippers', 'rates'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['shipper_id' => 'required|unique:shipper_rates'];
        $messages = [
            'required' => ':attribute girilmesi mecburidir.',
            'shipper_id.unique' => 'Bu kargo firması ile daha önceden set oluşturdunuz'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends*/

        $shipper_id = $request->shipper_id;
        $rates = $request->rate;
        foreach ($rates as $key => $rate) {

            if ($rate != null) {
                $shipper_rate = ShipperRate::create([
                    'shipper_id' => $shipper_id,
                    'user_id' => 0,
                    'rate_id' => $key,
                    'value' => $rate,
                    'status' => 1
                ]);
            }
        }


        //--- Redirect Section
        $msg = 'Oran fiyatları başarıyla eklendi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {

        // edit'e basıldığında kargo firmasının id numarası gönderiliyor.
        //
        //$data = ShipperRate::findOrFail($id);
        //$values = ShipperRate::select('value')->where(['shipper_id' => $id, 'user_id' => 0])->get();
        $shipper = Shipper::find($id);
        $rates = ShippingRate::all();
        $rates = $rates->map(function ($query) use ($id) {
            /*if ($this->user_id != 0) {
                $vendor = User::find($this->user_id);
                //$price = $this->price + $gs->fixed_commission + ($this->price/100) * $gs->percentage_commission ;
            }*/
            //$query->shipper =
            $query->shipperRate = ShipperRate::where(['shipper_id' => $id, 'rate_id' => $query->id, 'user_id' => 0])->first();
            return $query;
        });

        //dd($rates);

        return view('admin.cargo.shipperrate.edit', compact('shipper', 'rates'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section

        /*$data = ShipperRate::findOrFail($id);
        $input = $request->all();
        $data->update($input);*/

        $rates = $request->rate;
        //dd($rates);

        foreach ($rates as $key => $rate) {

            if ($rate['value'] != null) {
                $shipperRate = ShipperRate::updateOrCreate(
                    ['id' => $rate['id']],
                    ['value' => $rate['value'], 'shipper_id' => $id, 'user_id' => 0, 'rate_id' => $key]
                );
            }
        }


        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Veriler Başarıyla Güncellendi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = ShipperRate::where('shipper_id', $id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
