<div id="pe-overlay-backdrop" style="display: none">
    <div id="pushengage-overlay-close" onclick="dNone('none')"></div>
    <div id="pe-overlay-text" style="left: 0!important; margin: 0px;">
        <div id="pe-overlay-arrow"></div>
        <!--            <div>Click on Allow button and Subscribe to the push notifications</div>-->
        <div>جهت دریافت نوتیفیکیشن ها، دکمه allow را کلیک کنید.</div>
    </div>
</div>
<style>
    #pe-overlay-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 2147483638;
        background-color: rgba(0, 0, 0, 0.8);
    }

    #pushengage-overlay-close {
        position: absolute;
        right: 20px;
        top: 30px;
        width: 55px;
        height: 32px;
        cursor: pointer;
    }

    #pushengage-overlay-close:before, #pushengage-overlay-close:after {
        position: fixed;
        right: 48px;
        content: " ";
        height: 33px;
        width: 3px;
        background-color: #ffffff;
    }

    #pushengage-overlay-close:after {
        transform: rotate(-45deg);
    }

    #pushengage-overlay-close:before {
        transform: rotate(45deg);
    }

    #pe-overlay-backdrop #pe-overlay-text {
        position: absolute;
        top: 190px;
        left: 0;
        /*right: 0;*/
        margin: 0 auto;
        max-width: 500px;
        color: white;
        font-size: larger;
    }

    #pe-overlay-backdrop #pe-overlay-arrow {
        width: 60px;
        height: 80px;
        background-size: contain;
        transform: rotate(160deg);
        background-image: url('/images/icons/arrow.png');
        background-repeat: no-repeat;
    }
</style>
<script>
    function dNone(val) {
        $("#pe-overlay-backdrop").css('display', val)
    }
</script>
