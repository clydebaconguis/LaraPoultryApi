<x-layout>
    <section class="vh-100">
    <div class="container py-5 h-100">
        @if(session()->has('message')) <p class="alert alert-success">{{session('message')}}</p> @endif
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card card-stepper" style="border-radius: 16px;">
                    <div class="card-header p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @unless (count($details) == 0)
                                    @php
                                        $detail = $details[0]
                                    @endphp
                                    <p class="text-muted mb-2"> Order ID <span class="fw-bold text-body">{{$detail->trans_code}}</span></p>
                                    <p class="text-muted mb-0"> Place On <span class="fw-bold text-body">{{$detail->created_at}}</span> </p>
                                    <p class="text-muted mb-0"> Name <span class="fw-bold text-body">{{$detail->name}}</span> </p>
                                    <p class="text-muted mb-0"> Phone <span class="fw-bold text-body">{{$detail->phone}}</span> </p>
                                    <p class="text-muted mb-0"> Address <span class="fw-bold text-body">{{$detail->user_add}}</span> </p> <br>
                                    <p class="text-muted mb-0"> Status changed on <span class="fw-bold text-body">{{$detail->updated_at}}</span> </p> <br>
                                    @if ($detail->date_to_deliver)
                                        <p class="text-muted mb-0"> Estimated date of delivery <span class="fw-bold text-body">{{$detail->date_to_deliver}}</span> </p>
                                    @endif

                                    @if ($detail->date_delivered)
                                        <p class="text-muted mb-0"> Date Delivered <span class="fw-bold text-body">{{$detail->date_delivered}}</span> </p>
                                    @endif
                                    @if ($detail->proof_of_delivery)
                                        <img class="align-self-center img-fluid" style="width: 80px; height: 80px"
                                        src="https://drive.google.com/uc?export=view&id={{$detail->proof_of_delivery}}"> 
                                        
                                    @endif

                                    @if ($detail->proof_of_payment && $detail->payment_opt == "GCASH")
                                        <p>Reference {{$detail->proof_of_payment}}</p>
                                    @endif
                                @endunless
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="/assign-courier/{{$detail->id}}">
                            @csrf
                            @if ($detail->status == "for approval" || $detail->status == "preparing for delivery")
                                @unless (count($riders) == 0)
                                    <select name="rider" id="rider" class="btn btn-primary mb-1" onchange="this.form.submit()">
                                        <option  class="bg-light text-dark" selected>Select Courier</option>
                                        @foreach ($riders as $rider)
                                            <option  class="bg-light text-dark" value="preparing for delivery">{{$rider->id}} {{$rider->name}}</option>
                                        @endforeach
                                    </select>
                                @endunless
                            @endif
                        </form>
                        @unless (count($items) == 0)
                            @foreach ($items as $item)
                                <div class="d-flex flex-row mb-4 pb-2">
                                    <div class="flex-fill">
                                            <h5 class="bold">{{$item->name}}</h5>
                                            <p class="text-muted">Qty: {{$item->qty}}</p>
                                            <h4 class="mb-3"> Php {{$detail->total_payment}} <span class="small text-muted"> via ({{$detail->payment_opt}}) </span></h4>
                                            <p class="text-muted">Status: <span class="text-body">{{ $detail->status }}</span></p>
                                            <p class="text-muted">Tracking Status on: <span class="text-body">{{ now()->format('H:i:s') }}, Today</span></p>
                                    </div>
                                </div>
                                <div>
                                    <img class="align-self-center img-fluid" style="width: 80px; height: 80px"
                                    src="https://drive.google.com/uc?export=view&id={{$item->image}}" width="250">
                                </div>
                            @endforeach
                        <ul id="progressbar-1" class="mx-0 mt-4 mb-5 px-0 pt-0 pb-4">
                            @if ($detail->status == "delivery")
                                    <li class="step0 active" id="step1"><span
                                            style="margin-left: 22px; margin-top: 12px;">SHIPPED</span></li>
                                    <li class="step0 active text-center" id="step2"><span
                                        style="margin-right: 22px;">ON DELIVERY</span></li>
                                    <li class="step0 text-muted text-end" id="step3"><span
                                        style="margin-right: 22px;">DELIVERED</span></li>

                            @elseif ($detail->status == "delivered")
                                   <li class="step0 active" id="step1"><span
                                            style="margin-left: 22px; margin-top: 12px;">SHIPPED</span></li>
                                    <li class="step0 active text-center" id="step2"><span
                                        style="margin-right: 22px;">ON DELIVERY</span></li>
                                    <li class="step0 active text-end" id="step3"><span
                                        style="margin-right: 22px;">DELIVERED</span></li>

                            @elseif ($detail->status == "cancel")
                                    <li class="step0 text-muted" id="step1"><span
                                        style="margin-left: 22px; margin-top: 12px;">SHIPPED</span></li>
                                    <li class="step0 text-muted text-center" id="step2"><span
                                        style="margin-right: 22px;">ON DELIVERY</span></li>
                                    <li class="step0 text-muted text-end" id="step3"><span
                                        style="margin-right: 22px;">CANCEL</span></li>

                            @elseif($detail->status == "for approval")
                                <li class="step0 text-muted" id="step1"><span
                                    style="margin-left: 22px; margin-top: 12px;">SHIPPED</span></li>
                                <li class="step0 text-muted text-center" id="step2"><span
                                    style="margin-left: 22px; margin-top: 12px;">ON DELIVERY</span></li>
                                <li class="step0 text-muted text-end" id="step3"><span
                                    style="margin-left: 22px; margin-top: 12px;">DELIVERED</span></li>
                            @endif
                        </ul>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-layout>
