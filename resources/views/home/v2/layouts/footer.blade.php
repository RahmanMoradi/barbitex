<!-- Footer -->

<footer id="site-footer" class="footer ">

    <canvas id="can"></canvas>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12">
                <div class="widget w-info">
                    <a href="/" class="site-logo">
                        <img src="{{asset(Setting::get('logo'))}}" alt="{{Setting::get('title')}}"
                             style="height: 100px">
                    </a>
                    <p>با تاج کوین در دنیای رمز ارزها پادشاهی کن</p>
                </div>

                <div class="widget w-contacts">
                    <ul class="socials socials--white">
                        <li class="social-item">
                            <a href="#">
                                <i class="fab fa-twitter woox-icon"></i>
                            </a>
                        </li>

                        <li class="social-item">
                            <a href="#">
                                <i class="fab fa-dribbble woox-icon"></i>
                            </a>
                        </li>

                        <li class="social-item">
                            <a href="#">
                                <i class="fab fa-instagram woox-icon"></i>
                            </a>
                        </li>

                        <li class="social-item">
                            <a href="#">
                                <i class="fab fa-linkedin-in woox-icon"></i>
                            </a>
                        </li>

                        <li class="social-item">
                            <a href="#">
                                <i class="fab fa-facebook-square woox-icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12">

                    <span>1400 © همه حقوق مادی و معنوی محفوظ می باشد</span>
                    <span><a href="/">تاج کوین</a> - وب سایت جهانی رمز ارز و معاملات دیجیتال</span>

                    <div class="logo-design">
                        <img src="/Home3/img/logo-fire.png" alt="team-tech">
                        <div class="design-wrap">
                            <div class="sup-title">طراحی توسط</div>
                            <a href="https://webazin.net" class="logo-title">وب آذین</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <a class="back-to-top" href="#">
        <svg class="woox-icon icon-top-arrow">
            <use xlink:href="#icon-top-arrow"></use>
        </svg>
    </a>
</footer>

<!-- ... end Footer -->
{!! Setting::get('script') !!}

<script src="/Home3/js/method-assign.js"></script>

<!-- jQuery first, then Other JS. -->

<script src="/Home3/js/jquery-3.3.1.js"></script>

<script src="/Home3/js/js-plugins/leaflet.js"></script>
<script src="/Home3/js/js-plugins/MarkerClusterGroup.js"></script>
<script src="/Home3/js/js-plugins/crum-mega-menu.js"></script>
<script src="/Home3/js/js-plugins/waypoints.js"></script>
<script src="/Home3/js/js-plugins/jquery-circle-progress.js"></script>
<script src="/Home3/js/js-plugins/segment.js"></script>
<script src="/Home3/js/js-plugins/bootstrap.js"></script>
<script src="/Home3/js/js-plugins/imagesLoaded.js"></script>
<script src="/Home3/js/js-plugins/jquery.matchHeight.js"></script>
<script src="/Home3/js/js-plugins/jquery-countTo.js"></script>
<script src="/Home3/js/js-plugins/Headroom.js"></script>
<script src="/Home3/js/js-plugins/jquery.magnific-popup.js"></script>
<script src="/Home3/js/js-plugins/popper.min.js"></script>
<script src="/Home3/js/js-plugins/particles.js"></script>
<script src="/Home3/js/js-plugins/perfect-scrollbar.js"></script>
<script src="/Home3/js/js-plugins/jquery.datetimepicker.full.js"></script>
<script src="/Home3/js/js-plugins/svgxuse.js"></script>
<script src="/Home3/js/js-plugins/select2.js"></script>
<script src="/Home3/js/js-plugins/smooth-scroll.js"></script>
<script src="/Home3/js/js-plugins/sharer.js"></script>
<script src="/Home3/js/js-plugins/isotope.pkgd.min.js"></script>
<script src="/Home3/js/js-plugins/ajax-pagination.js"></script>
<script src="/Home3/js/js-plugins/swiper.min.js"></script>
<script src="/Home3/js/js-plugins/material.min.js"></script>
<script src="/Home3/js/js-plugins/orbitlist.js"></script>
<script src="/Home3/js/js-plugins/highstock.js"></script>
<script src="/Home3/js/js-plugins/bootstrap-datepicker.js"></script>
<script src="/Home3/js/js-plugins/TimeCircles.js"></script>
<script src="/Home3/js/js-plugins/ion.rangeSlider.js"></script>

<!-- FontAwesome 5.x.x JS -->

<script defer src="/Home3/fonts/fontawesome-all.js"></script>

<script src="/Home3/js/main.js"></script>

<!-- SVG icons loader -->
<script src="/Home3/js/svg-loader.js"></script>
<!-- /SVG icons loader -->
@livewireScripts
</body>
</html>
