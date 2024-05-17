<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"

          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="{{Setting::get('meta_description')}}"/>
    <meta name="keywords" content="{{Setting::get('meta_key')}}"/>
    <meta name="author" content="webazin.net"/>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="{{Setting::get('meta_description')}}"/>
    <meta name="keywords" content="{{Setting::get('meta_key')}}"/>
    <meta name="author" content="webazin.net"/>

    <title>{{Setting::get('title')}}</title>

    <!-- Favicon and Touch Icons -->
    <link href="{{asset(Setting::get('favicon'))}}" rel="shortcut icon" type="image/png">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="144x144">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    {{-- <script src="/v4/tailwind.min.js"></script>--}}
    <link rel="stylesheet" type="text/css" href="/Home3/fonts/iranyekan/css/style.css">

    <script>
        tailwind.config = {
            darkMode: 'class', // or 'media'
            theme: {
                display: ["group-hover"],
                extend: {
                    fontFamily: {
                        sans: ['Outfit',],
                    },
                    colors: ({colors}) => ({
                        custom: colors.cyan,
                    }),
                },
            },
        }
    </script>

    {!! Setting::get('script') !!}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>

<body>
<header id="header" class="header header-floating">
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800 border-b shadow-sm">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="/" class="flex items-center">
                <img src="{{asset(Setting::get('logo'))}}" class="mr-3 h-6 sm:h-9"
                     alt="{{Setting::get('title')}}"/>
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{Setting::get('title')}}</span>
            </a>
            <div class="flex items-center lg:order-2">
                @guest()
                    <a href="/panel"
                       class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">ورود/ثبت
                        نام</a>
                @else
                    <a href="/panel"
                       class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">پنل
                        کاربری</a>
                @endguest
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="{{route('home.page.show',['page' => 'راهنمای-استفاده'])}}"
                           class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white"
                           aria-current="page">راهنمای استفاده</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page' => 'کارمزد'])}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">کارمزد</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page' => 'سوالات-متداول'])}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">سوالات
                            متداول</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page' => 'قوانین-و-مقررات'])}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">قوانین</a>
                    </li>
                    @if (\App\Helpers\Helper::modules()['application'])
                        <li>
                            <a href="{{route('home.page.show',['page' => 'دانلود-اپلیکیشن'])}}"
                               class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">دانلود
                                اپ</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{route('home.blog')}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">وبلاگ</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page' => 'درباره-ما'])}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">درباره
                            ما</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page' => 'تماس-با-ما'])}}"
                           class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">تماس
                            با ما</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="bg-gray-50 grid grid-cols-1 md:grid-cols-2 p-5 md:p-10 items-center">
    <div class="text-center">
        <h2 class="font-bold text-2xl">{{Setting::get('description')}}</h2>
    </div>
    <div class="text-center">
        <img src="{{asset('/Home4/img/slider.png')}}" alt="">
    </div>
</div>
<div class="bg-gray-50 border-b">
    <div class="w-full md:w-[75%] mx-auto grid grid-cols-2 md:grid-cols-4 p-5">
        <div>
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#70849C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="pingi-rtl-1cmn0cd">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                </svg>
                <h3 class="mr-2 md:mr-5 font-bold">احراز هویت آسان</h3>
            </div>
            <p class="text-mouted mt-2 md:mt-3 text-sm">احراز هویت در کمتر زمان ممکن</p>
        </div>
        <div>
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#70849C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="pingi-rtl-1cmn0cd">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                </svg>
                <h3 class="mr-2 md:mr-5 font-bold">کیف پول ریالی و ارزی</h3>
            </div>
            <p class="text-mouted mt-2 md:mt-3 text-sm">نگهداری ریال و ارز دیجیتال به صورت مطمئن</p>
        </div>
        <div>
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#70849C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="pingi-rtl-1cmn0cd">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                </svg>
                <h3 class="mr-2 md:mr-5 font-bold">پشتیبانی 24 ساعته</h3>
            </div>
            <p class="text-mouted mt-2 md:mt-3 text-sm">پشتیبانی آنلاین 24 ساعت در هفت روز هفته</p>
        </div>
        <div>
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#70849C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="pingi-rtl-1cmn0cd">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                </svg>
                <h3 class="mr-2 md:mr-5 font-bold">خرید و فروش آسان</h3>
            </div>
            <p class="text-mouted mt-2 md:mt-3 text-sm">خرید و فروش به صورت کاملا حرفه ای و آسان</p>
        </div>
    </div>
