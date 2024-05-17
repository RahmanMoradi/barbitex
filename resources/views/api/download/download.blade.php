<div class="modal" id="application-download" tabindex="-1" role="dialog" style="z-index: 999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{asset('uploads/application/download.png')}}">
            </div>
            <div class="modal-footer">
                <button id="btnCloseModal" type="button" class="btn btn-secondary" data-dismiss="modal">متوجه شدم</button>
                <a href="{{url('#reservation')}}" onclick="closeModal()"  type="button" class="btn btn-primary">دانلود</a>
            </div>
        </div>
    </div>
</div>
<button id="btn-application-download" type="button" class="btn btn-primary" data-toggle="modal"
        data-target="#application-download" style="display: none">
</button>
<script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('#btn-application-download').click()
    }
    function closeModal(){
        $('#btnCloseModal').click()
    }

</script>
