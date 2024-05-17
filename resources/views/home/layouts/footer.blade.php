<!-- Footer -->
<footer id="footer" class="footer bg-black-111">
    <div class="container pt-70 pb-40">
        <div class="row border-bottom-black">
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <img class="mt-10 mb-20" alt="" height="100" src="{{Setting::get('logo')}}">
                    <p>{{Setting::get('address')}}</p>
                    <ul class="mt-5">
                        <li class="m-0 pl-0 pr-10"><i class="fa fa-phone text-theme-colored mr-5"></i> <a
                                class="text-gray" href="#">{{Setting::get('phone')}}</a></li>
                        <li class="m-0 pl-0 pr-10"><i class="fa fa-envelope-o text-theme-colored mr-5"></i> <a
                                class="text-gray" href="#">{{Setting::get('email')}}</a></li>
                        <li class="m-0 pl-0 pr-10"><i class="fa fa-globe text-theme-colored mr-5"></i> <a
                                class="text-gray" href="#">{{url('/')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title line-bottom">لینک های مفید</h5>
                    <ul class="list-border">
                        <li><a href="/"> خانه</a></li>
                        <li><a href="{{route('home.page.show',['page'=>'درباره-ما'])}}">درباره ما</a></li>
                        <li><a href="{{route('home.page.show',['page'=>'سوالات-متداول'])}}">سوالات متداول</a></li>
                        <li><a href="{{route('home.page.show',['page'=>'تماس-با-ما'])}}">ارتباط با ما</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <h5 class="widget-title line-bottom">آخرین اخبار</h5>
                    <div class="latest-posts">
                        @foreach($articlesFooter as $article)
                            <article class="post media-post clearfix pb-0 mb-10">
                                <a href="{{url('blog',['slug' => $article->slug])}}" class="post-thumb">
                                    <img alt="" height="55" width="80" src="{{$article->image_url}}">
                                </a>
                                <div class="post-right">
                                    <h5 class="post-title mt-0 mb-5">
                                        <a href="{{url('blog',['slug' => $article->slug])}}">
                                            {{$article->title}}
                                        </a>
                                    </h5>
                                    <p class="post-date mb-0 font-12">{{$article->created_at_fa}}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    @if(\App\Helpers\Helper::modules()['application'])
                        <h5 class="widget-title line-bottom"> دانلود اپلیکیشن</h5>
                        <div class="opening-hours">
                            <ul class="list-border">
                                <li class="clearfix">
                                    <div class="value pull-right flip">
                                        <a href="http://cafebazaar.ir/app/com.ipoolex.ipoolex" target="_blank">
                                            <img src="{{asset('uploads/application/bazar.png')}}" alt="">
                                        </a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="value pull-right flip">
                                        <a href="https://myket.ir/app/com.ipoolex.ipoolex" target="_blank">
                                            <img src="{{asset('uploads/application/myket.png')}}" alt="">
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @else
                        <h5 class="widget-title line-bottom"> ساعات کاری</h5>
                        <div class="opening-hours">
                            <ul class="list-border">
                                <li class="clearfix"><span> هفت روز هفته :  </span>
                                    <div class="value pull-right flip"> 24 ساعته</div>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-black-222">
        <div class="container pt-20 pb-20">
            <div class="row">
                <div class="col-md-6 sm-text-center">
                    <p class="font-13 text-black-777 m-0">Copyright &copy;2018 تمام حقوق محفوظ است</p>
                    <b class="font-13 text-black-777 m-0">
                        <a href="https://webazin.net/%d8%b7%d8%b1%d8%a7%d8%ad%db%8c-%d8%b3%d8%a7%db%8c%d8%aa-%d8%b5%d8%b1%d8%a7%d9%81%db%8c-%d8%a7%d8%b1%d8%b2-%d8%af%db%8c%d8%ac%db%8c%d8%aa%d8%a7%d9%84/" target="_blank">
                        طراحی سایت صرافی ارز دیجیتال
                        </a>
                    </b>
                </div>
                <div class="col-md-6 text-right flip sm-text-center">
                    <div class="widget no-border m-0">
                        <ul class="styled-icons icon-dark icon-circled icon-sm">
                            <li style="display: {{Setting::get('whatsapp') ? '' :'none'}}"><a
                                    href="{{Setting::get('whatsapp')}}"><i class="fa fa-whatsapp"></i></a></li>
                            <li style="display: {{Setting::get('telegram') ? '' :'none'}}"><a
                                    href="{{Setting::get('telegram')}}"><i class="fa fa-telegram"></i></a></li>
                            <li style="display: {{Setting::get('facebook') ? '' :'none'}}"><a
                                    href="{{Setting::get('facebook')}}"><i class="fa fa-facebook"></i></a></li>
                            <li style="display: {{Setting::get('twitter') ? '' :'none'}}"><a
                                    href="{{Setting::get('twitter')}}"><i class="fa fa-twitter"></i></a></li>
                            <li style="display: {{Setting::get('skype') ? '' :'none'}}"><a
                                    href="{{Setting::get('skype')}}"><i class="fa fa-skype"></i></a></li>
                            <li style="display: {{Setting::get('youtube') ? '' :'none'}}"><a
                                    href="{{Setting::get('youtube')}}"><i class="fa fa-youtube"></i></a></li>
                            <li style="display: {{Setting::get('instagram') ? '' :'none'}}"><a
                                    href="{{Setting::get('instagram')}}"><i class="fa fa-instagram"></i></a></li>
                            <li style="display: {{Setting::get('pinterest') ? '' :'none'}}"><a
                                    href="{{Setting::get('pinterest')}}"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="/home/js/custom.js"></script>
<script src="/js/app.js" defer></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS
      (Load Extensions only on Local File Systems !
       The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript"
        src="/home/js/revolution-slider/js/extensions/revolution.extension.video.min.js"></script>
<script src="{{asset('/js2/app.js')}}" defer></script>
@livewireScripts
</body>
</html>