</div>
<div class="p-5 w-[75%] mx-auto mt-5 h-[250px] overflow-hidden">
    <h2 class="font-bold text-2xl">صرافی ارز دیجیتال</h2>
    <p class="mt-3 leading-9">
        صرافی ارز دیجیتال {{Setting::get('title')}} با بیش از 4 سال سابقه فعالیت در حوزه ارزهای دیجیتال، یکی از پلتفرم
        های معتبر ایرانی
        در زمینه فروش و خرید ارز دیجیتال شناخته می شود. در این صرافی امکان معامله بیش از 250 ارز دیجیتال از جمله بیت
        کوین (BTC)، خرید تتر (USDT)، خرید اتریوم (ETH)، خرید دوج کوین (DOGE)، خرید شیبا (SHIB) و ... را برای کاربران
        فراهم کرده است. جالب است بدانید صرافی ..... به صورت 24 ساعته و شبانه روزی بدون تعطیلی در تمامی روزهای هفته
        فعال و معامله گران می توانند نسبت به خرید و فروش رمزارزها همراه با پشتیبانی سریع و 24 ساعته اقدام کنند.
    </p>
    <h2 class="font-bold text-2xl mt-5">
        ارز دیجیتال چیست و چرا باید ارز دیجیتال بخریم؟
    </h2>
    <p class="mt-3 leading-9">
        ارز دیجیتال یا Cryptocurrency که معادل فارسی آن رمز ارز است، نوعی پول دیجیتال است که فقط بصورت دیجیتالی وجود
        دارد و به صورت دیجیتال هم نگهداری و منتقل می‌شود. این ارزها شکل فیزیکی ندارند، یعنی همانند پول های فیات به
        شکل دلار یا تومان قابل لمس نیستند. ارزهای دیجیتال به صورت غیر متمرکز و در بستر شبکه بلاک چین فعالیت می‌کنند
        و با استفاده از پروتکل‌های رمز گذاری شده بسیار قوی و پیچیده‌ای طراحی می شوند.

        بیت کوین به عنوان اولین ارز دیجیتال و با لقب پادشاه ارزهای دیجیتال در دنیای کریپتو کارنسی شناخته می شود. بیت
        کوین با نماد BTC توسط فرد ناشناسی به نام ساتوشی ناکاموتو در سال 2009 و تحت الگوریتم اثبات کار (prof of work)
        که آن را یک ارز قابل استخراج می کند توسعه یافت و عرضه شد. نقل و انتقال و نگهداری ارزهای دیجیتال از طریق کیف
        پول‌های نرم‌افزاری که روی موبایل و کامپیوتر نصب می‌شوند و یا کیف پولهای سخت افزاری که شبیه فلش مموری هستند
        انجام می‌شود.

        ارزهای دیجیتال مزیت‌های بسیار زیادی در مقابل سایر ارزهای موجود دارند که در ادامه به معرفی برخی از این مزیت
        ها می پردازیم:

        انجام معاملات ارز دیجیتال مشمول مالیات نمی‌شود به همین دلیل به ویژه برای معاملات با حجم بالا بسیار به صرفه
        می‌باشد.
        امکان انجام این معاملات در همه جهان و به صورت 24 ساعته وجود دارد.
        امنیت بالا، سرعت بالا، رشد تصاعدی، سوددهی بالا، تنوع بالا برای انتخاب سرمایه گذاری، مستقل بودن، مهار تورم و
        شفافیت
    </p>
    <h2 class="font-bold text-2xl mt-5">
        آموزش نحوه خرید و فروش ارز دیجیتال
    </h2>
    <p class="mt-3 leading-9">
        در صورتی که علاقمندید وارد دنیای ارزهای دیجیتال شوید و در این بازار پر نوسان سرمایه گذاری کنید، ابتدا باید
        یک صرافی معتبر انتخاب کنید. در انتخاب صرافی به مواردی مثل امنیت، کارمزد معاملات، کوین ها و توکن های موجود در
        صرافی و ساعات پشتیبانی و شفایفت در محل فعالیت آن ها را حتما مد نظر قرار دهید. شما میتوانید با ثبت نام در
        صرافی ارز دیجیتال .... بیش از 250 ارز دیجیتال معتبر را خرید و فروش کنید و یا از کیف پول های اختصاصی با آدرس
        ثابت این صرافی برای هولد و نگهداری رمز ارزهای خود بهره مند شوید. برای ثبت نام و شروع معاملات در صرافی ....
        مراحل زیر را دنبال کنید:
    </p>
</div>
<div class="flex p-5 w-75 mt-3 justify-center">
    <button class="flex text-blue-500 items-center justify-center cursor-pointer">
        <p>نمایش بیشتر</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6l6 -6"></path>
        </svg>
    </button>
