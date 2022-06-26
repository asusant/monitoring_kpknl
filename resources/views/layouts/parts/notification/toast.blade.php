<script>
    @if ($errors->any())
        @foreach ($errors->all() as $err)
            Toastify({
                text: "{{ $err }}",
                duration: 3000,
                close:true,
                gravity:"top",
                position: "right",
                backgroundColor: "linear-gradient(to bottom, #ff0066 0%, #ff0000 100%)",
            }).showToast();
        @endforeach
    @endif
</script>
