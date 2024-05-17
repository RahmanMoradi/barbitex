<div>
    <section id="logs">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">@lang('user login logs')</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>@lang('user')</th>
                                        <th>@lang('ip')</th>
                                        <th>@lang('device')</th>
                                        <th>@lang('created at')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{optional($log->user)->name}}</td>
                                            <td>
                                                {{$log->ip}}
                                            </td>
                                            <td>{{$log->device}}</td>
                                            <td>{{$log->created_at_fa}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                {{$logs->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
