<x-layout>
    <section class="vh-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card card-stepper" style="border-radius: 16px;">
                    <div class="card-header p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2"> Order ID <span class="fw-bold text-body">{{$orders->trans_code}}</span></p>
                                <p class="text-muted mb-0"> Place On <span class="fw-bold text-body">{{$orders->created_at}}</span> </p>
                                <p class="text-muted mb-0"> Name <span class="fw-bold text-body">{{$orders->name}}</span> </p>
                                <p class="text-muted mb-0"> Phone <span class="fw-bold text-body">{{$orders->phone}}</span> </p>
                                <p class="text-muted mb-0"> Phone <span class="fw-bold text-body">{{$orders->user_add}}</span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-row mb-4 pb-2">
                        <div class="flex-fill">
                            <h5 class="bold">Headphones Bose 35 II</h5>
                            <p class="text-muted"> Qt: 1 item</p>
                            <h4 class="mb-3"> $ 299 <span class="small text-muted"> via ({{$payment_opt}}) </span></h4>
                            <p class="text-muted">Tracking Status on: <span class="text-body">11:30pm, Today</span></p>
                        </div>
                        <div>
                            <img class="align-self-center img-fluid"
                            src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/6.webp" width="250">
                        </div>
                        </div>
                        <ul id="progressbar-1" class="mx-0 mt-0 mb-5 px-0 pt-0 pb-4">
                        <li class="step0 active" id="step1"><span
                            style="margin-left: 22px; margin-top: 12px;">PLACED</span></li>
                        <li class="step0 active text-center" id="step2"><span>SHIPPED</span></li>
                        <li class="step0 text-muted text-end" id="step3"><span
                            style="margin-right: 22px;">DELIVERED</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-layout>
