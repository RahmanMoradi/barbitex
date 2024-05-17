<div class="spinner-grow text-primary {{$loading ? '' : 'd-none'}}" id="loader" role="status"
     style="position: fixed;top: 50%;right: 50%;z-index: 9999;">
    <span class="sr-only">Loading...</span>
</div>

<script>
        // Livewire.hook('message.sent', (message, component) => {
        //     $('#loader').removeClass('d-none')
        //     console.log('sent')
        // })
        //
        // Livewire.hook('message.processed', (message, component) => {
        //     console.log('processed')
        //     $('#loader').addClass('d-none')
        // })
</script>
