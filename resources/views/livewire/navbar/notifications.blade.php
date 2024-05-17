<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#"
       data-toggle="dropdown">
        <i class="ficon feather icon-bell"></i>
        <span
            class="badge badge-pill badge-primary badge-up">{{$notificationCount}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <div class="dropdown-header m-0 p-2">
                <h3 class="white">{{$notificationCount}}
                    اعلان </h3>
                <span class="notification-title">جدید برنامه</span>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @foreach($unreadNotifications as $notification)
                <a class="d-flex justify-content-between"
                   href="{{url($notification->data['url'])}}">
                    <div class="media d-flex align-items-start">
                        <div class="media-left">
                            <i class="feather icon-check-circle font-medium-5 warning"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="warning media-heading">{{$notification->data['subject']}}</h6>
                            <small
                                class="notification-text">{{$notification->data['message']}}</small>
                        </div>
                        <small>
                            <time class="media-meta"
                                  datetime="2015-06-11T18:29:20+08:00">
                                {{--                                {{$notification->created_at}}--}}
                                {{\Morilog\Jalali\Jalalian::forge($notification->created_at)->ago()}}
                            </time>
                        </small>
                    </div>
                </a>
            @endforeach
        </li>
        <li class="dropdown-menu-footer">
            <a class="dropdown-item p-1 text-center"
               href="javascript:void(0)" wire:click="markAll">
                دیدن تمام اعلان ها
            </a>
        </li>
    </ul>
</li>
