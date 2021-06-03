<?php

/**
 * Author: Alperen AKYUZ
 * 2021 Parionsoft
 */


namespace App\Http\Controllers\Payment;


use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mews\Pos\Entity\Card\CreditCardGarantiPos;
use Mews\Pos\Exceptions\BankClassNullException;
use Mews\Pos\Exceptions\BankNotFoundException;
use Mews\Pos\Factory\AccountFactory;
use Mews\Pos\Factory\PosFactory;
use Mews\Pos\Gateways\AbstractGateway;
use Mews\Pos\Gateways\GarantiPos;

class GarantiController extends Controller
{

    protected $ip;
    protected $account;
    protected $pos;
    protected $success_url;
    protected $fail_url;

    /**
     * @throws \Mews\Pos\Exceptions\MissingAccountInfoException
     */
    public function __construct()
    {
        $this->account = AccountFactory::createGarantiPosAccount('garanti', '7000679', 'PROVAUT', '123qweASD/', '30691298', '3d', '12345678');
        try {
            $this->pos = PosFactory::createPosGateway($this->account);
            $this->pos->setTestMode(true);
        } catch (BankNotFoundException | BankClassNullException $e) {
            dump($e->getCode(), $e->getMessage());
        }

        $this->success_url = route('garanti-callback');
        $this->fail_url = route('garanti-callback');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request) {

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        dd($cart);

        $ip = '127.0.0.1';//$request->getClientIp();
        //$account = AccountFactory::createGarantiPosAccount('garanti', '7000679', 'PROVAUT', '123qweASD/', '30691298', '3d', '12345678');

        $orderId = date('Ymd') . strtoupper(substr(uniqid(sha1(time())),0,4));

        $amount = (float) 1.3;
        $instalment = '0';


        $rand = microtime();

        $order = [
            'id'                => $orderId,
            'email'             => 'mail@customer.com', // optional
            'name'              => 'John Doe', // optional
            'amount'            => $amount,
            'installment'       => $instalment,
            'currency'          => 'TRY',
            'ip'                => $ip,
            'success_url'       => $this->success_url,
            'fail_url'          => $this->fail_url,
            'lang'              => GarantiPos::LANG_TR,
            'rand'              => $rand,
        ];

        //$redis->lPush('order', json_encode($order));
        Session::put('ordertrans', json_encode($order));

        $card = new CreditCardGarantiPos(
            $request->get('number'),
            $request->get('year'),
            $request->get('month'),
            $request->get('cvv'),
            $request->get('name'),
            $request->get('type')
        );

        $this->pos->prepare($order, AbstractGateway::TX_PAY, $card);

        $form_data = $this->pos->get3DFormData();
        return view('theme::pages.checkout.3dredirect', compact('form_data'));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Mews\Pos\Exceptions\UnsupportedPaymentModelException
     */
    public function callback(Request $request) {
        $ip = '127.0.0.1';//$request->getClientIp();
        $order = (array) json_decode(Session::get('ordertrans'));
        $this->pos->prepare($order, AbstractGateway::TX_PAY);
        $this->pos->payment();
        $response = $this->pos->getResponse();
        dd($response);
    }

}
