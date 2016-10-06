<?php

namespace Learncloud\Http\Controllers;

use Illuminate\Http\Request;
use Learncloud\Http\Requests;
use Learncloud\Paycloud;
use Learncloud\User;
use Auth;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

class PaypalController extends Controller
{

    public function accessPaypal(Request $request)
    {
        $paypal = new \PayPal\Rest\ApiContext(

                  new \PayPal\Auth\OAuthTokenCredential(

                        'AWjQ2D0esnXeaWcX2EcApaiuZOjXGugrCOlAj7kWKmGiWaAyOqazHdIbYHvy9ERbE2W0wB9YlPZM4on7',
                        'ECkC3nXU6_sVbKLlMGSHGg1yJqqLT8rM-6W4ni5NRrn-5C6Mwzq9CPzylNyu-JmCZzaPVQ6X_RvxAqWL'

                    )
            );

/**/    if($request->select){    

                if ($request->select == 'bronze') {
                    
                    $selected = ((( 6 - (Auth::user()->userPoint->points /1000)) * 5)) +1;

                } elseif ($request->select == 'silver') {

                    $selected = ((( 12 - (Auth::user()->userPoint->points /1000)) * 5)) +1;

                }elseif ($request->select == 'gold') {
                  
                    $selected = ((( 20 - (Auth::user()->userPoint->points /1000)) * 5)) +1;

                }

        }else{

            $selected = 1;
          
        }

        

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('zip account')
             ->setCurrency('USD')
             ->setQuantity(1)
             ->setPrice($selected);


        $itemlist = new ItemList();
        $itemlist->setItems([$item]);

        $details = new Details();
        $details->setSubtotal($selected); 

        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal($selected)
               ->setDetails($details);

        $transaction = new Transaction(); 
        $transaction->setAmount($amount)
                    ->setItemList($itemlist)
                    ->setDescription('pay for something now')
                    ->setInvoiceNumber(uniqid());              

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('home/congrats').'?success=true')
                     ->setCancelUrl(url('home/congrats').'?success=false');

         $payment = new Payment();
         $payment->setIntent('sale')
                 ->setPayer($payer)
                 ->setRedirectUrls($redirectUrls)
                 ->setTransactions([$transaction]);
         try {
                   $payment->create($paypal);

            } catch (\PayPal\Exception\PayPalConnectionException  $e) {

               echo $e->getData();
                dd($e);
             
            }

          $approvalUrl = $payment->getApprovalLink();


          return redirect($approvalUrl);                         

    }    

/////////////////////////////////////////////////////////////////////////////////////////////////

    public function postRefundedUser( Request $request,$payment_id,$payer_id)
   {
    
       $paycloud = Paycloud::where('payment_id','=',$payment_id)->first();

        $paycloud->refunded   = 1 ;

        $paycloud->save();

        return view('refundedout');

   }
///////////////////////////////////////////////////////////////////////////////////////////////////
   public function refundLogout()
   {
       Auth::logout();

       return redirect()->route('home');

   }

}