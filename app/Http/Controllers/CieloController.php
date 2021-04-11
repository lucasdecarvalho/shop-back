<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cielo\API30\Merchant;

use \Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Request\CieloRequestException;

use Cart;
use App\Sold;
use App\Product;
use App\Shop;
use App\Coupon;
use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;

class CieloController extends Controller
{
    private $environment;
    private $merchant;
    private $cielo;
    private $sale;
    private $payment;

    public function __construct(Request $request){
        $this->environment = Environment::production();
        $this->merchant = new Merchant(config('cielo.MerchantId'), config('cielo.MerchantKey'));
        $this->cielo = new CieloEcommerce($this->merchant, $this->environment);
        $this->sale = new Sale('123');
        $this->payment = Payment::PAYMENTTYPE_CREDITCARD;
    }

    public function payer(Request $request)
    {
        // Crie uma instância de Customer informando o nome do cliente
        $this->sale->customer($request->holder);
            
        // Crie uma instância de Payment informando o valor do pagamento
        $payment = $this->sale->payment(12, $request->installments);
        
        // Crie uma instância de Credit Card utilizando os dados de teste
        // esses dados estão disponíveis no manual de integração
        // dd($request->installments);
        // $this->cardData($shop->final,$request->cvv,$request->date,$request->installments,$request->numberCard,$request->holder);
        $payment->setType($this->payment)
                    ->creditCard($request->cvv, CreditCard::MASTERCARD)
                    ->setExpirationDate($request->date)
                    ->setCardNumber($request->numberCard)
                    ->setHolder($request->holder);

        $merchantOrderId = $this->sale->getMerchantOrderId();
        // $saveCart['merchantOrderId'] = $merchantOrderId;
        
        // Crie o pagamento na Cielo
        try {
            // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = ($this->cielo)->createSale($this->sale);
            
            // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
            // dados retornados pela Cielo
            $paymentId = $sale->getPayment()->getPaymentId();
            $tId = $sale->getPayment()->getTid();
            
            // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
            $sale = ($this->cielo)->captureSale($paymentId, 12, 0);

            // Salvar no banco os dados da compra
            // $saveCart['paymentId'] = $paymentId;
            // $saveCart['tid'] = $tId;
            // $saveCart['status'] = 'waiting';
            // $saveCart['success'] = true;
            // Sold::create($saveCart);
            
            // Enviar email de sucesso
            // $details = [
            //     'idPed' => $tId,
            //     'title' => 'Agradecemos por sua compra em nossa loja.',
            //     'body' => 'Caso precise de alguma ajuda com o seu pedido, fale conosco através do WhatsApp® (19) 91234-5678.'
            // ];
        
            // \Mail::to($shop->email)->send(new \App\Mail\SoldMail($details));        

            // return view('success', compact('shop'));
            return response()->json(compact('sale'));

        } catch (CieloRequestException $e) {
            // Em caso de erros de integração, podemos tratar o erro aqui.
            // os códigos de erro estão todos disponíveis no manual de integração.
            // dd($e);
            $error = $e->getCieloError();
            // $erro = $error->getCode();
            $erro = $error->getMessage();

            // Salvar no banco os dados da compra
            // $saveCart['status'] = 'fail';
            // $saveCart['success'] = false;
            // $saveCart['errorCod'] = $error->getCode();
            // Sold::create($saveCart);

            // return view('error', compact('error'));
            return response()->json(compact('erro'));
        }
    }
}
