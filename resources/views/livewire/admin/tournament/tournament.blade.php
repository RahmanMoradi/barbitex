<section id="dashboard-analytics">
    <div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>{{trans('add user to tournaments')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="form-group">
                                <label for="user">{{trans('are on the list')}}</label>
                                <input id="user" type="email" class="form-control" wire:model.lazy="user"
                                       placeholder="{{trans('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="tournament">{{trans('tournament')}}</label>
                                <select wire:model.lazy="tournament" id="tournament" class="form-control">
                                    <option value="">{{trans('select')}}</option>
                                    <option value="5">{{trans('million',['model' => 5])}}</option>
                                    <option value="10">{{trans('million',['model' => 10])}}</option>
                                    <option value="20">{{trans('million',['model' => 20])}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="list">{{trans('are on the list')}}</label>
                                <input id="list" type="number" class="form-control" wire:model.lazy="listNumber">
                            </div>
                            @if($edit)
                                <button class="btn btn-success"
                                        wire:click="update({{$model}})">{{trans('edit')}}</button>
                            @else
                                <button class="btn btn-success" wire:click="store">{{trans('submit')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{trans('tournament list',['model' => '5'])}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>{{trans('user')}}</th>
                                        <th>{{trans('are on the list')}}</th>
                                        <th>{{trans('action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tournaments as $tournament)
                                        @if($tournament->type == 5)
                                            <tr>
                                                <td>{{optional($tournament->user)->email}}</td>
                                                <td>{{$tournament->number}}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-danger btn-sm"
                                                                wire:click="delete({{$tournament}})">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                        <button class="btn btn-info btn-sm"
                                                                wire:click="edit({{$tournament}})">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                </td>
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
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{trans('tournament list',['model' => '10'])}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>{{trans('user')}}</th>
                                        <th>{{trans('are on the list')}}</th>
                                        <th>{{trans('action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tournaments as $tournament)
                                        @if($tournament->type == 10)
                                            <tr>
                                                <td>{{optional($tournament->user)->email}}</td>
                                                <td>{{$tournament->number}}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-danger btn-sm"
                                                                wire:click="delete({{$tournament}})">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                        <button class="btn btn-info btn-sm"
                                                                wire:click="edit({{$tournament}})">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                </td>
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
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{trans('tournament list',['model' => '20'])}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>{{trans('user')}}</th>
                                        <th>{{trans('are on the list')}}</th>
                                        <th>{{trans('action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tournaments as $tournament)
                                        @if($tournament->type == 20)
                                            <tr>
                                                <td>{{optional($tournament->user)->email}}</td>
                                                <td>{{$tournament->number}}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-danger btn-sm"
                                                                wire:click="delete({{$tournament}})">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                        <button class="btn btn-info btn-sm"
                                                                wire:click="edit({{$tournament}})">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                </td>
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
</section>
