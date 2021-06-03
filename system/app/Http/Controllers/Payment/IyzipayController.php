<?php

/**
 * Author: Alperen AKYUZ
 * 2021 Parionsoft
 */


namespace App\Http\Controllers\Payment;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Payment;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\CreatePaymentRequest;


class IyzipayController extends Controller
{

    protected $options;
    protected $callback;


    public function __construct()
    {
        $this->options = new Options();
        $this->options->setApiKey("sandbox-qF60M31WHN8WgnLu4tDMDV6kBfTx1Ifn");
        $this->options->setSecretKey("sandbox-r11Hufy2fDw8UWq24Tte7dWuMVfNGJDe");
        $this->options->setBaseUrl("https://sandbox-api.iyzipay.com");
        $this->callback = route('iyzipay-callback');
    }


    public function store(Request $request) {

        // Create Payment Request
        $iyziRequest = new CreateCheckoutFormInitializeRequest();
        $iyziRequest->setLocale(\Iyzipay\Model\Locale::TR);
        $iyziRequest->setConversationId("123456789");
        $iyziRequest->setPrice("1");
        $iyziRequest->setPaidPrice("1.2");
        $iyziRequest->setCurrency(Currency::TL);
        $iyziRequest->setBasketId("B67832");
        $iyziRequest->setPaymentGroup(PaymentGroup::PRODUCT);
        $iyziRequest->setCallbackUrl($this->callback);
        $iyziRequest->setEnabledInstallments(array(2, 3, 6, 9));

        /**$paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName("John Doe");
        $paymentCard->setCardNumber("5528790000000008");
        $paymentCard->setExpireMonth("12");
        $paymentCard->setExpireYear("2030");
        $paymentCard->setCvc("123");
        $paymentCard->setRegisterCard(0);
        $iyziRequest->setPaymentCard($paymentCard);**/

        // Create Buyer
        $buyer = new Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $iyziRequest->setBuyer($buyer);

        // Buyer Shipping Address
        $shippingAddress = new Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $iyziRequest->setShippingAddress($shippingAddress);

        // Buyer Billing Address
        $billingAddress = new Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $iyziRequest->setBillingAddress($billingAddress);

        // Cart Items
        $basketItems = array();
        $firstBasketItem = new BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("1");
        $basketItems[0] = $firstBasketItem;

        $iyziRequest->setBasketItems($basketItems);

        $form = CheckoutFormInitialize::create($iyziRequest, $this->options);//Payment::create($iyziRequest, $this->options);

        return view('theme::pages.checkout.iyzipay', compact('form'));


    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Mews\Pos\Exceptions\UnsupportedPaymentModelException
     */
    public function callback(Request $request) {

    }

}
