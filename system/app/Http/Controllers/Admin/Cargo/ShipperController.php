<?php


namespace App\Http\Controllers\Admin\Cargo;


use App\Http\Controllers\Controller;
use App\Models\Cargo\Shipper;
use Datatables;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid as UUID;
use Validator;


class ShipperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
        $datas = Shipper::all();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('action', function(Shipper $data) {
                return '<div class="action-list"><a data-href="' . route('admin-shippers-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>'.__('Edit'). '</a><a href="javascript:;" data-href="' . route('admin-shippers-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.cargo.shipper.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.cargo.shipper.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['shipper' => 'unique:shippers'];
        $customs = ['shipper.unique' => 'This title has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Shipper();
        $input = $request->all();
        $data->uuid = UUID::uuid1();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Kargo firması başarıyla eklendi.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Shipper::findOrFail($id);
        return view('admin.cargo.shipper.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = ['shipper' => 'unique:shippers,shipper,'.$id];
        $customs = ['shipper.unique' => 'This title has already been taken.'];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section

        $data = Shipper::findOrFail($id);
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
        $data = Shipper::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
