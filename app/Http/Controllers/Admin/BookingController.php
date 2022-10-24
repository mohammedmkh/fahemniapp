<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Bookingstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Price;
use App\User;
use Gate;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingController extends Controller
{




    public function bookingsReport(){
       // dd('man');
       // i will get the booking that hav  done status
      $bookings = User::where('role' , 3)
          ->wherehas('bookings', function ($query) {
              $query->where('is_posting', 0); // is not posting before
              $query->where('status', 4);  // is complete
          })
      ->orderBy('id','desc')->get();

       foreach ( $bookings as $book){
           $total_finish = $book->bookings->where('status' ,4)->where('is_posting' , 0)->sum('total');
           $book->total_finish= $total_finish;
           $total_tutor_finish = $book->bookings->where('status' ,4)->where('is_posting' , 0)->sum('tutor_earn');
           $book->total_tutor_finish =$total_tutor_finish  ;

           $book->total_admin_finish = $total_finish - $total_tutor_finish  ;
       }

       // dd( $collection );
      // return    $keyed ;
      return view('admin.bookings.bookingreport' , compact('bookings'));

    }


    public function notrefundBooking(Request $request){
        $booking_id = $request->booking_id;
        $booking = Booking::where('id' , $booking_id)->first();
        if( $booking ){
            $response['status']= true ;
            $booking->is_refunded = 2 ;
            $booking->save();

            return $response ;
        }
    }


    public function refundBooking(Request $request){

        $ch = curl_init();

        $booking_id = $request->booking_id;
        $booking = Booking::where('id' , $booking_id)->first();
        if( $booking ){
            //dd($booking_id);

            $id = $booking->checkout_id ;
           // dd($id);
            curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/'.$id.'/refund');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, 'sk_live_JPn1Hx6CoMTH96kHSc89YKoN8QzMN2meMRne76hN' . ':' . '');

            $result = curl_exec($ch);
            //dd($result);
            if (curl_errno($ch)) {
                $response['status']= false ;
              //  echo 'Error:' . curl_error($ch);
            }else{
                $response['status']= true ;

                $booking->is_refunded = 1 ;
                $booking->save();
                // now we want to process this booking is was refund
            }
            curl_close($ch);

            return $response;
        }


    }


    public function refundExample(){

        $ch = curl_init();

        $id = '163e141e-32fe-4b15-b283-3f47a216d54c' ;
        curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/'.$id.'/refund');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, 'sk_live_JPn1Hx6CoMTH96kHSc89YKoN8QzMN2meMRne76hN' . ':' . '');

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $query = Booking::whereNotNull('status')
            ->with(['user', 'tutor', 'price'])->select(sprintf('%s.*', (new Booking())->table));
        if (request()->has('status') and request()->status > -1 ) {
            $query->where('status', request()->status );
        }
        if (request()->has('is_refunded') and request()->is_refunded > -1 ) {
            $query->where('is_refunded', 0 );
        }
        if (request()->has('idbooking') and request()->idbooking <> '' ) {
            $query->where('id', request()->idbooking);
        }
        if (request()->has('date') and request()->date <> '' ) {
            $query->where('date', request()->date);
        }
        $table = Datatables::of($query);
       // dd($table );
        if ($request->ajax()) {
            $query = Booking::whereNotNull('status')
                ->with(['user', 'tutor', 'price'])->select(sprintf('%s.*', (new Booking())->table));
            if (request()->has('status') and request()->status > -1 ) {
                $query->where('status', request()->status );
            }
            if (request()->has('is_refunded') and request()->is_refunded > -1 ) {
                $query->where('is_refunded', 0 );
            }
            if (request()->has('idbooking') and request()->idbooking <> '' ) {
                $query->where('id', request()->idbooking);
            }
            if (request()->has('date') and request()->date <> '' ) {
                $query->where('date', request()->date);
            }
            if (request()->has('payed') and request()->payed > -1 ) {
                $query->where('payed', request()->payed);
            }

            if (request()->has('name') and request()->name <> '' ) {
                $tutors = User::where('role' , 3)->where('name', 'like' , '%' .request()->name .'%' )->get()->pluck('id')->toArray();
                //dd( $tutors);
                $query->whereIn('tutor_id',  $tutors);
            }

            $table = Datatables::of($query);




            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'booking_show';
                $editGate = 'booking_edit';
                $deleteGate = 'booking_delete';
                $crudRoutePart = 'bookings';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('user_phone', function ($row) {
                return $row->user ? $row->user->phone : '';
            });
            $table->addColumn('tutor_name', function ($row) {
                return $row->tutor ? $row->tutor->name : '';
            });

            $table->addColumn('tutor_phone', function ($row) {
                return $row->tutor ? $row->tutor->phone : '';
            });


            $table->editColumn('payed', function ($row) {
                $stat = '' ;

                  if( $row->payed == 0){
                      $stat .= 'No <br>' ;
                  }

                  if($row->status == 4 && $row->payed == 0){
                      $stat .= '<span class="btn btn-danger" onclick="payThisBooking('.$row->id.') "> ادفع له</span>';
                  }

                  if($stat != ''){
                      return $stat;
                  }


                return 'Yes';
            });
            $table->editColumn('status', function ($row) {
                if($row->status == 1){
				 return '<span class="label label-lg label-light-warning label-inline" style="font-size: 10px; padding: 3px">'.$row->booking_status.'</span>';
                }
                if($row->status == 2){
                    return '<span class="label label-lg label-light-primary label-inline" style="font-size: 10px; padding: 3px">'.$row->booking_status.'</span>';
                }
                if($row->status == 3){
                    return '<span class="label label-lg label-light-success label-inline" style="font-size: 10px; padding: 3px">'.$row->booking_status.'</span>';
                }
                if($row->status == 4){
                    return '<div class="label label-lg label-light-success label-inline" style="font-size: 10px;  color:#b174c2!important; background-color:#7b1199!important;">'.$row->booking_status.'</div>';
                }
                if($row->status == 5){
                    return '<div style="font-size: 10px;  color:#d92109!important; ">'.$row->booking_status.'</div>';
                }
                if($row->status == 6){
                    return '<div style="font-size: 10px; color:#d92109!important; ">'.$row->booking_status.'</div>';
                }
                return $row->status ? $row->booking_status : '';
            });
            $table->addColumn('price_num_std', function ($row) {
                return $row->price ? $row->price->num_std : '';
            });

            $table->addColumn('time', function ($row) {
                return $row->the_time ? $row->the_time : '';
            });

            $table->addColumn('total_tutor_earn', function ($row) {
                return $row->tutor_earn ?  $row->tutor_earn : '';
            });

            $table->addColumn('total_fahemni_earn', function ($row) {
                return $row->total ? $row->total - $row->tutor_earn : '';
            });

            $table->editColumn('total', function ($row) {
                return $row->total ? $row->total : '';
            });

            $table->editColumn('bank_name', function ($row) {
                return $row->tutor->bank_name ? $row->tutor->bank_name  : '';
            });
            $table->editColumn('bank_user_name', function ($row) {
                return $row->tutor->bank_user_name ? $row->tutor->bank_user_name  : '';
            });

            $table->editColumn('bank_iban', function ($row) {
                return $row->tutor->bank_iban ? $row->tutor->bank_iban  : '';
            });

            $table->editColumn('bank_account', function ($row) {
                return $row->tutor->bank_account ? $row->tutor->bank_account  : '';
            });

            $table->rawColumns(['actions', 'payed' , 'placeholder', 'status', 'user', 'tutor', 'price']);


           // dd( $table);
            return $table->make(true);
        }

        $statuses = Bookingstatus::all();
        return view('admin.bookings.index' , compact('statuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::where('role' ,3)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prices = Price::all()->pluck('num_std', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookings.create', compact('users', 'tutors', 'prices'));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::where('role' ,3)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prices = Price::all();

        $booking_statuses = Bookingstatus::all();
        $booking->load('user', 'tutor', 'price');

        return view('admin.bookings.edit', compact('users', 'tutors', 'prices', 'booking' ,'booking_statuses'));
    }

    public function update(Request $request, Booking $booking)
    {

      //  dd($request->all());
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('user', 'tutor', 'price');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
