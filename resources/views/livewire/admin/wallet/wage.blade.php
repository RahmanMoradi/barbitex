<div>
    <section id="transaction">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">کارمزد های بازار حرفه ای</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>ارز</th>
                                        <th>مبلغ</th>
                                        <th>تاریخ و ساعت ثبت</th>
                                        <th>شرح</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                {{$transaction->currency}}
                                            </td>
                                            <td>
                                                مبلغ
                                                : {{$transaction->price}}
                                            </td>
                                            <td>{{$transaction->created_at_fa}}</td>
                                            <td>{{$transaction->description}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                {{$transactions->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">موجودی مدیریت</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>ارز</th>
                                        <th>موجودی</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($balances as $balance)
                                        <tr>
                                            <td>
                                                {{$balance->currency}}
                                            </td>
                                            <td>
                                                {{$balance->balance_free}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                {{$balances->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
