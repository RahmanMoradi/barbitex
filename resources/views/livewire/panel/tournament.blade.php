<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card bg-analytics text-white">
        <div class="card-content">
            <div class="card-body text-center">
                <img src="/panelAssets/app-assets/images/elements/decore-left.png" class="img-left"
                     style="width: 200px;position: absolute;top: 0;left: 0;">
                <img src="/panelAssets/app-assets/images/elements/decore-right.png" class="img-right"
                     style="width: 175px;position: absolute;top: 0;right: 0;">
                <div class="avatar avatar-xl bg-primary shadow mt-0">
                    <div class="avatar-content">
                        <i class="feather icon-award white font-large-1"></i>
                    </div>
                </div>
                <div class="text-center">
                    <hr>
                    <div class="d-md-flex justify-content-md-between">
                        <div class="card">
                            <div class="card-header">
                                <h5>@lang('tournament list',['model' => 5])</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('are on the list')}}</th>
                                            <th>{{trans('user')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tournaments as $tournament)
                                            @if($tournament->type == 5)
                                                <tr>
                                                    <td>{{$tournament->number}}</td>
                                                    <td>{{$this->get_starred(optional($tournament->user)->email)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>@lang('tournament list',['model' => 10])</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('are on the list')}}</th>
                                            <th>{{trans('user')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tournaments as $tournament)
                                            @if($tournament->type == 10)
                                                <tr>
                                                    <td>{{$tournament->number}}</td>
                                                    <td>{{$this->get_starred(optional($tournament->user)->email)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>@lang('tournament list',['model' => 20])</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('are on the list')}}</th>
                                            <th>{{trans('user')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tournaments as $tournament)
                                            @if($tournament->type == 20)
                                                <tr>
                                                    <td>{{$tournament->number}}</td>
                                                    <td>{{$this->get_starred(optional($tournament->user)->email)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
