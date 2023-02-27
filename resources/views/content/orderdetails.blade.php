<x-layout>
    <section class="vh-100">
    <div class="container py-5 h-100">
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
                                    <p class="text-muted mb-0"> Address <span class="fw-bold text-body">{{$detail->user_add}}</span> </p>
                                @endunless
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-row mb-4 pb-2">
                        <div class="flex-fill">
                            @unless (count($items) == 0)
                                @foreach ($items as $item)
                                    <h5 class="bold">{{$item->name}}</h5>
                                    <p class="text-muted">Qty: {{$item->qty}}</p>
                                    <h4 class="mb-3"> Php {{$detail->total_payment}} <span class="small text-muted"> via ({{$detail->payment_opt}}) </span></h4>
                                    <p class="text-muted">Tracking Status on: <span class="text-body">{{ now()->format('H:i:s') }}, Today</span></p>
                                @endforeach
                            @endunless
                            
                        </div>
                        <div>
                            <img class="align-self-center img-fluid"
                            src="https://drive.google.com/uc?export=view&id={{$detail->image}}" width="250">
                        </div>
                        </div>
                        <ul id="progressbar-1" class="mx-0 mt-0 mb-5 px-0 pt-0 pb-4">
                        <li class="step0 active" id="step1"><span
                            style="margin-left: 22px; margin-top: 12px;">PLACED</span></li>
                        <li class="step0 active text-center" id="step2"><span>SHIPPED</span></li>

                        <li class="{{$detail->status ?'step0 active text-end' : 'step0 text-muted text-end'}}" id="step3"><span
                            style="margin-right: 22px;">DELIVERED</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-layout>