</div>
<div class="mt-5 border rounded w-full md:w-4/5 md:mx-auto p-5 m-1 md:m-0" x-data="calculator">
    <div class="w-full md:w-[300px] bg-gray-300 rounded p-1 grid grid-cols-2">
        <button x-show="type === 'buy'" class="rounded bg-green-400 p-2 text-white">خرید ارز دیجیتال</button>
        <button x-show="type === 'buy'" class="">فروش ارز دیجیتال</button>
        <button x-show="type === 'sell'" class="">خرید ارز دیجیتال</button>
        <button x-show="type === 'sell'" class="rounded bg-green-400 p-2 text-white">فروش ارز دیجیتال</button>
    </div>
    <div class="flex items-center justify-between flex-col md:flex-row">
        <div class="flex flex-col mt-5">
            <h5 class="text-lg font-bold">مبلغ (پرداخت می کنید)</h5>
            <div class="flex border rounded items-center mt-2">
                <input type="text" class="focus:outline-none w-2/3 p-3" x-model="send">
                <div class="flex items-center justify-between" x-show="type === 'buy'">
                    <img src="/images/iran.svg" alt="تومان" class="h-10">
                    <h6 class="text-lg mr-5 ml-5">تومان</h6>
                </div>
                <div class="flex items-center justify-between" x-show="type === 'sell'">
                    <img src="{{$marketsTable[0]->iconUrl}}" alt="{{$marketsTable[0]->name}}" class="h-10">
                    <h6 class="text-lg mr-5 ml-5">{{$marketsTable[0]->name}}</h6>
                </div>
            </div>
        </div>
        <button class="border rounded-full border-green-300 p-3 mt-12" type="button" @click="changeType">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="#787878" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="tabler-icon tabler-icon-arrows-exchange-2">
                <path d="M17 10h-14l4 -4"></path>
                <path d="M7 14h14l-4 4"></path>
            </svg>
        </button>
        <div class="flex flex-col mt-5">
            <h5 class="text-lg font-bold">مبلغ (دریافت می کنید)</h5>
            <div class="flex border rounded items-center mt-2">
                <input readonly type="text" class="focus:outline-none w-2/3 p-3" x-model="receive">
                <div class="flex items-center justify-between" x-show="type === 'buy'">
                    <img src="{{$marketsTable[0]->iconUrl}}" alt="{{$marketsTable[0]->name}}" class="h-10">
                    <h6 class="text-lg mr-5 ml-5">{{$marketsTable[0]->name}}</h6>
                </div>
                <div class="flex items-center justify-between" x-show="type === 'sell'">
                    <img src="/images/iran.svg" alt="تومان" class="h-10">
                    <h6 class="text-lg mr-5 ml-5">تومان</h6>
                </div>
            </div>
        </div>
        <a href="{{route('order.create')}}" class="rounded bg-green-400 px-3 md:px-2 p-2 text-white mt-5 md:mt-12">شروع
            معامله</a>
    </div>
</div>

<div class="w-full bg-blue-600 flex flex-col md:flex-row justify-between mt-10 mb-0 p-5 text-white">
    <p>جهت خرید و فروش ارز دیجیتال و استفاده از خدمات ما ثبت نام کنید</p>
    <a href="{{url('panel')}}" class="bg-red-600 p-5 py-1 rounded border-red-800 text-center mt-2 md:mt-0">ثبت نام /
        ورود</a>
</div>
<footer class="bg-white dark:bg-gray-900 border-t">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <img src="{{Setting::get('logo')}}" class="h-8 me-3" alt="{{Setting::get('title')}}"/>
                    <span
                        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{Setting::get('title')}}</span>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">لینک ها</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{route('order.create')}}" class="hover:underline">خرید و فروش ارز</a>
                        </li>
                        <li>
                            <a href="{{url('panel')}}" class="hover:underline">پنل کاربری</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">شبکه های اجتماعی</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{Setting::get('instagram')}}" class="hover:underline ">اینستاگرام</a>
                        </li>
                        <li>
                            <a href="{{Setting::get('telegram')}}" class="hover:underline">تلگرام</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">قوانین</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{route('home.page.show',['page' => 'قوانین-و-مقررات'])}}" class="hover:underline">حریم
                                خصوصی</a>
                        </li>
                        <li>
                            <a href="{{route('home.page.show',['page' => 'قوانین-و-مقررات'])}}" class="hover:underline">قوانین
                                و مقررات</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"/>
        <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a
                        href="/" class="hover:underline">{{Setting::get('title')}}™</a>. All Rights Reserved.
                </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 8 19">
                        <path fill-rule="evenodd"
                              d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Facebook page</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 21 16">
                        <path
                            d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
                    </svg>
                    <span class="sr-only">Discord community</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 17">
                        <path fill-rule="evenodd"
                              d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Twitter page</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">GitHub account</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Dribbble account</span>
                </a>
            </div>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('calculator', () => ({
            init() {
                this.$watch('type', (value) => {
                    this.send = this.receive
                })
                this.$watch('send', (value) => {
                    this.changeSend(value)
                })
            },
            type: 'buy',
            send: 0,
            receive: 0,
            currency: {!! $marketsTable[0] !!},

            changeType() {
                this.type = this.type === 'buy' ? 'sell' : 'buy'
            },
            changeSend(value) {
                if (this.type === 'buy')
                    this.receive = (value / this.currency.send_price).toFixed(this.currency.decimal)
                else
                    this.receive = (value * this.currency.receive_price).toFixed(0)
            }
        }))
    });
</script>
</body>

</html>
